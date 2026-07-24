<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user sedang terautentikasi (login)
        if (Auth::check()) {
            // Ambil data user yang sedang aktif dari database (segar/terbaru)
            $user = Auth::user()->fresh();

            // Jika status is_active bernilai false/0
            if ($user && !$user->is_active) {
                // Logout-kan session user secara paksa
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Alihkan langsung ke halaman account suspended
                return redirect()->route('account.suspended');
            }
        }
        return $next($request);
    }
}
