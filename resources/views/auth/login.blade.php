<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIM SMAN 1 Cidahu</title>
    <!-- Font Profesional Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Alpine.js untuk fitur Show/Hide Password -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo & Judul Atas -->
        <div class="text-center mb-6">
            <div class="h-20 w-20 bg-white border border-slate-200 rounded-2xl flex items-center justify-center p-2 mx-auto shadow-sm overflow-hidden mb-3">
                @if($setting && $setting->logo)
                    <!-- Jika data setting ada dan kolom logo terisi, panggil filenya -->
                    <img src="{{ asset($setting->logo) }}" alt="Logo Sekolah" class="h-full w-full object-contain">
                @else
                    <!-- Jika kosong/null, tampilkan logo cadangan berupa aset statis atau emoji -->
                    <span class="text-4xl">🏫</span>
                @endif
            </div>
            <h1 class="text-xl font-bold text-slate-900">SIM SMAN 1 Cidahu</h1>
            <p class="text-xs text-slate-500 mt-1">Sistem Informasi Manajemen & Panel Kontrol</p>
        </div>

        <!-- Card Login Bergaya AdminLTE Modern -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-xl p-6 sm:p-8">
            <div class="mb-6">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400">Masuk Aplikasi</h2>
                <p class="text-xs text-slate-500 mt-0.5">Gunakan akun administrator atau jurnalis Anda.</p>
            </div>

            <!-- Menampilkan Error jika ada -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-xs p-3.5 rounded-lg mb-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center">⚠️ <span class="ml-1.5 font-medium">{{ $error }}</span></p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Input Username / Email -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Username atau Email</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-slate-400 text-xs">👤</span>
                        <input type="text" name="username" value="{{ old('login') }}" required autofocus
                               placeholder="Masukkan username/email" 
                               class="w-full pl-9 pr-4 py-2 border border-slate-300 rounded-md text-xs bg-slate-50/50 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                    </div>
                </div>

                <!-- Input Password dengan Fitur Intip (Show/Hide) -->
                <div x-data="{ showPassword: false }">
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-slate-400 text-xs">🔒</span>
                        
                        <!-- Input type dinamis diubah oleh Alpine.js -->
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                               placeholder="••••••••" 
                               class="w-full pl-9 pr-12 py-2 border border-slate-300 rounded-md text-xs bg-slate-50/50 focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                        
                        <!-- Tombol Show/Hide -->
                        <button type="button" @click="showPassword = !showPassword" 
                                class="absolute right-3 top-2 text-slate-400 hover:text-slate-600 text-xs font-medium focus:outline-none select-none bg-slate-100 px-1.5 py-0.5 rounded border">
                            <span x-text="showPassword ? 'Sembunyi' : 'Lihat'"></span>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password (Opsional) -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center text-xs text-slate-600 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 mr-2 h-3.5 w-3.5">
                        Ingat Saya
                    </label>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 rounded-md text-xs transition shadow-md flex items-center justify-center space-x-2">
                        <span>🚪</span>
                        <span>Masuk ke Dashboard</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer Copyright -->
        <p class="text-center text-[11px] text-slate-400 mt-6">
            &copy; {{ date('Y') }} SMAN 1 Cidahu. All rights reserved.
        </p>
    </div>

</body>
</html>