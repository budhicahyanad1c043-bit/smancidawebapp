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
                        <span class="text-[9px] md:text-[11px] text-slate-400 font-medium block -mt-1 tracking-tight">
                            {{ $setting->vision ?? 'Belum ditentukan' }}
                        </span>
                        
                    </div>
                </div>

                <!-- Menu Navigasi Kanan (TAMPIL DI DESKTOP) -->
                <div class="hidden md:flex space-x-6 text-xs font-semibold text-slate-600">
                    <!-- Menu Beranda -->
                    <a href="/" 
                    class="nav-link text-xs font-bold transition-colors duration-200 {{ request()->routeIs('home') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                        Beranda
                    </a>

                    <!-- Menu Pengumuman -->
                    <a href="/pengumuman" 
                    class="nav-link text-xs font-bold transition-colors duration-200 {{ request()->routeIs('front.announcements*') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                        Pengumuman
                    </a>

                    <!-- Menu Smancida News -->
                    <a href="/berita" 
                    class="nav-link text-xs font-bold transition-colors duration-200 {{ request()->routeIs('front.posts*') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                        Smancida News
                    </a>
                    
                    <!-- Menu Ekstrakurikuler (Aktif jika rutenya adalah 'ekstrakurikuler' atau turunannya) -->
                    <a href="/#ekstrakurikuler" 
                    class="nav-link text-xs font-bold transition-colors duration-200 {{ request()->routeIs('ekstrakurikuler*') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                        Ekstrakurikuler
                    </a>

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

            <a href="/" class="nav-link block text-xs font-bold py-2.5 px-3 rounded-lg {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50/50 ' : 'text-slate-600 hover:text-blue-600' }}">Beranda</a>

            <a href="/pengumuman" class="nav-link block text-xs font-semibold hover:text-blue-600 hover:bg-slate-50 py-2.5 px-3 rounded-lg transition {{ request()->routeIs('front.announcements*') ? 'text-blue-600 bg-blue-50/50' : 'text-slate-600 hover:text-blue-600' }}">Pengumuman</a>

            <a href="/berita" class="nav-link block text-xs font-semibold hover:text-blue-600 hover:bg-slate-50 py-2.5 px-3 rounded-lg transition {{ request()->routeIs('front.posts*') ? 'text-blue-600 bg-blue-50/50' : 'text-slate-600 hover:text-blue-600' }}">Smancida News</a>

            <a href="/#ekstrakurikuler" class="nav-link block text-xs font-semibold hover:text-blue-600 hover:bg-slate-50 py-2.5 px-3 rounded-lg transition {{ request()->routeIs('ekstrakurikuler*') ? 'text-blue-600 bg-blue-50/50 ' : 'text-slate-600 hover:text-blue-600' }}">Ekstrakurikuler</a>
        </div>
    </nav>

    <!-- Konten Utama Aplikasi -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    @include('layouts.footer')

    <!-- Tombol Back to Top -->
    <button id="btnBackToTop" onclick="scrollToTop()" 
            class="fixed bottom-6 right-6 z-50 hidden p-3 rounded-full bg-purple-600 text-white shadow-lg transition-all duration-300 hover:bg-purple-700 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
        <!-- Icon Panah Atas (SVG Tailwind murni) -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18"></path>
        </svg>
    </button>

    <script>
        // Mengambil elemen tombol
        const backToTopButton = document.getElementById("btnBackToTop");

        // Fungsi untuk memantau scroll halaman
        window.onscroll = function() {
            // Jika halaman di-scroll lebih dari 300px, munculkan tombol
            if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                backToTopButton.classList.remove("hidden");
            } else {
                backToTopButton.classList.add("hidden");
            }
        };

        // Fungsi untuk mengarahkan halaman ke paling atas secara smooth (halus)
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        }
    </script>
    
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