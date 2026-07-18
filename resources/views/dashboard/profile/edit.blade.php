@extends('dashboard.layouts.admin')

@section('title', 'Profil Pengguna')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div>
        <h1 class="text-xl font-bold text-slate-800 tracking-tight">Profil User</h1>
        <p class="text-xs text-slate-500 font-medium">Kelola informasi akun dan pasang foto profil terbaik Anda.</p>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-xs font-semibold">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 space-y-6">
        @csrf
        @method('PUT')

        <!-- Bagian Pengaturan Avatar -->
        <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-6 pb-6 border-b border-slate-100">
            <div class="flex-shrink-0">
                <!-- Wrapper Live Preview Avatar -->
                <div class="relative w-20 h-20 rounded-full border border-slate-200 overflow-hidden bg-slate-50 flex items-center justify-center shadow-sm">
                    @if($user->avatar)
                        <img id="imagePreview" src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <!-- Fallback jika belum punya avatar -->
                        <div id="avatarFallback" class="w-full h-full bg-blue-600 flex items-center justify-center text-white text-xl font-bold uppercase">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <img id="imagePreview" src="#" class="w-full h-full object-cover hidden">
                    @endif
                </div>
            </div>
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Foto Avatar</label>
                <input type="file" name="avatar" id="imageInput" class="text-xs text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition pointer-events-auto">
                <p class="text-[10px] text-slate-400">Format: JPG, JPEG, PNG. Maksimal file 2MB.</p>
                @error('avatar') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Bidang Informasi Akun -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 text-slate-700">
                @error('name') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 text-slate-700">
                @error('email') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Bidang Ubah Password -->
        <div class="pt-4 border-t border-slate-100 space-y-4">
            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Ganti Kata Sandi <span class="text-[10px] text-slate-400 font-medium lowercase">(Biarkan kosong jika tidak ingin diubah)</span></h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Kata Sandi Baru</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 text-slate-700">
                    @error('password') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 text-slate-700">
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center justify-end space-x-2 pt-4 border-t border-slate-100">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold shadow-sm shadow-blue-500/20 hover:bg-blue-700 transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const imagePreview = document.getElementById('imagePreview');
        const fallback = document.getElementById('avatarFallback');
        const maxSize = 2 * 1024 * 1024; // 2MB

        if (file) {
            // Validasi Ukuran File dengan SweetAlert2
            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ukuran file terlalu besar! Maksimal ukuran gambar adalah 2MB.',
                    confirmButtonColor: '#2563eb', // Warna biru Tailwind (bg-blue-600)
                    customClass: {
                        popup: 'rounded-xl',
                        confirmButton: 'rounded-lg text-xs px-4 py-2 font-bold'
                    }
                });

                this.value = ''; // Mengosongkan kembali input file
                imagePreview.classList.add('hidden');
                if (fallback) fallback.classList.remove('hidden');
                return;
            }

            // Jika lolos validasi, tampilkan preview
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                if(fallback) {
                    fallback.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush