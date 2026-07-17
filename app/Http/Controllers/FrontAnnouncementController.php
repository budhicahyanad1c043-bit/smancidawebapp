<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class FrontAnnouncementController extends Controller
{
    // Menampilkan semua pengumuman dengan pagination (misal 9 per halaman)
    public function index()
    {
        $announcements = Announcement::where('status', 'active')
                                     ->with('user')
                                     ->latest()
                                     ->paginate(9);

        return view('pengumuman.index', compact('announcements'));
    }

    // Menampilkan detail satu pengumuman
    public function show($slug)
    {
        $announcement = Announcement::where('slug', $slug)
                                    ->where('status', 'active')
                                    ->with('user')
                                    ->firstOrFail(); // Menampilkan 404 jika tidak ditemukan

        return view('pengumuman.show', compact('announcement'));
    }
}