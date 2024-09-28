<?php

use App\Http\Controllers\Admin\Attribute\AttributeController;
use App\Http\Controllers\admin\setting\GeneralSettingController;

Route::group([
    'prefix' => 'setting',
    'as' => 'setting.'
], function () {
    Route::get('/', [GeneralSettingController::class, 'index'])->name('index');
    Route::post('/update', [GeneralSettingController::class, 'create'])->name('update');
    Route::get('/update', [GeneralSettingController::class, 'image'])->name('image');

});

//Route::resource('attribute', AttributeController::class);
