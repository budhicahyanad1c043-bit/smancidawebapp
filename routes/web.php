<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');

// Rute Halaman Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang WAJIB Login (Multiuser)
Route::middleware(['auth'])->group(function () {
    
    // Halaman Dasbor Utama (Bisa diakses Admin & Web-Journalist)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Pengelolaan User & Setting Website
    Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('users.index');
    Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->name('settings.index');
    Route::post('/dashboard/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');
});
