<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Berbagi data dasar ke view dashboard
        return view('dashboard.index');
    }

    // --- FITUR KELOLA USER (Khusus Admin) ---
    public function users(Request $request)
    {
        // Proteksi Akun: Jika bukan admin, tendang keluar
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak! Anda bukan Administrator.');
        }
        
        $search = $request->input('search');
        
        // Fitur Search nama atau email
        $users = User::when($search, function($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);

        return view('dashboard.users', compact('users'));
    }

    // --- FITUR SETTING WEBSITE (Khusus Admin) ---
    public function settings()
    {
        // Proteksi Akun: Jika bukan admin, tendang keluar
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak! Anda bukan Administrator.');
        }

        // Mengambil baris pengaturan pertama atau buat baru jika kosong
        $setting = Setting::first() ?? new Setting();
        return view('dashboard.settings', compact('setting'));
    }

    
}
