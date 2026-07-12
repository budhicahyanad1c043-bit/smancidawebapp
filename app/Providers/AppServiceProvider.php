<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // Kirim data setting khusus ke halaman login & layout admin
        // Tambahkan 'welcome' (atau nama file blade depan Anda) ke dalam array ini
        View::composer(['auth.login', 'dashboard.layouts.admin', 'layouts.app', 'landing'], function ($view) {
            $view->with('setting', \App\Models\Setting::first());
        });
    }
}
