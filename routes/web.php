<?php

use Illuminate\Support\Facades\Route;

// ONLY USED FOR 2 and 3.
use App\Http\Controllers\Admin\{
    PromotionalCodeController
};

Route::get('/', function () {
    return view('welcome');
});

// 1. YOUR CURRENT WEB.PHP
/*
Route::prefix('admin-panel')->group(function(){
    Route::group(['middleware' => 'auth'], function(){
        Route::resource('promotional-codes', App\Http\Controllers\Admin\PromotionalCodeController)->names('promotionalcodes');
    });
});
*/

/* 2. YOUR ORIGINAL VERSION WITHOUT PREFIX AND MIDDLEWARE */
// Route::resource('promotional-codes', PromotionalCodeController::class)->names('index');

/* 3. YOUR ORIGINAL VERSION WITHOUT PREFIX AND MIDDLEWARE AND NO 'NAMES'.
I find this better than using ->names('index') because then all your PromoCode routes are called index.index, index.show... etc, as opposed to promotional-code.index etc. 
Have a look at the output of php artisan route:list to see your routes. */
Route::resource('promotional-codes', PromotionalCodeController::class);

// 5. USING FULLY QUALIFIED CONTROLLER NAME (NO IMPORT NEEDED)
//Route::resource('promotional-codes', 'App\Http\Controllers\Admin\PromotionalCodeController');
