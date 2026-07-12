<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting; // Ganti sesuai dengan lokasi Model Setting Anda
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
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login'    => 'required|string', // bisa diisi email atau username
            'password' => 'required|string',
        ]);

        // Cek logika autentikasi (menggunakan email atau username)
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$fieldType => $request->login, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'login' => 'Kredensial yang Anda masukkan tidak cocok dengan data kami.',
        ])->onlyInput('login');
    }
}