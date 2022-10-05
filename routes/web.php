<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::post('/block', [TestController::class, 'block'])->name('block');
Route::post('/blocked', [TestController::class, 'blocked'])->name('blocked');
Route::post('/unblocked', [TestController::class, 'unblocked'])->name('unblocked');
