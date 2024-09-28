<?php

use App\Http\Controllers\admin\auth\AdminLoginController;
use App\Http\Controllers\admin\auth\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\Vendor\VendorController;
use App\Http\Controllers\Admin\Attribute\AttributeController;
use App\Http\Controllers\Admin\Feed\FeedController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\Admin\Question\QuestionController;
use App\Http\Controllers\Admin\Apitype\ApitypeController;
use App\Http\Controllers\Admin\Setting\GeneralSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect('/admin/login');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
        Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
        Route::get('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
        Route::post('/update-password', [HomeController::class, 'updatePassword'])->name('password.update');
        Route::post('/update-profile', [HomeController::class, 'updateProfile'])->name('update.profile');
        Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
    });

     // Feeddata start //
        Route::get('/feeds', [FeedController::class, 'show'])->name('feed.show');
        Route::get('/feed/add', [FeedController::class, 'create'])->name('feed.create');
        Route::post('/feed/store', [FeedController::class, 'store'])->name('feed.store');
        Route::get('/feed/edit/{id}', [FeedController::class, 'edit'])->name('feed.edit');
        Route::patch('/feed/update/{id}', [FeedController::class, 'update'])->name('feed.update');
        Route::delete('/feed/{id}', [FeedController::class, 'delete'])->name('feed.delete');
        // Feed end //

    Route::group(['middleware' => 'admin.auth'], function () {
        include_route_files(__DIR__ . '/backend/');
    });
});
Route::get('/flights', [FlightController::class, 'showFlights'])->name('flights.show');
Route::post('/book-flight', [BookingController::class, 'bookFlight'])->name('booking.create');
Route::post('/process-payment', [PaymentController::class, 'process'])->name('payment.process');

// vendors start //
Route::get('/vendor', [VendorController::class, 'showVendor'])->name('vendor.show');
Route::get('/vendors', [VendorController::class, 'CreateVendor'])->name('vendor.create');
Route::post('/vendor/store', [VendorController::class, 'store'])->name('vendor.store');
Route::get('vendor/edit/{id}', [VendorController::class, 'vendorEdit'])->name('vendor.edit');
Route::patch('vendor/update/{id}', [VendorController::class, 'vendorUpdate'])->name('vendor.update');
Route::delete('/vendor/{id}', [VendorController::class, 'delete'])->name('vendor.delete');
 // vendors end //

 // Attribute start //
Route::get('/attribute', [AttributeController::class, 'show'])->name('attribute.show');
Route::get('/attributes', [AttributeController::class, 'create'])->name('attribute.create');
Route::post('/attribute/store', [AttributeController::class, 'store'])->name('attribute.store');
Route::get('attribute/edit/{id}', [AttributeController::class, 'edit'])->name('attribute.edit');
Route::patch('attribute/update/{id}', [AttributeController::class, 'update'])->name('attribute.update');
Route::delete('/attribute/{id}', [AttributeController::class, 'delete'])->name('attribute.delete');
 // Attribute end //



 // airlines start //

// Route::get('/airline', [AirlineController::class, 'showAirline'])->name('airline.show');
// Route::get('/airline', [AirlineController::class, 'CreateAirline'])->name('airline.create');
// Route::post('/airline/store', [AirlineController::class, 'store'])->name('airline.store');
// Route::get('airline/edit/{id}', [AirlineController::class, 'AirlineEdit'])->name('airline.edit');
// Route::patch('airline/update/{id}', [AirlineController::class, 'AirlineUpdate'])->name('airline.update');
// Route::delete('/airline/{id}', [AirlineController::class, 'delete'])->name('airline.delete');
 // airlines end  //

 //Booking start//
 Route::get('/booking',[BookingController::class,'ShowBooking'])->name('booking.show');
 Route::get('/booking/detail/{id}',[BookingController::class,'Detail'])->name('booking.detail');

 //Booking end//

 //airport start//
 Route::get('/airport',[AirportController::class,'showAirport'])->name('airport.show');
 Route::get('/airport/create',[AirportController::class,'createAirport'])->name('airport.create');
 Route::post('/airport/store',[AirportController::class,'storeAirport'])->name('airport.store');
 Route::get('/airport/detail/{id}',[AirportController::class,'AirportDetail'])->name('airport.detail');
 Route::get('/airport/edit/{id}',[AirportController::class,'EditAirport'])->name('airport.edit');
 Route::patch('airport/update/{id}', [AirportController::class, 'updateAirport'])->name('airport.update');

 Route::delete('/airport/{id}', [AirportController::class, 'deleteAirport'])->name('airport.delete');


 //airport end//

 //airlines start//
 Route::get('/airline',[AirlineController::class,'showAirline'])->name('airline.show');
 Route::get('/airline/create',[AirlineController::class,'CreateAirline'])->name('airline.create');
 Route::post('/airline/store',[AirlineController::class,'store'])->name('airline.store');
 Route::get('airline/edit/{id}', [AirlineController::class, 'AirlineEdit'])->name('airline.edit');
Route::patch('airline/update/{id}', [AirlineController::class, 'AirlineUpdate'])->name('airline.update');
Route::delete('/airline/{id}', [AirlineController::class, 'delete'])->name('airline.delete');
 //airlines end //
//question start//
 Route::get('/question',[QuestionController::class,'Show'])->name('question.show');
 Route::post('/question/store',[QuestionController::class,'Store'])->name('question.store');
 Route::patch('question/update/{id}', [QuestionController::class, 'Update'])->name('question.update');
 Route::delete('/question/{id}', [QuestionController::class, 'delete'])->name('question.delete');
 //question end//

 //apitype start//
 Route::get('/apitype',[ApitypeController::class,'ShowApi'])->name('apitype.show');
 Route::post('/apitype/store',[ApitypeController::class,'Store'])->name('apitype.store');
 Route::patch('apitype/update/{id}', [ApitypeController::class, 'Update'])->name('apitype.update');
 Route::delete('/apitype/{id}', [ApitypeController::class, 'delete'])->name('apitype.delete');

  //apitype end//
//   Route::post('/setting',[GeneralSettingController::class,'index'])->name('setting.index');
//   Route::post('/setting/create',[GeneralSettingController::class,'updateProfile'])->name('setting.create');