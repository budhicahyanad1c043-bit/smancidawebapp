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
        // Pastikan berita yang diakses memang berstatus published
        if ($post->status !== 'published') {
            abort(404);
        }

        $setting = Setting::first();

        // AMBIL BERITA TERKAIT:
        // Cari berita dengan category_id yang sama, tetapi kecualikan berita yang sedang dibuka ($post->id)
        $relatedPosts = Post::where('category_id', $post->category_id)
                            ->where('id', '!=', $post->id)
                            ->where('status', 'published')
                            ->latest()
                            ->take(2) // Batasi hanya ambil 2 artikel agar layout grid 3 kolom seimbang
                            ->get();

        // Kirim $relatedPosts ke view 'show-post'
        return view('show-post', compact('post', 'setting', 'relatedPosts'));
    }
}