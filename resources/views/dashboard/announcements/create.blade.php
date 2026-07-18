@extends('dashboard.layouts.admin')

@section('title', 'Buat Pengumuman')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="mb-5">
        <h2 class="text-xl font-bold text-slate-800">Buat Pengumuman Baru</h2>
        <p class="text-xs text-slate-500">Sebarkan maklumat terbaru ke halaman utama website sekolah</p>
    </div>

    <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 space-y-5">
        @csrf
        
        <div class="mb-4">
            <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Judul Pengumuman</label>
            <input type="text" name="title" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-purple-500 text-xs" required placeholder="Contoh: Jadwal Ujian Akhir Semester Ganjil">
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Tingkat Kepentingan</label>
                <select name="type" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-[10px] md:text-xs">
                    <option value="biasa">Biasa (Informasi Umum)</option>
                    <option value="penting">Penting (Wajib Dibaca)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Status Publikasi</label>
                <select name="status" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-[10px] md:text-xs">
                    <option value="active">Langsung Publikasikan</option>
                    <option value="draft">Simpan Sebagai Draft</option>
                </select>
            </div>
        </div>

        <!-- Input Flyer -->
        <div class="mb-4">
            <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Image Flyer (Pamflet)</label>
            <input type="file" name="flyer" id="imageflyer" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer">
            <div id="previewContainer" class="mt-4 p-2 border border-dashed border-slate-200 rounded-xl max-w-sm bg-slate-50">
                <img id="imagePreview"  alt="Preview" class="h-24 w-full object-cover hidden border border-slate-200 rounded-lg">
            </div>
        </div>

        <!-- Input Tautan -->
        <div class="mb-4">
            <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Tautan / Link Eksternal</label>
            <input type="url" name="link_url" value="{{ old('link_url') }}" placeholder="https://example.com/formulir" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs">
        </div>

        <!-- Input Related Social Media Topics -->
        <div class="mb-4">
            <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Topik Sosmed / Tagar Terkait</label>
            <input type="text" name="related_topics" value="{{ old('related_topics') }}" placeholder="Contoh: #MPLS2026 #SMAN1Cidahu #InfoSekolah" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs">
        </div>

        <div class="mb-5">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Isi Konten Berita</label>
            
            <!-- Input tersembunyi yang akan menangkap data dari Trix Editor -->
            <input id="content" type="hidden" name="content" value="{{ old('content') }}">
            
            <!-- Elemen Trix Editor -->
            <trix-editor input="content" placeholder="Tuliskan isi maklumat secara detail di sini..." class="bg-white"></trix-editor>
            
            @error('content') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('announcements.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-lg shadow transition">Terbitkan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Batas maksimal ukuran file (3MB sesuai validasi di Controller)
    const maxFileSize = 5 * 1024 * 1024; 

    function setupLivePreview(inputId, previewId, containerId) {
        const inputEl = document.getElementById(inputId);
        if (!inputEl) return;

        inputEl.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);
            const container = document.getElementById(containerId);

            if (file) {
                // Validasi Ukuran File
                if (file.size > maxFileSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Maksimal ukuran file flyer adalah 5MB.',
                        confirmButtonColor: '#2563eb',
                        customClass: { popup: 'rounded-xl', confirmButton: 'rounded-lg text-xs px-4 py-2 font-bold' }
                    });
                    this.value = ''; // Reset input file
                    preview.src = '#';
                    preview.classList.add('hidden');
                    return;
                }

                // Tampilkan Preview Jika Lolos Validasi
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    preview.classList.add('h-52', 'object-contain'); // Mempercantik rasio aspek
                    preview.classList.remove('h-24', 'object-cover');
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.classList.add('hidden');
            }
        });
    }

    // Aktifkan live preview untuk halaman Create
    setupLivePreview('imageflyer', 'imagePreview', 'previewContainer');
</script>
@endpush