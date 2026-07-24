<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        $setting = Setting::first();
        return view('auth.login', compact('setting'));
    }

    // Memproses aksi login
    // Memproses aksi login
    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Cek tipe input (email atau username)
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 3. Cek ketersediaan & status user terlebih dahulu
        $user = User::where($fieldType, $request->login)->first();

        if ($user && !$user->is_active) {
            return redirect()->route('account.suspended');
        }

        // 4. DEKLARASIKAN VARIABEL $credentials DI SINI
        $credentials = [
            $fieldType  => $request->login,
            'password'   => $request->password,
            'is_active'  => 1,
        ];

        // 5. Eksekusi Autentikasi
        if (Auth::attempt($credentials, $request->remember)) {
            
            // Catat waktu Last Login
            $authUser = Auth::user();
            $authUser->update([
                'last_login_at' => now(),
            ]);

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Jika gagal login
        return back()->withErrors([
            'login' => 'Kredensial yang Anda masukkan tidak cocok dengan data kami.',
        ])->onlyInput('login');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}