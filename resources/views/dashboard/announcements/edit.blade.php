@extends('dashboard.layouts.admin')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6 bg-white rounded-2xl border border-slate-200 shadow-sm">
    <div class="mb-5">
        <h2 class="text-xl font-bold text-slate-800">Edit Pengumuman</h2>
        <p class="text-xs text-slate-500">Perbarui isi maklumat yang telah diterbitkan</p>
    </div>

    <form action="{{ route('announcements.update', $announcement->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Judul Pengumuman</label>
            <input type="text" name="title" value="{{ old('title', $announcement->title) }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-purple-500 text-xs" required>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Tingkat Kepentingan</label>
                <select name="type" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs">
                    <option value="biasa" {{ $announcement->type == 'biasa' ? 'selected' : '' }}>Biasa (Informasi Umum)</option>
                    <option value="penting" {{ $announcement->type == 'penting' ? 'selected' : '' }}>Penting (Wajib Dibaca)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Status Publikasi</label>
                <select name="status" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs">
                    <option value="active" {{ $announcement->status == 'active' ? 'selected' : '' }}>Langsung Publikasikan</option>
                    <option value="draft" {{ $announcement->status == 'draft' ? 'selected' : '' }}>Simpan Sebagai Draft</option>
                </select>
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Isi Konten Berita</label>
        
            <!-- Input tersembunyi yang akan menangkap data dari Trix Editor -->
            <input id="content" type="hidden" name="content" value="{{ old('content', $announcement->content) }}">
            
            <!-- Elemen Trix Editor -->
            <trix-editor input="content" placeholder="Tulis rincian berita sekolah Anda di sini..." class="bg-white"></trix-editor>
            
            @error('content') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('announcements.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-lg shadow transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection