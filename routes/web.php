<?php

use Illuminate\Support\Facades\Route;
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

// ==========================================
// 1. RUTE HALAMAN DEPAN PUBLIK
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rute Berita
Route::get('/berita', [FrontPostController::class, 'index'])->name('front.posts.index');
Route::get('/berita/{slug}', [FrontPostController::class, 'show'])->name('front.posts.show-post');

// Rute Pengumuman
Route::get('/pengumuman', [FrontAnnouncementController::class, 'index'])->name('front.announcements.index');
Route::get('/pengumuman/{slug}', [FrontAnnouncementController::class, 'show'])->name('front.announcements.show');

// Rute Halaman Akun Non-Aktif (Harus Publik agar bisa diakses tanpa login)
Route::get('/account-suspended', function () {
    return view('errors.account-suspended');
})->name('account.suspended');


// ==========================================
// 2. RUTE AUTENTIKASI (LOGIN & LOGOUT)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ==========================================
// 3. RUTE DASHBOARD (HARUS LOGIN)
// ==========================================
Route::middleware(['auth', 'active.user'])->prefix('dashboard')->group(function () {
    
    // Halaman Dasbor Utama (Admin & Guru)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
            
    // Fitur Tambahan (Admin & Guru)
    Route::resource('categories', CategoryController::class);    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('galleries', GalleryController::class);
    Route::resource('extracurriculars', ExtracurricularController::class);
    Route::resource('posts', PostController::class);

    // Fitur HANYA ADMIN
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        
        Route::resource('menus', MenuController::class)->except(['create', 'edit', 'show']);
        
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');
    });

});