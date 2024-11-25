<?php

use App\Http\Controllers\CarreraController;
use App\Http\Controllers\FacultadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['register' => false]);

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::resource('facultades', FacultadController::class);
    Route::resource('carreras', CarreraController::class);
});