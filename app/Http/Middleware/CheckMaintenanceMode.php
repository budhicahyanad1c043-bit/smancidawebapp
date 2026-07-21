<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $setting = Setting::first();

        // Jika mode maintenance diaktifkan oleh admin
        if ($setting && $setting->is_maintenance) {
            
            // Izinkan Admin/User yang sedang login & rute login/logout untuk tetap bisa diakses
            if (Auth::check() || $request->is('login') || $request->is('logout') || $request->is('dashboard*')) {
                return $next($request);
            }

            // Alihkan publik ke halaman maintenance
            return response()->view('errors.maintenance', [], 503);
        }
        return $next($request);
    }
}
