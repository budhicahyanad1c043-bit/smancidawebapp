<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ $setting->school_name ?? 'SMAN 1 Cidahu' }}</title>
    
    <!-- CSS KRITIS: Mencegah kedipan sidebar & Alpine sebelum JS dimuat -->
    <style>
        [x-cloak] { display: none !important; }

        @media (max-width: 767px) {
            aside:not([x-init]):not([class*="translate-x-0"]) {
                transform: translateX(-100%);
            }
        }

        /* Scrollbar Halus untuk Sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.6);
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(51, 65, 85, 0.5);
            border-radius: 9999px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(99, 102, 241, 0.5);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-100 antialiased text-slate-800 font-sans selection:bg-blue-500 selection:text-white">
    
    <!-- PEMBUNGKUS UTAMA -->
    <!-- 🌟 sidebarCollapsed: false -> DEFAULT TERBUKA DI DESKTOP -->
    <div x-data="{ 
        sidebarCollapsed: window.innerWidth <= 768 ? false : false,
        openMobileSidebar: false 
        }" 
        @resize.window="if (window.innerWidth >= 768) openMobileSidebar = false" 
        class="flex min-h-screen relative w-full">

        <!-- ========================================================= -->
        <!-- 1. SIDEBAR NAVIGASI TERBARU (MODERN DESAIN)              -->
        <!-- ========================================================= -->
        <aside class="sidebar-mobile-hidden fixed inset-y-0 left-0 z-40 bg-slate-900 border-r border-slate-800/80 text-slate-400 transition-all duration-300 ease-in-out flex flex-col shadow-2xl -translate-x-full md:translate-x-0"
               :class="{
                   'translate-x-0': openMobileSidebar, 
                   '-translate-x-full': !openMobileSidebar,
                   'md:w-16': sidebarCollapsed, 
                   'md:w-64': !sidebarCollapsed
               }">
            
            <!-- Brand Logo & Header Area -->
            <div class="h-16 flex items-center border-b border-slate-800/80 bg-slate-950/60 px-3 flex-shrink-0 transition-all duration-300"
                :class="sidebarCollapsed ? 'justify-center' : 'justify-between px-4'">
                
                <a href="/" class="flex items-center space-x-3 overflow-hidden">
                    @if($setting && $setting->logo)
                        <img src="{{ Storage::url($setting->logo) }}" alt="Logo" class="h-8 w-auto object-contain flex-shrink-0">
                    @else
                        <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                            🏫
                        </div>
                    @endif
                    <span x-show="!sidebarCollapsed" class="font-bold text-xs tracking-wider text-white truncate uppercase">
                        {{ $setting->school_name ?? 'SMAN 1 CIDAHU' }}
                    </span>
                </a>

                <!-- Tombol Toggle khusus Desktop (Bisa di-klik langsung dari sidebar) -->
                <button @click="sidebarCollapsed = !sidebarCollapsed" 
                        class="hidden md:flex p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition"
                        x-show="!sidebarCollapsed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <!-- Menu Isi Sidebar dengan Scroll Mulus -->
            <div class="flex-1 overflow-y-auto px-3 py-5 space-y-6 sidebar-scroll">

                <!-- KELOMPOK 1: MENU UTAMA -->
                <div class="mt-4">
                    <p x-show="!sidebarCollapsed" class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-500/90 mb-2.5">Menu Utama</p>

                    <a href="{{ route('dashboard.index') }}" 
                       class="group relative flex items-center px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ Request::is('dashboard') && !Request::is('dashboard/users*') && !Request::is('dashboard/settings*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/70 hover:text-slate-100' }}" 
                       :class="sidebarCollapsed ? 'md:justify-center md:px-0' : ''"
                       title="Dashboard">
                        
                        <!-- Indicator Garis Aktif -->
                        @if(Request::is('dashboard') && !Request::is('dashboard/users*') && !Request::is('dashboard/settings*'))
                            <span class="absolute left-0 top-2 bottom-2 w-1 bg-white rounded-r-full" x-show="!sidebarCollapsed"></span>
                        @endif

                        <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 {{ Request::is('dashboard') && !Request::is('dashboard/users*') && !Request::is('dashboard/settings*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                        </svg>
                        <span x-show="!sidebarCollapsed" class="truncate">Dashboard</span>
                    </a>
                </div>

                <!-- KELOMPOK 2: MANAJEMEN SISTEM -->
                <div>
                    <p x-show="!sidebarCollapsed" class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-500/90 mb-2.5">Manajemen</p>
                    
                    <div class="space-y-1">
                        <!-- Kelola Pengguna -->
                        <a href="{{ route('users.index') }}" 
                           class="group relative flex items-center px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('users*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/70 hover:text-slate-100' }}" 
                           :class="sidebarCollapsed ? 'md:justify-center md:px-0' : ''"
                           title="Kelola Pengguna">
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('users*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-3'" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            <span x-show="!sidebarCollapsed" class="truncate">Kelola Pengguna</span>
                        </a>
                        
                        <!-- Pengaturan Web -->
                        <a href="{{ route('settings.index') }}" 
                           class="group relative flex items-center px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('settings*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/70 hover:text-slate-100' }}" 
                           :class="sidebarCollapsed ? 'md:justify-center md:px-0' : ''"
                           title="Pengaturan Web">
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('settings*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span x-show="!sidebarCollapsed" class="truncate">Pengaturan Web</span>
                        </a>

                        <!-- Kelola Menu Topbar -->
                        <a href="{{ route('menus.index') }}" 
                           class="group relative flex items-center px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('menus*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/70 hover:text-slate-100' }}" 
                           :class="sidebarCollapsed ? 'md:justify-center md:px-0' : ''"
                           title="Kelola Menu Topbar">
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('menus*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                            </svg>
                            <span x-show="!sidebarCollapsed" class="truncate">Kelola Menu Topbar</span>
                        </a>
                    </div>
                </div>

                <!-- KELOMPOK 3: KONTEN PUBLIK -->
                <div>
                    <p x-show="!sidebarCollapsed" class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-500/90 mb-2.5">Konten Publik</p>
                    <div class="space-y-1">
                        <!-- Artikel & Berita -->
                        <a href="{{ route('posts.index') }}" 
                           class="group relative flex items-center px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('posts*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/70 hover:text-slate-100' }}" 
                           :class="sidebarCollapsed ? 'md:justify-center md:px-0' : ''"
                           title="Artikel & Berita">
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('posts*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <span x-show="!sidebarCollapsed" class="truncate">Artikel & Berita</span>
                        </a>

                        <!-- Kategori Berita -->
                        <a href="{{ route('categories.index') }}" 
                           class="group relative flex items-center px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/70 hover:text-slate-100' }}" 
                           :class="sidebarCollapsed ? 'md:justify-center md:px-0' : ''"
                           title="Kategori Berita">
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('categories.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l6.499 6.499c.404.404.935.61 1.474.61z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 3.464l4.536 4.536a2.25 2.25 0 010 3.182l-6.499 6.499c-.404.404-.935.61-1.474.61" />
                            </svg>
                            <span x-show="!sidebarCollapsed" class="truncate">Kategori Berita</span>
                        </a>

                        <!-- Galeri Foto -->
                        <a href="{{ route('galleries.index') }}" 
                           class="group relative flex items-center px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('galleries.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/70 hover:text-slate-100' }}" 
                           :class="sidebarCollapsed ? 'md:justify-center md:px-0' : ''"
                           title="Galeri Foto">
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('galleries.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span x-show="!sidebarCollapsed" class="truncate">Galeri Foto</span>
                        </a>

                        <!-- Pengumuman -->
                        <a href="{{ route('announcements.index') }}" 
                           class="group relative flex items-center px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('announcements.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/70 hover:text-slate-100' }}" 
                           :class="sidebarCollapsed ? 'md:justify-center md:px-0' : ''"
                           title="Pengumuman">
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('announcements.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v18c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                            <span x-show="!sidebarCollapsed" class="truncate">Pengumuman</span>
                        </a>
                    </div>
                </div>

                <!-- KELOMPOK 4: EKSKUL -->
                <div>
                    <p x-show="!sidebarCollapsed" class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-500/90 mb-2.5">Manajemen Ekskul</p>
                    <div class="space-y-1">
                        <a href="{{ route('extracurriculars.index') }}" 
                           class="group relative flex items-center px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('extracurriculars*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/70 hover:text-slate-100' }}" 
                           :class="sidebarCollapsed ? 'md:justify-center md:px-0' : ''"
                           title="Ekstrakurikuler">
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('extracurriculars*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.098 19.902a3.75 3.75 0 0 0 5.304 0l6.401-6.402M6.75 21A3.75 3.75 0 0 1 3 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 0 0 3.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008Z" />
                            </svg>
                            <span x-show="!sidebarCollapsed" class="truncate">Ekstrakurikuler</span>
                        </a>
                    </div>
                </div>

                <!-- KELOMPOK 5: AKUN & AKSI -->
                <div class="pt-2 border-t border-slate-800/60">
                    <a href="{{ route('profile.edit') }}" 
                       class="group relative flex items-center px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('profile.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/70 hover:text-slate-100' }}" 
                       :class="sidebarCollapsed ? 'md:justify-center md:px-0' : ''"
                       title="Profil Saya">
                        <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('profile.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0zM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" class="truncate">Profil Saya</span>
                    </a>
                </div>

            </div>
        </aside>

        <!-- OVERLAY BACKGROUND MOBILE -->
        <div x-show="openMobileSidebar" @click="openMobileSidebar = false" class="fixed inset-0 z-30 bg-slate-900/60 backdrop-blur-sm md:hidden" x-cloak></div>

        <!-- ========================================================= -->
        <!-- 2. KONTEN AREA UTAMA                                       -->
        <!-- ========================================================= -->
        <div class="flex-1 transition-all duration-300 min-h-screen flex flex-col min-w-0 max-w-full overflow-x-clip relative"
     :class="{ 'md:pl-16': sidebarCollapsed, 'md:pl-64': !sidebarCollapsed }">
            
            <!-- TOPBAR / NAVBAR STICKY -->
            <header class="sticky top-0 z-20 flex items-center justify-between px-4 sm:px-6 py-4 bg-white/90 backdrop-blur-md border-b border-slate-200/80 h-16 w-full shadow-sm">
                
                <!-- Sisi Kiri: Tombol Buka/Tutup Sidebar -->
                <div class="flex items-center space-x-3">
                    
                    <!-- 🌟 Tombol Hamburger Topbar:
                        - Di Mobile (< md): Selalu Muncul
                        - Di Desktop (>= md): HANYA MUNCUL saat sidebarCollapsed === true
                    -->
                    <button @click="if (window.innerWidth < 768) { openMobileSidebar = !openMobileSidebar } else { sidebarCollapsed = !sidebarCollapsed }" 
                            x-show="window.innerWidth < 768 || sidebarCollapsed"
                            x-transition.opacity
                            class="p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-700 focus:outline-none transition-all duration-200 active:scale-95"
                            title="Buka Sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    <!-- Tanggal Hari Ini -->
                    <span class="hidden sm:flex items-center text-xs font-semibold text-slate-500 bg-slate-100/80 border border-slate-200/60 px-3 py-1.5 rounded-xl">
                        <svg class="w-3.5 h-3.5 mr-2 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
                    </span>
                </div>

                <!-- Sisi Kanan: Dropdown Akun Profile -->
                <div x-data="{ openProfile: false }" class="relative">
                    <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center space-x-2 p-1.5 rounded-xl hover:bg-slate-100 transition-all duration-200">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-8 h-8 rounded-lg object-cover border border-slate-200 shadow-sm">
                        @else
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white text-xs font-bold uppercase shadow-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                        <span class="hidden md:block text-xs font-semibold text-slate-700 max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{'rotate-180': openProfile}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <!-- Dropdown Content -->
                    <div x-show="openProfile" class="absolute right-0 mt-2 w-52 bg-white border border-slate-100 rounded-2xl shadow-xl py-1 z-50 overflow-hidden" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="transform opacity-0 scale-95 -translate-y-1"
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="transform opacity-0 scale-95 -translate-y-1">
                        <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/60">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Login Sebagai</p>
                            <p class="text-xs font-bold text-slate-800 truncate">@ {{ Auth::user()->username }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-xs font-medium text-slate-600 hover:bg-slate-50 transition">
                            <svg class="w-4 h-4 mr-2.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Pengaturan Profil
                        </a>
                        <div class="border-t border-slate-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 transition">
                                <svg class="w-4 h-4 mr-2.5 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- 3. AREA KONTEN HALAMAN INJEKSI -->
            <main class="flex-1 p-4 sm:p-6 w-full min-w-0 max-w-full">
                @yield('content')
            </main>

        </div>
    </div>

@stack('scripts')

<script>
    function showBtnLoading(button) {
        const form = button.closest('form');
        if (form && !form.checkValidity()) {
            return;
        }

        const textSpan = button.querySelector('.btn-text');
        const spinner = button.querySelector('.btn-spinner');

        if (textSpan && spinner) {
            textSpan.textContent = 'Menyimpan...';
            spinner.classList.remove('hidden');
            button.disabled = true;
            button.classList.add('opacity-75', 'cursor-not-allowed');
            
            form.submit();
        }
    }
</script>
</body>
</html>