<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Extracurricular;
use App\Models\Gallery;

class HomeController extends Controller
{
    // Menampilkan halaman beranda publik
    public function index()
    {
        // Ambil 3 pengumuman aktif terbaru
        $announcements = Announcement::where('status', 'active')
                                    ->latest()
                                    ->take(3)
                                    ->get();

        // Ambil 8 foto galeri kegiatan terbaru
        $galleries = Gallery::latest()->take(8)->get();

        $announcements = Announcement::where('status', 'active')
                                 ->latest()
                                 ->take(3)
                                 ->get();

        $setting = Setting::first();
        // Hanya ambil berita yang statusnya diterbitkan (published)
        $posts = Post::with(['category', 'user'])
                    ->where('status', 'published')
                    ->latest()
                    ->paginate(6);
        $ekskuls = Extracurricular::latest()->get();

        return view('welcome', compact('posts', 'setting', 'ekskuls', 'announcements', 'galleries'));
    }

    // Menampilkan detail berita saat diklik
   // Menampilkan detail berita saat diklik
    public function show(Post $post)
    {
        // 
    }
}