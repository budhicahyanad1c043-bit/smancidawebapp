@extends('dashboard.layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<div class="space-y-6">
    <!-- Header Halaman -->
    <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Pengaturan Website</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola informasi instansi profil utama SMAN 1 Cidahu</p>
        </div>
        <div class="text-xs text-right text-slate-400 font-medium">
            Dashboard &nbsp;/&nbsp; <span class="text-slate-600 font-semibold">Settings</span>
        </div>
    </div>

    <!-- Alert Status -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs p-4 rounded-lg flex items-center space-x-2 shadow-sm">
            <span>✅</span>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-12 gap-6">
            
            <!-- Kolom Kiri: Media Box (Khas Model Box Profile AdminLTE) -->
            <div class="col-span-12 lg:col-span-4 space-y-6">
                <!-- Box Logo Sekolah -->
                <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
                    <div class="bg-slate-50 px-4 py-3 border-b border-slate-200">
                        <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Logo Instansi</h3>
                    </div>
                    <div class="p-6 flex flex-col items-center">
                        <!-- Kontainer Logo -->
                        <div class="h-28 w-28 bg-slate-50 border border-dashed border-slate-300 rounded-lg flex items-center justify-center p-2 mb-4 overflow-hidden relative shadow-inner">
                            @if($setting->logo ?? false)
                                <img id="logoPreview" src="{{ Storage::url($setting->logo) }}" class="h-full w-full object-contain">
                            @else
                                <!-- Fallback ikon sekolah bawaan -->
                                <span id="logoFallback" class="text-4xl">🏫</span>
                                <img id="logoPreview" src="#" class="h-full w-full object-contain hidden">
                            @endif
                        </div>

                        <!-- Input File Logo (Ditambahkan id="logoInput") -->
                        <input type="file" name="logo" id="logoInput" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border file:border-slate-300 file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100 cursor-pointer">
                    </div>
                </div>

                <!-- Box Foto Kepala Sekolah -->
                <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
                    <div class="bg-slate-50 px-4 py-3 border-b border-slate-200">
                        <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Foto Kepala Sekolah</h3>
                    </div>
                    <div class="p-6 flex flex-col items-center">
                    <!-- Kontainer Foto -->
                    <div class="h-36 w-28 bg-slate-50 border border-dashed border-slate-300 rounded-lg flex items-center justify-center mb-4 overflow-hidden shadow-inner relative">
                        @if($setting->principal_photo ?? false)
                            <img id="principalPreview" src="{{ Storage::url($setting->principal_photo) }}" class="h-full w-full object-cover">
                        @else
                            <!-- Fallback ikon avatar bawaan -->
                            <span id="principalFallback" class="text-4xl">👤</span>
                            <img id="principalPreview" src="#" class="h-full w-full object-cover hidden">
                        @endif
                    </div>

                    <!-- Input File (Ditambahkan id="principalInput") -->
                    <input type="file" name="principal_photo" id="principalInput" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border file:border-slate-300 file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100 cursor-pointer">
                </div>
                </div>
            </div>

            <!-- Kolom Kanan: Form Data Pengaturan -->
            <div class="col-span-12 lg:col-span-8 space-y-6">
                <!-- Block Identitas Sekolah -->
                <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
                    <div class="bg-slate-50 px-5 py-3 border-b border-slate-200">
                        <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Formulir Identitas</h3>
                    </div>
                    <div class="p-5 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Sekolah</label>
                                <input type="text" name="school_name" value="{{ $setting->school_name ?? 'SMAN 1 Cidahu' }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Kepala Sekolah</label>
                                <input type="text" name="principal_name" value="{{ $setting->principal_name ?? '' }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Welcome Message</label>
                            <textarea name="welcome_message" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition resize-none">{{ $setting->welcome_message ?? 'Sambutan kepala sekolah' }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Deskripsi Sekolah</label>
                            <textarea name="description_school" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition resize-none">{{ $setting->description_school ?? 'Deskripsi sekolah' }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Visi & Misi Instansi</label>
                            <textarea name="vision" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition resize-none">{{ $setting->vision ?? 'Isi dengan visi dan misi sekolah' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Block Kontak Instansi -->
                <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
                    <div class="bg-slate-50 px-5 py-3 border-b border-slate-200">
                        <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Kontak & Domain</h3>
                    </div>
                    <div class="p-5 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Email Sekolah</label>
                                <input type="email" name="email" value="{{ $setting->email ?? '' }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">NPSN</label>
                                <input type="text" name="npsn" value="{{ $setting->npsn ?? '69963098' }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1.5">No. Telepon / Fax</label>
                                <input type="text" name="phone" value="{{ $setting->phone ?? '' }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Alamat Lengkap Sekolah</label>
                            <input type="text" name="address" value="{{ $setting->address ?? '' }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">Tautan Web Resmi</label>
                            <input type="url" name="website" value="{{ $setting->website ?? '' }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition" placeholder="https://sman1cidahusmi.sch.id">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">URL Facebook</label>
                            <input type="url" name="facebook_url" value="{{ old('facebook_url', $setting->facebook_url ?? '') }}" placeholder="https://facebook.com/..." class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition" placeholder="your facebook">
                            @error('facebook_url') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">URL Instagram</label>
                            <input type="url" name="instagram_url" value="{{ old('instagram_url', $setting->instagram_url ?? '') }}" placeholder="https://instagram.com/..." class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                            @error('instagram_url') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Youtube -->
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">URL Youtube</label>
                            <input type="url" name="youtube_url" value="{{ old('youtube_url', $setting->youtube_url ?? '') }}" placeholder="https://youtube.com/..." class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                            @error('youtube_url') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    <!-- Footer Box: Tombol Submit -->
                    <div class="bg-slate-50 px-5 py-3 border-t border-slate-200 flex justify-end">
                        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold px-4 py-2 rounded text-xs transition shadow-sm flex items-center space-x-1.5">
                            <span>💾</span>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const maxImageSize = 2 * 1024 * 1024; // Batas Maksimal 2MB

    // Fungsi pembantu untuk menampilkan SweetAlert2 yang seragam
    function showSizeAlert() {
        Swal.fire({
            icon: 'error',
            title: 'Ukuran File Terlalu Besar',
            text: 'Maksimal ukuran gambar yang diizinkan adalah 2MB.',
            confirmButtonColor: '#2563eb',
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'rounded-lg text-xs px-4 py-2 font-bold'
            }
        });
    }

    // --- 1. LIVE PREVIEW LOGO ---
    document.getElementById('logoInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('logoPreview');
        const fallback = document.getElementById('logoFallback');

        if (file) {
            if (file.size > maxImageSize) {
                showSizeAlert();
                this.value = ''; // Reset input file
                preview.classList.add('hidden');
                if (fallback) fallback.classList.remove('hidden');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (fallback) fallback.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // --- 2. LIVE PREVIEW FOTO KEPALA SEKOLAH ---
    document.getElementById('principalInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('principalPreview');
        const fallback = document.getElementById('principalFallback');

        if (file) {
            if (file.size > maxImageSize) {
                showSizeAlert();
                this.value = ''; // Reset input file
                preview.classList.add('hidden');
                if (fallback) fallback.classList.remove('hidden');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (fallback) fallback.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush