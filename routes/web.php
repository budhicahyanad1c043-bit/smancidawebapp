<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\FrontAnnouncementController;
use App\Http\Controllers\GalleryController;

// Route::get('/', function () {
//     return view('landing');
// });

// Rute Halaman Depan Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita/{post:slug}', [HomeController::class, 'show'])->name('home.posts.show');

// Rute untuk melihat index semua pengumuman
Route::get('/pengumuman', [FrontAnnouncementController::class, 'index'])->name('front.announcements.index');
// Rute untuk membuka detail satu pengumuman berdasarkan slug
Route::get('/pengumuman/{slug}', [FrontAnnouncementController::class, 'show'])->name('front.announcements.show');

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
    Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('dashboard.users.main');
    // Pindahkan rute setting ke SettingController baru Anda di sini:
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    // Route manajemen user CRUD yang kita buat sebelumnya
    Route::resource('users', UserController::class)->except(['create', 'edit', 'show']);
    
    });
    
    Route::middleware(['auth'])->prefix('dashboard')->group(function () {
        // Rute bawaan resource mencakup index, create, store, edit, update, destroy
        // Route::resource('posts', PostController::class);
        // Fitur yang BISA diakses ADMIN maupun GURU
        Route::resource('categories', CategoryController::class);
        
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::resource('announcements', AnnouncementController::class);
        Route::resource('galleries', GalleryController::class);
        
// Fitur yang HANYA BISA diakses oleh ADMIN saja
Route::middleware(['role:admin'])->group(function () {
    Route::resource('users', UserController::class); // CRUD Manajemen User (Daftarin akun Guru baru)
    Route::get('/settings', [HomeController::class, 'settingsEdit']); // Edit settingan sekolah
});

});

Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
// Route resource otomatis mencakup index, create, store, edit, update, destroy
Route::resource('extracurriculars', ExtracurricularController::class);
});

Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    // Route resource otomatis akan membuat nama route: dashboard.posts.update, dashboard.posts.index, dll.
    Route::resource('posts', PostController::class);
    
});

    
