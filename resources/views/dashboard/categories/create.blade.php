@extends('dashboard.layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <h1 class="text-xl font-bold text-slate-800 tracking-tight">Tambah Kategori</h1>
        <p class="text-xs text-slate-500 font-medium">Buat pengelompokkan baru untuk artikel berita Anda.</p>
    </div>

    <form action="{{ route('categories.store') }}" method="POST" class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Pengumuman Sekolah" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 text-slate-700">
            @error('name') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Deskripsi Singkat (Opsional)</label>
            <textarea name="description" rows="3" placeholder="Deskripsi singkat mengenai kategori ini..." class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 text-slate-700">{{ old('description') }}</textarea>
            @error('description') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end space-x-2 pt-2 border-t border-slate-100">
            <a href="{{ route('categories.index') }}" class="px-4 py-2 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold shadow-sm shadow-blue-500/20 hover:bg-blue-700 transition">Simpan Kategori</button>
        </div>
    </form>
</div>
@endsection