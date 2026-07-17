@extends('dashboard.layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="bg-white border border-slate-200/60 rounded-xl shadow-sm p-6">
        
        <!-- Header Halaman -->
        <div class="mb-6 pb-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Edit Berita / Artikel</h2>
            <p class="text-[11px] text-slate-500 mt-1">Perbarui rilis berita, pengumuman, atau artikel sekolah Anda.</p>
        </div>

        <form action="{{ route('dashboard.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Judul Artikel -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Judul Artikel / Berita</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required placeholder="Masukkan judul berita yang menarik..." class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 text-slate-700">
                @error('title') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Baris Gambar Sampul & Status Penerbitan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Upload Gambar (Kolom Kiri - Lebar 2/3) -->
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Gambar Sampul Baru (Maks 2MB)</label>
                    <input type="file" id="imageInput" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    
                    <!-- Pratinjau Gambar -->
                    <div class="mt-3">
                        <span class="text-[10px] text-slate-400 block mb-1 font-semibold">Pratinjau Gambar:</span>
                        <!-- Menampilkan gambar lama jika ada, atau gambar baru jika diupload -->
                        <img id="imagePreview" src="{{ $post->image ? Storage::url($post->image) : '' }}" class="h-44 w-full md:w-2/3 object-cover {{ $post->image ? '' : 'hidden' }} border border-slate-200 rounded-xl">
                    </div>
                    @error('image') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    <!-- Pratinjau Gambar -->
                    <div class="mt-3">
                        <select name="category_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 text-slate-700">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('image') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status Penerbitan (Kolom Kanan - Lebar 1/3) -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Status Penerbitan</label>
                    <select name="status" class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>📁 Simpan Sebagai Draft</option>
                        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>🚀 Terbitkan Langsung</option>
                    </select>
                    @error('status') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Isi Konten Artikel -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Isi Konten Berita</label>
            
                <!-- Input tersembunyi yang akan menangkap data dari Trix Editor -->
                <input id="content" type="hidden" name="content" value="{{ old('content', $post->content) }}">
                
                <!-- Elemen Trix Editor -->
                <trix-editor input="content" placeholder="Tulis rincian berita sekolah Anda di sini..." class="bg-white"></trix-editor>
                
                @error('content') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('dashboard.posts.index') }}" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-50 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const maxFileSize = 5 * 1024 * 1024; // Atur Batas Maksimal 2MB (Bisa diubah sesuai keinginan)

        if (imageInput) {
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    // Validasi ukuran file gambar di client-side
                    if (file.size > maxFileSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ukuran Gambar Terlalu Besar',
                            text: 'Maksimal ukuran gambar sampul artikel adalah 5MB.',
                            confirmButtonColor: '#2563eb',
                            customClass: {
                                popup: 'rounded-2xl p-5',
                                confirmButton: 'rounded-lg text-xs px-4 py-2 font-bold'
                            }
                        });
                        this.value = ''; // Reset input agar batal dipilih
                        return;
                    }

                    // Tampilkan live preview jika file valid
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
@endpush