<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);
        return view('dashboard.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all(); // Mengambil semua kategori
        return view('dashboard.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|in:draft,published',
            'instagram_link' => 'nullable|url', // Validasi link IG
            'youtube_link' => 'nullable|url',    // Validasi link YT
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'status' => $request->status,
            'instagram_link' => $request->instagram_link,
            'youtube_link' => $request->youtube_link,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard.posts.index')->with('success', 'Berita berhasil diterbitkan!');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('dashboard.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|in:draft,published',
            'instagram_link' => 'nullable|url', // Validasi link IG
            'youtube_link' => 'nullable|url',    // Validasi link YT
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'status' => $request->status,
            'instagram_link' => $request->instagram_link,
            'youtube_link' => $request->youtube_link,
        ]);

        return redirect()->route('dashboard.posts.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->route('dashboard.posts.index')->with('success', 'Berita berhasil dihapus!');
    }
}