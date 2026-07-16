<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Extracurricular;

class HomeController extends Controller
{
    // Menampilkan halaman beranda publik
    public function index()
    {
        $setting = Setting::first();
        // Hanya ambil berita yang statusnya diterbitkan (published)
        $posts = Post::with(['category', 'user'])
                    ->where('status', 'published')
                    ->latest()
                    ->paginate(6);
        $ekskuls = Extracurricular::latest()->get();

        return view('welcome', compact('posts', 'setting', 'ekskuls'));
    }

    // Menampilkan detail berita saat diklik
    public function show(Post $post)
    {
        // Pastikan berita yang diakses memang berstatus published
        if ($post->status !== 'published') {
            abort(404);
        }

        $setting = Setting::first();
        return view('show-post', compact('post', 'setting'));
    }
}