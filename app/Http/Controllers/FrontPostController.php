<?php

namespace App\Http\Controllers;

use App\Models\Post; // Pastikan nama Model Anda sesuai, misalnya Post atau Article
use Illuminate\Http\Request;

class FrontPostController extends Controller
{
    /**
     * Menampilkan semua artikel/berita dengan pagination.
     */
    public function index()
    {
        // Mengambil post yang berstatus 'publish', diurutkan dari yang terbaru.
        // Dibatasi 9 data per halaman agar pas dengan grid 3 kolom.
        $posts = Post::where('status', 'published') // Sesuaikan 'status' & 'publish' dengan skema DB Anda
                     ->latest()
                     ->paginate(9);

        return view('front.posts.index', compact('posts'));
    }

    /**
     * Menampilkan detail satu artikel/berita.
     */
    public function show($slug)
    {
        
        $post = Post::where('slug', $slug)
                ->where('status', 'published')
                ->firstOrFail();

        // Ambil setting sekolah agar tidak eror di view 'show-post'
        $setting = \App\Models\Setting::first(); 

        // Ambil artikel terkait untuk bagian bawah detail berita
        $relatedPosts = Post::where('category_id', $post->category_id)
                            ->where('id', '!=', $post->id)
                            ->where('status', 'published')
                            ->latest()
                            ->take(2)
                            ->get();

        return view('front.posts.show-post', compact('post', 'setting', 'relatedPosts'));
    }
}