<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        // 1. Hitung total postingan khusus milik user yang sedang login
        $userPostsCount = Post::where('user_id', $user->id)->count();

        // 2. Mengambil 5 postingan terbaru milik user yang sedang login
        $recentPosts = Post::where('user_id', $user->id)
            ->with('category') // Mengambil relasi kategori jika ada
            ->latest()
            ->take(5)
            ->get();

        // 3. (Opsional) Jika Admin, ambil juga total seluruh postingan di web
        $totalAllPosts = Post::count();

        return view('dashboard.index', compact('user', 'userPostsCount', 'recentPosts', 'totalAllPosts'));
    }

}
