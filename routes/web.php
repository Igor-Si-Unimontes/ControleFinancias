<?php

use App\Http\Controllers\CategorySpendController;
use App\Http\Controllers\GainController;
use App\Http\Controllers\SpendController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('home') : redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('spends', SpendController::class)->middleware('auth')->names('spends');
Route::resource('category_spends', CategorySpendController::class)->middleware('auth')->names('category_spends');
Route::resource('gains', GainController::class)->middleware('auth')->names('gains');
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
});
