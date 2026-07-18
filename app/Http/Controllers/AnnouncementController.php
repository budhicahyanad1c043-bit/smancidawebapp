<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    /**
     * 1. Menampilkan daftar pengumuman di dashboard admin/guru.
     */
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('dashboard.announcements.index', compact('announcements'));
    }

    /**
     * 2. Menampilkan form untuk membuat pengumuman baru.
     */
    public function create()
    {
        return view('dashboard.announcements.create');
    }

    /**
     * 3. Menyimpan pengumuman baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|max:255',
            'content'        => 'required',
            'type'           => 'required|in:biasa,penting',
            'status'         => 'required|in:draft,active',
            'flyer'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // maks 3MB
            'link_url'       => 'nullable|url',
            'related_topics' => 'nullable|string',
        ]);

        // Proses upload file flyer jika ada
        $flyerPath = null;
        if ($request->hasFile('flyer')) {
            $flyerPath = $request->file('flyer')->store('announcement_flyers', 'public');
        }

        Announcement::create([
            'title'          => $request->title,
            'slug'           => Str::slug($request->title) . '-' . rand(1000, 9999), // Mencegah slug kembar
            'content'        => $request->content,
            'type'           => $request->type,
            'status'         => $request->status,
            'flyer'          => $flyerPath,
            'link_url'       => $request->link_url,
            'related_topics' => $request->related_topics,
            'user_id'        => auth()->id(), // Mengambil ID admin/guru yang sedang login
        ]);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil diterbitkan!');
    }

    /**
     * 4. Menampilkan detail pengumuman (Tempat fitur Smart Copy & Referensi Sosmed berada).
     */
    // public function show($slug)
    // {
    //     // Cari pengumuman berdasarkan slug, pastikan statusnya sudah 'active'
    //     $announcement = Announcement::where('slug', $slug)
    //                                 ->where('status', 'active')
    //                                 ->firstOrFail(); // Jika tidak ada, otomatis memicu error 404 yang rapi

    //     // Sesuaikan dengan nama file blade publik Anda (misalnya: 'announcements.show' atau 'show')
    //     return view('announcements.show', compact('announcement')); 
    // }

    public function show(Announcement $announcement)
    {
        // Menggunakan Route Model Binding bawaan resource (Mencari otomatis berdasarkan ID)
        return view('announcements.show', compact('announcement')); 
    }

    /**
     * 5. Menampilkan form edit untuk pengumuman tertentu.
     */
    public function edit(Announcement $announcement)
    {
        return view('dashboard.announcements.edit', compact('announcement'));
    }

    /**
     * 6. Memperbarui data pengumuman di database.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title'          => 'required|max:255',
            'content'        => 'required',
            'type'           => 'required|in:biasa,penting',
            'status'         => 'required|in:draft,active',
            'flyer'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3000',
            'link_url'       => 'nullable|url',
            'related_topics' => 'nullable|string',
        ]);

        // Tampung path flyer lama secara default
        $flyerPath = $announcement->flyer;

        // Jika admin mengunggah flyer baru
        if ($request->hasFile('flyer')) {
            // Hapus berkas flyer lama di storage agar tidak menyampah jika sebelumnya ada
            if ($announcement->flyer && Storage::disk('public')->exists($announcement->flyer)) {
                Storage::disk('public')->delete($announcement->flyer);
            }
            // Simpan berkas flyer baru
            $flyerPath = $request->file('flyer')->store('announcement_flyers', 'public');
        }

        $announcement->update([
            'title'          => $request->title,
            // Opsional: perbarui slug jika judul berubah
            'slug'           => Str::slug($request->title) . '-' . rand(1000, 9999), 
            'content'        => $request->content,
            'type'           => $request->type,
            'status'         => $request->status,
            'flyer'          => $flyerPath,
            'link_url'       => $request->link_url,
            'related_topics' => $request->related_topics,
        ]);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    /**
     * 7. Menghapus data pengumuman beserta berkas filenya dari storage.
     */
    public function destroy(Announcement $announcement)
    {
        // Hapus file pamflet/flyer dari storage sebelum menghapus row data
        if ($announcement->flyer && Storage::disk('public')->exists($announcement->flyer)) {
            Storage::disk('public')->delete($announcement->flyer);
        }

        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dihapus!');
    }
}