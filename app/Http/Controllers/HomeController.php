<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Setting;

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

        return view('welcome', compact('posts', 'setting'));
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