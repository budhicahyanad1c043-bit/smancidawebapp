@extends('dashboard.layouts.admin')

@section('title', 'Tulis Artikel Berita Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div>
        <h1 class="text-xl font-bold text-slate-800 tracking-tight">Tulis Berita Baru</h1>
        <p class="text-xs text-slate-500">Buat rilis berita atau artikel informasi kegiatan sekolah.</p>
    </div>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Judul Artikel</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 text-slate-700">
            @error('title') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Gambar Sampul</label>
                <input type="file" name="image" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs text-slate-500 focus:outline-none file:mr-4 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[11px] file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                @error('image') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- TAMBAHKAN DROPDOWN PILIHAN KATEGORI INI -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Kategori Berita</label>
                <select name="category_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 text-slate-700">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Status Penerbitan</label>
                <select name="status" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 text-slate-700">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Simpan Sebagai Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Langsung Terbitkan</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Isi Konten Berita</label>
            
            <!-- Input tersembunyi yang akan menangkap data dari Trix Editor -->
            <input id="content" type="hidden" name="content" value="{{ old('content') }}">
            
            <!-- Elemen Trix Editor -->
            <trix-editor input="content" placeholder="Tulis rincian berita sekolah Anda di sini..." class="bg-white"></trix-editor>
            
            @error('content') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end space-x-2 pt-2 border-t border-slate-100">
            <a href="{{ route('posts.index') }}" class="px-4 py-2 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold shadow-sm shadow-blue-500/20 hover:bg-blue-700 transition">Simpan Konten</button>
        </div>
    </form>
</div>
@endsection