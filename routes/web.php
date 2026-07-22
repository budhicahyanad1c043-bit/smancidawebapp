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
use App\Http\Controllers\FrontPostController;
use App\Http\Controllers\MenuController;


// Rute Halaman Depan Publik
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rute untuk melihat semua artikel/berita
Route::get('/berita', [FrontPostController::class, 'index'])->name('front.posts.index');

// Rute untuk melihat detail artikel/berita berdasarkan slug
Route::get('/berita/{slug}', [FrontPostController::class, 'show'])->name('front.posts.show-post');

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
    
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    
    // Halaman Dasbor Utama (Bisa diakses Admin & Web-Journalist)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
            
    // Fitur yang BISA diakses ADMIN maupun GURU
    Route::resource('categories', CategoryController::class);    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('galleries', GalleryController::class);
    Route::resource('extracurriculars', ExtracurricularController::class);
    Route::resource('posts', PostController::class);

    
    // Fitur yang HANYA BISA diakses oleh ADMIN saja!
    Route::middleware(['role:admin'])->group(function () {
        // untuk mengakses menu kelola user
        Route::get('users', [UserController::class, 'users'])->name('users.index');
        Route::resource('users', UserController::class); // CRUD Manajemen User (Daftarin akun Guru baru)
        
        // Route Manajemen Menu Dinamis
        Route::resource('menus', MenuController::class)->except(['create', 'edit', 'show']);
        
        // Untuk mengakses menu settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');
    });

});

    
