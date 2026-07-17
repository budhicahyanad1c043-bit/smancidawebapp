<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    // 1. Menampilkan daftar pengumuman di halaman dashboard admin
    public function index()
    {
        $announcements = Announcement::with('user')->latest()->paginate(10);
        return view('dashboard.announcements.index', compact('announcements'));
    }

    // 2. Menampilkan formulir tambah pengumuman
    public function create()
    {
        return view('dashboard.announcements.create');
    }

    // 3. Menyimpan pengumuman baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'type' => 'required|in:biasa,penting',
            'status' => 'required|in:draft,active',
        ]);

        Announcement::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(1000, 9999), // Mencegah slug kembar
            'content' => $request->content,
            'type' => $request->type,
            'status' => $request->status,
            'user_id' => auth()->id(), // Mengambil ID admin/guru yang sedang login
        ]);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil diterbitkan!');
    }

    // 4. Menampilkan formulir edit pengumuman
    public function edit(Announcement $announcement)
    {
        return view('dashboard.announcements.edit', compact('announcement'));
    }

    // 5. Memperbarui data pengumuman di database
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'type' => 'required|in:biasa,penting',
            'status' => 'required|in:draft,active',
        ]);

        $announcement->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(1000, 9999),
            'content' => $request->content,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    // 6. Menghapus pengumuman
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dihapus!');
    }
}