<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;
use App\Http\Controllers\Api\BasicController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\FlightController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->name('api.')->group(function () {

    Route::namespace('Auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/forget-password', [ForgetPasswordController::class, 'sendForgetCodeEmail']);
       // Route::post('forget-password', [AuthController::class, 'sendForgetCodeEmail']);
       Route::post('/reset-password', [AuthController::class, 'resetPassword']);
       Route::get('unauthenticate', [AuthController::class, 'unauthenticate'])->name('unauthenticate');
       Route::post('veirfy-user-otp', [AuthController::class, 'verifyuserOtp']);
    });

    Route::get('airport-list', [FlightController::class, 'airportList']);
    Route::post('search-flight', [FlightController::class, 'searchFlight']);
    Route::post('availability', [FlightController::class, 'availability']);
    Route::get('faq', [BasicController::class, 'getFaq']);
    Route::post('customer-support', [BasicController::class, 'customerSupport']);
    Route::get('page/{slug}', [BasicController::class, 'getPages']);
    Route::get('airline', [BasicController::class, 'getAirlines']);

    Route::post('booking', [BookingController::class, 'index']);
    Route::post('payment', [BookingController::class, 'payment']);
    Route::middleware('auth.api:sanctum')->group(function () {


    });
});
