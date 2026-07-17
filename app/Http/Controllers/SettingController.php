<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // Menampilkan halaman form pengaturan
    public function index()
    {
        $setting = Setting::first();
        return view('dashboard.settings', compact('setting'));
    }

    // Memproses pembaruan data dan upload gambar ke storage
    public function update(Request $request)
    {
        // Ambil data baris pertama atau buat baru jika kosong
        $setting = Setting::firstOrCreate(['id' => 1]);

        $request->validate([
            'school_name'        => 'required|string|max:255',
            'logo'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'principal_photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'principal_name'     => 'nullable|string|max:255',
            'vision'             => 'nullable|string',
            'email'              => 'nullable|email',
            'phone'              => 'nullable|string',
            'address'            => 'nullable|string',
            'website'            => 'nullable|url',
            'facebook_url'       => 'nullable|url',
            'instagram_url'      => 'nullable|url',
            'youtube_url'        => 'nullable|url',
            'welcome_message'    => 'nullable',
            'description_school' => 'nullable',
            'npsn'               => 'nullable|string',
        ]);

        // Ambil semua inputan kecuali file gambar
        $data = $request->except(['logo', 'principal_photo']);

        // 1. Proses Upload File Logo Sekolah asli ke Storage
        if ($request->hasFile('logo')) {
            // Hapus file logo lama di storage jika sebelumnya sudah ada
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            // Simpan file baru ke folder: storage/app/public/settings
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        // 2. Proses Upload File Foto Kepala Sekolah asli ke Storage
        if ($request->hasFile('principal_photo')) {
            // Hapus foto lama di storage jika sebelumnya sudah ada
            if ($setting->principal_photo) {
                Storage::disk('public')->delete($setting->principal_photo);
            }
            // Simpan file baru ke folder: storage/app/public/settings
            $data['principal_photo'] = $request->file('principal_photo')->store('settings', 'public');
        }

        // Update seluruh data di database dengan path storage yang baru
        $setting->update($data);

        return back()->with('success', 'Pengaturan website dan file media berhasil diperbarui ke storage fisik!');
    }
}