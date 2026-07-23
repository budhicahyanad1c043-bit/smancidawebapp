<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $setting->school_name ?? 'Portal Sekolah')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine JS & SweetAlert2 -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<!-- Menginisialisasi State Mobile Menu di Body Menggunakan Alpine.js -->
<body x-data="{ mobileMenuOpen: false }" class="bg-slate-50 antialiased font-sans text-slate-700">
    <!-- 🌟 ANIMASI LOADING GLOBAL -->
    <div id="page-loader" class="fixed inset-0 z-[9999] bg-white flex flex-col items-center justify-center transition-opacity duration-300">
        <div class="relative flex items-center justify-center">
            <!-- Spinner Ring -->
            <div class="w-12 h-12 rounded-full border-4 border-blue-100 border-t-blue-600 animate-spin"></div>
            <!-- Logo kecil di tengah spinner (Opsional) -->
            <div class="absolute text-xs">🏫</div>
        </div>
        <p class="mt-3 text-xs font-semibold text-slate-500 animate-pulse">Memuat halaman...</p>
    </div>
    <!-- Top Bar / Navbar Utama -->
    <nav class="bg-white/95 border-b border-slate-100 sticky top-0 z-40 shadow-sm backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo & Identitas Sekolah -->
                <a href="/" class="flex items-center space-x-3 group shrink-0">
                    @if(isset($setting) && $setting->logo)
                        <img src="{{ Storage::url($setting->logo) }}" alt="Logo Sekolah" class="h-10 w-auto object-contain transition-transform duration-200 group-hover:scale-105">
                    @else
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-lg shadow-md shadow-blue-500/20">
                            🏫
                        </div>
                    @endif
                    <div>
                        <span class="font-bold text-slate-800 text-sm md:text-base tracking-tight block group-hover:text-blue-600 transition">
                            {{ $setting->school_name ?? 'Nama Sekolah' }}
                        </span>
                        <span class="text-[10px] md:text-[11px] text-slate-400 font-medium block -mt-0.5 tracking-tight line-clamp-1">
                            {{ $setting->vision ?? 'Unggul & Berkarakter' }}
                        </span>
                    </div>
                </a>

                <!-- Navigasi Desktop (Dinamis + Dropdown Rapi) -->
                <div class="hidden md:flex items-center space-x-1 lg:space-x-2 text-xs font-semibold">
                    @if(isset($publicTopbarMenus) && $publicTopbarMenus->count() > 0)
                        @foreach($publicTopbarMenus as $menu)
                            @php
                                $hasChildren = $menu->children && $menu->children->count() > 0;
                                $targetUrl = $menu->route_name && Route::has($menu->route_name) 
                                    ? route($menu->route_name) 
                                    : url($menu->url ?? '#');
                                $isActive = $menu->isActiveRoute();
                            @endphp

                            @if($hasChildren)
                                <div class="relative group py-4">
                                    <button type="button" 
                                            class="flex items-center space-x-1.5 px-3 py-2 rounded-lg transition-all duration-200 {{ $isActive ? 'text-blue-600 font-bold bg-blue-50/80' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                        <span>{{ $menu->name }}</span>
                                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-blue-600 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>

                                    <!-- Dropdown Desktop -->
                                    <div class="absolute right-0 top-full hidden group-hover:block w-48 pt-1 z-50">
                                        <div class="bg-white border border-slate-100 rounded-xl shadow-xl shadow-slate-200/60 p-1.5 space-y-0.5">
                                            @foreach($menu->children as $child)
                                                @php
                                                    $childUrl = $child->route_name && Route::has($child->route_name) 
                                                        ? route($child->route_name) 
                                                        : url($child->url ?? '#');
                                                    $isChildActive = $child->isActiveRoute();
                                                @endphp
                                                <a href="{{ $childUrl }}" 
                                                   class="block px-3 py-2 rounded-lg text-xs font-medium transition duration-150 whitespace-nowrap {{ $isChildActive ? 'text-blue-600 bg-blue-50 font-bold' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                                    {{ $child->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ $targetUrl }}" 
                                   class="px-3 py-2 rounded-lg transition-all duration-200 {{ $isActive ? 'text-blue-600 font-bold bg-blue-50/80' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                    {{ $menu->name }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>

                <!-- Tombol Mobile Hamburger (Memicu Event Slide Modal) -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = true" type="button" class="text-slate-600 hover:text-slate-900 focus:outline-none p-2 rounded-xl hover:bg-slate-100 transition" aria-label="Open Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </nav>

    <!-- ================= SLIDE-OVER MOBILE MENU (FULLSCREEN SLIDE DARI KANAN) ================= -->
    <div x-cloak x-show="mobileMenuOpen" class="fixed inset-0 z-50 overflow-hidden md:hidden" role="dialog" aria-modal="true">
        
        <!-- Backdrop Gelap Transparan (Dim Overlay) -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false" 
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm"></div>

        <!-- Panel Sidebar Slide Kanan ke Kiri Penuh -->
        <div class="fixed inset-y-0 right-0 max-w-full flex">
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-md bg-white shadow-2xl flex flex-col justify-between">
                
                <div class="p-5 overflow-y-auto">
                    <!-- Header Modal Slide (Logo & Tombol Close) -->
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                        <span class="font-bold text-slate-800 text-sm">Menu Navigasi</span>
                        <button @click="mobileMenuOpen = false" type="button" class="text-slate-400 hover:text-slate-700 p-2 rounded-xl hover:bg-slate-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Daftar Menu Navigasi Mobile -->
                    <div class="space-y-1">
                        @if(isset($publicTopbarMenus) && $publicTopbarMenus->count() > 0)
                            @foreach($publicTopbarMenus as $menu)
                                @php
                                    $hasChildren = $menu->children && $menu->children->count() > 0;
                                    $targetUrl = $menu->route_name && Route::has($menu->route_name) 
                                        ? route($menu->route_name) 
                                        : url($menu->url ?? '#');
                                    $isActive = $menu->isActiveRoute();
                                @endphp

                                @if($hasChildren)
                                    <!-- Accordion Sub-Menu di dalam Slide Panel -->
                                    <div x-data="{ open: false }" class="space-y-1">
                                        <button @click="open = !open" type="button" 
                                                class="w-full flex items-center justify-between text-xs font-semibold py-3 px-3.5 rounded-xl transition {{ $isActive ? 'text-blue-600 bg-blue-50/60' : 'text-slate-700 hover:bg-slate-50' }}">
                                            <span>{{ $menu->name }}</span>
                                            <svg class="w-4 h-4 transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-blue-600': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>
                                        
                                        <div x-show="open" x-cloak x-transition class="pl-3 space-y-1 border-l-2 border-blue-100 ml-3 my-1">
                                            @foreach($menu->children as $child)
                                                @php
                                                    $childUrl = $child->route_name && Route::has($child->route_name) 
                                                        ? route($child->route_name) 
                                                        : url($child->url ?? '#');
                                                    $isChildActive = $child->isActiveRoute();
                                                @endphp
                                                <a href="{{ $childUrl }}" 
                                                   class="block text-xs font-medium py-2.5 px-3 rounded-lg transition {{ $isChildActive ? 'text-blue-600 font-bold bg-blue-50' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                                    {{ $child->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ $targetUrl }}" 
                                       class="block text-xs font-semibold py-3 px-3.5 rounded-xl transition {{ $isActive ? 'text-blue-600 bg-blue-50 font-bold' : 'text-slate-700 hover:text-blue-600 hover:bg-slate-50' }}">
                                        {{ $menu->name }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Footer Panel Mobile (Opsional) -->
                <div class="p-5 border-t border-slate-100 text-center">
                    <p class="text-[11px] text-slate-400">© {{ date('Y') }} {{ $setting->school_name ?? 'Sekolah' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten Utama -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Tombol Back to Top -->
    <button id="btnBackToTop" onclick="scrollToTop()" 
            class="fixed bottom-6 right-6 z-40 hidden p-3 rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-500/30 transition-all duration-300 hover:bg-blue-700 hover:scale-110 focus:outline-none">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18"></path>
        </svg>
    </button>

    <script>
        const backToTopButton = document.getElementById("btnBackToTop");
        window.onscroll = function() {
            if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                backToTopButton.classList.remove("hidden");
            } else {
                backToTopButton.classList.add("hidden");
            }
        };

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
    </script>
    
    @stack('scripts')
    <script>
    // Sembunyikan loader saat seluruh aset halaman selesai dimuat
        window.addEventListener('load', function() {
            const loader = document.getElementById('page-loader');
            if (loader) {
                loader.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 300);
            }
        });
    </script>
</body>
</html>