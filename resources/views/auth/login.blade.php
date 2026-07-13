<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - {{ $setting->school_name ?? 'SMAN 1 Cidahu' }}</title>
    <!-- Tailwind CSS (Pastikan Vite atau CDN Anda terpasang dengan benar) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js (Jika tidak dibundel di app.js, gunakan CDN ini) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 antialiased">

    <div class="min-h-screen flex items-center justify-center px-4 py-12" 
         x-data="{ showPassword: false }">
        <div class="max-w-md w-full space-y-6 bg-white p-8 rounded-2xl border border-slate-200 shadow-xl">
            
            <!-- BAGIAN LOGO DENGAN ROUNDED FRAME -->
            <div class="text-center">
                <div class="h-24 w-24 bg-white border border-slate-200 rounded-2xl flex items-center justify-center p-3 mx-auto shadow-sm overflow-hidden mb-4 ring-4 ring-slate-50">
                    @if($setting && $setting->logo)
                        <img src="{{ Storage::url($setting->logo) }}" alt="Logo Sekolah" class="h-full w-full object-contain">
                    @else
                        <!-- SVG Pengganti jika Logo Belum Diupload -->
                        <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21l-8-4.5v-9L12 3l8 4.5v9L12 21z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12l8-4.5M12 12v9M12 12L4 7.5"></path>
                        </svg>
                    @endif
                </div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">Selamat Datang</h2>
                <p class="text-xs text-slate-500 mt-1">Silakan masuk ke sistem admin {{ $setting->school_name ?? 'SMAN 1 Cidahu' }}</p>
            </div>

            <!-- TAMPILAN ERROR VALIDASI LARAVEL -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-xs p-4 rounded-lg space-y-1 shadow-sm">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center">
                            <svg class="w-4 h-4 text-red-600 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            @endif

            <!-- FORM LOGIN -->
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Input Username / Email -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Username atau Email</label>
                    <div class="relative">
                        <input type="text" name="username" value="{{ old('login') }}" required autofocus 
                               class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-xs outline-none focus:border-blue-500 transition @error('login') border-red-500 @enderror">
                        <span class="absolute left-3 top-2.5 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Input Password + Toggle View Icon -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-slate-600">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required 
                               class="w-full pl-10 pr-10 py-2 border border-slate-300 rounded-lg text-xs outline-none focus:border-blue-500 transition">
                        
                        <!-- Ikon Kunci (Sisi Kiri) -->
                        <span class="absolute left-3 top-2.5 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </span>

                        <!-- Tombol Toggle Mata (Sisi Kanan) -->
                        <button type="button" @click="showPassword = !showPassword" 
                                class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 focus:outline-none">
                            <!-- SVG Mata Terbuka (Sembunyikan Password) -->
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <!-- SVG Mata Tertutup / Coret (Lihat Password) -->
                            <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Opsi Remember Me (Ingat Saya) -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded transition">
                    <label for="remember_me" class="ml-2 block text-xs text-slate-500 font-medium select-none">
                        Ingat akun saya di perangkat ini
                    </label>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg text-xs transition shadow-md shadow-blue-500/10 flex items-center justify-center space-x-2">
                        <span>Masuk ke Dashboard</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l4-4m0 0l-4-4m4 4H3m13-4V7a3 3 0 00-3-3H6a3 3 0 00-3 3v10a3 3 0 003 3h7a3 3 0 003-3v-4"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>