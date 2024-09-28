<?php

use App\Http\Controllers\Admin\Attribute\AttributeController;

Route::group([
    'prefix' => 'attribute',
    'as' => 'attribute.'
], function () {
    Route::get('/', [AttributeController::class, 'index'])->name('index');
    Route::get('/add', [AttributeController::class, 'create'])->name('add');
    Route::post('/insert', [AttributeController::class, 'insert'])->name('insert');
    Route::post('change-status', [AttributeController::class, 'changeStatus'])->name('change-status');
});

//Route::resource('attribute', AttributeController::class);
