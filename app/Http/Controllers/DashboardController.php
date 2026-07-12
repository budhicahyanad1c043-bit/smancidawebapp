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

    public function updateSettings(Request $request)
    {
        // Proteksi Akun: Jika bukan admin, tendang keluar
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak! Anda bukan Administrator.');
        }
        
        $setting = Setting::first() ?? new Setting();
        
        // Tangkap data teks biasa
        $setting->school_name = $request->school_name;
        $setting->vision = $request->vision;
        $setting->principal_name = $request->principal_name;
        $setting->address = $request->address;
        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->website = $request->website;

        // Proses upload file Logo jika ada ganti baru
        if ($request->hasFile('logo')) {
            $logoName = 'logo_'.time().'.'.$request->logo->extension();
            $request->logo->move(public_path('images'), $logoName);
            $setting->logo = 'images/' . $logoName;
        }

        // Proses upload foto kepala sekolah jika ganti baru
        if ($request->hasFile('principal_photo')) {
            $photoName = 'kepsek_'.time().'.'.$request->principal_photo->extension();
            $request->principal_photo->move(public_path('images'), $photoName);
            $setting->principal_photo = 'images/' . $photoName;
        }

        $setting->save();
        return back()->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}
