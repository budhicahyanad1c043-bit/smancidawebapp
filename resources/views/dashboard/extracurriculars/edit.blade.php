@extends('dashboard.layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="bg-white border border-slate-200/60 rounded-xl shadow-sm p-6">
        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-6">Edit Ekstrakurikuler</h2>

        <form action="{{ route('dashboard.extracurriculars.update', $extracurricular->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Ekskul -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nama Ekstrakurikuler</label>
                <input type="text" name="name" value="{{ old('name', $extracurricular->name) }}" required class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                @error('name') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Upload Logo & Image Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Input Logo -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Logo Ekskul (Maks 2MB)</label>
                    <input type="file" id="logoInput" name="logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <div class="mt-2">
                        <!-- Tampilkan Logo Lama jika Ada -->
                        <img id="logoPreview" src="{{ $extracurricular->logo ? Storage::url($extracurricular->logo) : '' }}" class="h-20 w-20 object-contain {{ $extracurricular->logo ? '' : 'hidden' }} border border-slate-200 rounded-lg p-1 bg-white">
                    </div>
                </div>

                <!-- Input Foto Kegiatan -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Foto Kegiatan / Sampul (Maks 2MB)</label>
                    <input type="file" id="imageInput" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <div class="mt-2">
                        <!-- Tampilkan Foto Kegiatan Lama jika Ada -->
                        <img id="imagePreview" src="{{ $extracurricular->image ? Storage::url($extracurricular->image) : '' }}" class="h-24 w-full object-cover {{ $extracurricular->image ? '' : 'hidden' }} border border-slate-200 rounded-lg">
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Deskripsi Kegiatan</label>
                <textarea name="description" rows="5" required class="w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500">{{ old('description', $extracurricular->description) }}</textarea>
                @error('description') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('dashboard.extracurriculars.index') }}" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-50 rounded-lg transition">Batal</a>
                <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition">Perbarui Ekskul</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const maxFileSize = 5 * 1024 * 1024; // 2MB

    function setupEditPreview(inputId, previewId) {
        document.getElementById(inputId).addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);

            if (file) {
                if (file.size > maxFileSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Maksimal ukuran file gambar adalah 2MB.',
                        confirmButtonColor: '#2563eb',
                        customClass: { popup: 'rounded-xl', confirmButton: 'rounded-lg text-xs px-4 py-2 font-bold' }
                    });
                    this.value = ''; // Reset input agar tidak jadi diunggah
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Jalankan pemantau file input saat mengedit
    setupEditPreview('logoInput', 'logoPreview');
    setupEditPreview('imageInput', 'imagePreview');
</script>
@endpush