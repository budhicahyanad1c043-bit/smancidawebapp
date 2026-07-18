@extends('dashboard.layouts.admin')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6 bg-white rounded-2xl border border-slate-200 shadow-sm">
    <div class="mb-5">
        <h2 class="text-xl font-bold text-slate-800">Edit Pengumuman</h2>
        <p class="text-xs text-slate-500">Perbarui isi maklumat yang telah diterbitkan</p>
    </div>
    @if ($errors->any())
        <div class="p-4 mb-4 text-xs text-red-800 bg-red-50 border border-red-200 rounded-xl">
            <strong class="font-bold">Gagal menyimpan!</strong> Periksa kembali inputan Anda:
            <ul class="list-disc list-inside mt-1.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('announcements.update', $announcement) }}" enctype="multipart/form-data" method="POST">
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

        <!-- Input Flyer (Versi Aman & Dinamis) -->
        <div class="mb-4">
            <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Image Flyer (Pamflet)</label>
            <input type="file" name="flyer" id="imageInput" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer">
            
            <!-- Wadah Preview Dinamis -->
            <div id="previewContainer" class="mt-4 p-2 border border-dashed border-slate-200 rounded-xl max-w-sm bg-slate-50">
                <p id="previewLabel" class="text-[10px] font-bold uppercase text-slate-400 mb-1.5 tracking-wider">
                    {{ $announcement->flyer ? 'Foto Saat Ini:' : 'Belum Ada Flyer:' }}
                </p>
                <img id="imagePreview" 
                    src="{{ $announcement->flyer ? asset('storage/' . $announcement->flyer) : '#' }}" 
                    alt="Preview Flyer" 
                    class="w-full h-auto rounded-lg max-h-52 object-contain shadow-sm {{ $announcement->flyer ? '' : 'hidden' }}">
            </div>
        </div>

        <!-- Input Tautan -->
        <div class="mb-4">
            <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Tautan / Link Eksternal</label>
            <input type="url" name="link_url" value="{{ old('link_url', $announcement->link_url ?? '') }}" placeholder="https://example.com/formulir" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs">
        </div>

        <!-- Input Related Social Media Topics -->
        <div class="mb-4">
            <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Topik Sosmed / Tagar Terkait</label>
            <input type="text" name="related_topics" value="{{ old('related_topics', $announcement->related_topics ?? '') }}" placeholder="Contoh: #MPLS2026 #SMAN1Cidahu #InfoSekolah" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs">
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
@push('scripts')
<script>
    const maxFileSize = 5 * 1024 * 1024; // Sesuai batasan Controller (3MB)

    function setupEditPreview(inputId, previewId, labelId) {
        const inputEl = document.getElementById(inputId);
        if (!inputEl) return;

        inputEl.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);
            const label = document.getElementById(labelId);

            if (file) {
                if (file.size > maxFileSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Maksimal ukuran file gambar adalah 3MB.',
                        confirmButtonColor: '#2563eb',
                        customClass: { popup: 'rounded-xl', confirmButton: 'rounded-lg text-xs px-4 py-2 font-bold' }
                    });
                    this.value = ''; // Reset input gambar
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if(label) label.innerText = 'Pratinjau Gambar Baru:';
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Aktifkan live preview aman untuk halaman Edit
    setupEditPreview('imageInput', 'imagePreview', 'previewLabel');
</script>
@endpush