@extends('dashboard.layouts.admin')

@section('title', 'Upload Images to Gallery')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="mb-5">
        <h2 class="text-xl font-bold text-slate-800">Unggah Foto Kegiatan</h2>
        <p class="text-xs text-slate-500">Tambahkan dokumentasi foto baru ke album galeri sekolah</p>
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

    <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 space-y-5">
        @csrf
        
        <div class="mb-4">
            <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Judul / Nama Kegiatan</label>
            <input type="text" name="title" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs" required placeholder="Contoh: Pelaksanaan Upacara HUT RI ke-81">
        </div>

        <div class="mb-4">
            <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Pilih File Foto</label>
            <input type="file" id="imageInput" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <div class="mt-2">
                        <img id="imagePreview" class="w-100 object-cover hidden border border-slate-200 rounded-lg">
                    </div>
            <p class="text-[10px] text-slate-400 mt-1">*Format: JPG, JPEG, PNG, WEBP. Maksimal ukuran file 5MB.</p>
        </div>

        <div class="mb-5">
            <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Keterangan / Keterangan Singkat</label>
            <textarea name="description" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs" placeholder="Tulis catatan atau deskripsi singkat mengenai kegiatan ini (opsional)..."></textarea>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('galleries.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-lg shadow transition">Simpan & Unggah</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const maxFileSize = 5* 1024 * 1024; // 2MB

    function setupLivePreview(inputId, previewId) {
        document.getElementById(inputId).addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);

            if (file) {
                if (file.size > maxFileSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Maksimal ukuran file gambar adalah 5MB.',
                        confirmButtonColor: '#2563eb',
                        customClass: { popup: 'rounded-xl', confirmButton: 'rounded-lg text-xs px-4 py-2 font-bold' }
                    });
                    this.value = ''; // Reset input
                    preview.classList.add('hidden');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
        });
    }

    // Aktifkan live preview aman untuk logo dan image sampul
    setupLivePreview('imageInput', 'imagePreview');
</script>
@endpush