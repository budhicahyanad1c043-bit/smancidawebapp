@extends('dashboard.layouts.admin')
@section('title', 'Buat Berita & Artikel')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="bg-white border border-slate-200/60 rounded-xl shadow-sm p-6">
        
        <!-- Header Halaman -->
        <div class="mb-6 pb-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Tambah Berita / Artikel Baru</h2>
            <p class="text-[11px] text-slate-500 mt-1">Buat rilis berita, pengumuman resmi, atau artikel kegiatan sekolah terbaru.</p>
        </div>

        <!-- Perhatikan Route diarahkan ke '.store' untuk penyimpanan data baru -->
        <form action="{{ route('dashboard.posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 space-y-5">
            @csrf

            <!-- Judul Artikel -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Judul Artikel / Berita</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Masukkan judul berita menarik..." class="w-full text-xs p-2 rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                @error('title') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Baris Gambar Sampul, Kategori, & Status Penerbitan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- 1. Upload Gambar (Kolom Kiri) -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Gambar Sampul (Maks 5MB)</label>
                    <input type="file" id="imageInput" name="image" accept="image/*" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    
                    <div class="mt-3">
                        <span class="text-[10px] text-slate-400 block mb-1 font-semibold">Pratinjau Gambar:</span>
                        <!-- Default hidden karena belum ada berkas terpilih -->
                        <img id="imagePreview" src="" class="h-36 w-full object-cover hidden border border-slate-200 rounded-xl">
                    </div>
                    @error('image') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- 2. Pilihan Kategori (Kolom Tengah) -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Kategori Berita</label>
                    <select name="category_id" required class="w-full text-xs p-2 rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                        <option value="" selected disabled>-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                📁 {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- 3. Status Penerbitan (Kolom Kanan) -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Status Penerbitan</label>
                    <select name="status" class="w-full text-xs p-2 rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>📄 Simpan Sebagai Draft</option>
                        <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>🚀 Terbitkan Langsung</option>
                    </select>
                    @error('status') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

            </div>

            <!-- Input Link Sosmed Terkait Postingan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Input Instagram Link -->
                <div class="space-y-2">
                    <label for="instagram_link" class="block text-xs font-bold text-slate-700 uppercase">Link Instagram Terkait (Opsional)</label>
                    <div class="relative rounded-lg">
                        <input type="url" 
                            name="instagram_link" 
                            id="instagram_link" 
                            class="w-full text-xs p-2 rounded-lg border-slate-200 @error('instagram_link') border-red-500 @enderror" 
                            placeholder="https://www.instagram.com/p/..." 
                            value="{{ old('instagram_link') }}">
                    </div>
                    @error('instagram_link')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input YouTube Link -->
                <div class="space-y-2">
                    <label for="youtube_link" class="block text-xs font-bold text-slate-700 uppercase">Link YouTube Terkait (Opsional)</label>
                    <div class="relative rounded-lg">
                        <input type="url" 
                            name="youtube_link" 
                            id="youtube_link" 
                            class="w-full text-xs p-2 rounded-lg border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500 @error('youtube_link') border-red-500 @enderror" 
                            placeholder="https://www.youtube.com/watch?v=..." 
                            value="{{ old('youtube_link') }}">
                    </div>
                    @error('youtube_link')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Isi Konten Artikel (Menggunakan Rich Text Editor) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Isi Konten Berita</label>
                <div class="text-xs">
                    <textarea name="content" id="editor" placeholder="Mulai menuliskan isi konten artikel secara lengkap dan informatif di sini...">{{ old('content') }}</textarea>
                </div>
                @error('content') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('dashboard.posts.index') }}" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-50 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition">
                    Terbitkan Postingan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@push('styles')
<style>
    .ck-editor__editable_inline {
        min-height: 300px;
        font-size: 0.75rem !important;
        color: #334155;
    }
    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
        border-color: #e2e8f0 !important;
        border-bottom-left-radius: 0.5rem !important;
        border-bottom-right-radius: 0.5rem !important;
    }
    .ck-toolbar {
        border-top-left-radius: 0.5rem !important;
        border-top-right-radius: 0.5rem !important;
        border-color: #e2e8f0 !important;
        background: #f8fafc !important;
    }
</style>
@endpush


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi CKEditor 5
        const editorElement = document.querySelector('#editor');
        if (editorElement) {
            ClassicEditor
                .create(editorElement, {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo' ]
                })
                .catch(error => {
                    console.error('Gagal inisialisasi CKEditor:', error);
                });
        }

        // Live Preview & Validasi Ukuran Gambar Berkas Baru (Maks 2MB)
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const maxFileSize = 5 * 1024 * 1024; // Konversi 2MB ke Bytes

        if (imageInput) {
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    if (file.size > maxFileSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ukuran Gambar Melampaui Batas',
                            text: 'Maksimal ukuran file gambar sampul adalah 2MB.',
                            confirmButtonColor: '#2563eb'
                        });
                        this.value = ''; // Reset berkas input
                        imagePreview.classList.add('hidden');
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>