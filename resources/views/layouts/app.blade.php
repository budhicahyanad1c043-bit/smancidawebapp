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
                        <span class="text-[8px] text-slate-400 font-medium block -mt-1 tracking-tight">
                            {{ $setting->vision ?? 'Belum ditentukan' }}
                        </span>
                        
                    </div>
                </div>

                <!-- Menu Navigasi Kanan (TAMPIL DI DESKTOP) -->
                <div class="hidden md:flex space-x-6 text-xs font-semibold text-slate-600">
                    <a href="/" class="text-blue-600 font-bold">Beranda</a>
                    <a href="#ekstrakurikuler" class="hover:text-blue-600 transition">Ekstrakurikuler</a>
                    <a href="#berita" class="hover:text-blue-600 transition">Smancida News</a>
                </div>

                <!-- Tombol Hamburger (TAMPIL HANYA DI MOBILE) -->
                <div class="flex items-center md:hidden">
                    <button id="menu-btn" type="button" class="text-slate-600 hover:text-slate-900 focus:outline-none p-2 rounded-lg hover:bg-slate-50 transition" aria-label="Toggle Menu">
                        <!-- Icon Hamburger (Garis Tiga) -->
                        <svg id="hamburger-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <!-- Icon Close (X) - Tersembunyi Default -->
                        <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Menu Navigasi Dropdown (HANYA MUNCUL DI MOBILE SAAT DIKLIK) -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white px-4 py-3 space-y-1 shadow-inner">
            <a href="/" class="block text-xs font-bold text-blue-600 py-2.5 px-3 rounded-lg bg-blue-50/50">Beranda</a>
            <a href="#ekstrakurikuler" class="block text-xs font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50 py-2.5 px-3 rounded-lg transition">Ekstrakurikuler</a>
            <a href="#berita" class="block text-xs font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50 py-2.5 px-3 rounded-lg transition">Smancida New</a>
        </div>
    </nav>

    <!-- Konten Utama Aplikasi -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    @include('layouts.footer')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function () {
                    // Toggle kelas hidden untuk membuka/menutup menu
                    mobileMenu.classList.toggle('hidden');
                    
                    // Toggle icon burger dan icon close (X)
                    hamburgerIcon.classList.toggle('hidden');
                    closeIcon.classList.toggle('hidden');
                });

                // Tutup menu otomatis jika salah satu link di dalam menu mobile diklik
                const menuLinks = mobileMenu.querySelectorAll('a');
                menuLinks.forEach(link => {
                    link.addEventListener('click', function () {
                        mobileMenu.classList.add('hidden');
                        hamburgerIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                    });
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>