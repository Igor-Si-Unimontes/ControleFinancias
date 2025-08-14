<?php

use App\Http\Controllers\CategorySpendController;
use App\Http\Controllers\GainController;
use App\Http\Controllers\GPTSpendController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SpendController;
use App\Http\Controllers\testeqrcode;
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
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index')->middleware('auth');
Route::post('/reports', [ReportController::class, 'filterForDateRange'])->name('reports.filter')->middleware('auth');
Route::get('/reports/pdf', [ReportController::class, 'generatePdf'])->name('reports.pdf');
Route::resource('qrcode', testeqrcode::class)->middleware('auth')->names('qrcode');
Route::get('/gasto/gpt', [GPTSpendController::class, 'index'])->middleware('auth')->name('gasto.gpt');
Route::post('/gasto/gpt', [GPTSpendController::class, 'interpretar'])->middleware('auth');


