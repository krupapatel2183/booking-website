<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/submit/register', [RegisterController::class, 'postRegisterForm'])->name('submit.register');
Route::post('submit/login', [LoginController::class, 'postLogin'])->name('submit.login');
Route::get('/states/{id}', [LocationController::class, 'getStates']);
Route::get('/cities/{id}', [LocationController::class, 'getCities']);

Route::middleware(['auth.check'])->group(function () {
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');
});

Route::get('logout', [LoginController::class, 'adminPostLogout']);