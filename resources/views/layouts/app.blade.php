<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Sekolah')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tambahkan CDN SweetAlert2 jika ingin menggunakannya global -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-50 antialiased">

    <!-- Top Bar / Navbar Publik -->
    <nav class="bg-white border-b border-slate-100 sticky top-0 z-50 shadow-sm backdrop-blur-md bg-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Area Logo Kiri -->
                <div class="flex items-center space-x-3">
                    @if($setting && $setting->logo)
                        <img src="{{ Storage::url($setting->logo) }}" alt="Logo Sekolah" class="h-10 w-auto object-contain">
                    @else
                        <span class="text-2xl">🏫</span>
                    @endif
                    <div>
                        <span class="font-bold text-slate-800 text-sm md:text-base tracking-tight block">
                            {{ $setting->school_name ?? 'Nama Sekolah Anda' }}
                        </span>
                        <span class="text-[7px] text-slate-400 font-medium block -mt-1">
                            {{ $setting->vision ?? 'Belum di setting' }}
                        </span>
                    </div>
                </div>

                <!-- Menu Navigasi Kanan -->
                <div class="hidden md:flex space-x-6 text-xs font-semibold text-slate-600">
                    <a href="/" class="text-blue-600 font-bold">Beranda</a>
                    <a href="#berita" class="hover:text-blue-600 transition">Kabar Terbaru</a>
                    <a href="#sambutan" class="hover:text-blue-600 transition">Sambutan</a>
                </div>

            </div>
        </div>
    </nav>

    <!-- Konten Utama Aplikasi -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    @include('layouts.footer')

</body>
</html>