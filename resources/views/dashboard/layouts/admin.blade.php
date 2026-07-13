<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Admin SMAN 1 Cidahu</title>
    <!-- Font Profesional Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Mengimpor Alpine.js langsung dari CDN jika belum terintegrasi di vite -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased text-sm" 
      x-data="{ sidebarOpen: true, sidebarCollapsed: false }">

    <!-- BACKDROP / OVERLAY (Hanya Muncul di Mobile saat Offcanvas Aktif) -->
    <div x-show="sidebarOpen" 
         x-transition:opacity
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-slate-900/40 z-40 lg:hidden" x-cloak></div>

    <div class="flex min-h-screen">
        
    <!-- SIDEBAR (Offcanvas Mobile & Collapsible Desktop) -->
    <aside class="bg-slate-900 text-slate-300 flex flex-col fixed inset-y-0 left-0 z-50 shadow-xl border-r border-slate-800 transition-all duration-300 ease-in-out"
               :class="{
                   'translate-x-0': sidebarOpen,
                   '-translate-x-full lg:translate-x-0': !sidebarOpen,
                   'w-64': !sidebarCollapsed,
                   'w-20': sidebarCollapsed
               }">
            
        <!-- Brand Logo Area -->
        <div class="h-16 flex items-center border-b border-slate-800 bg-slate-950/40 transition-all duration-300"
            :class="sidebarCollapsed ? 'px-4 justify-center' : 'px-6'">
            @if($setting && $setting->logo)
                <img src="{{ Storage::url($setting->logo) }}" alt="Logo" class="h-8 w-auto" :class="sidebarCollapsed ? 'mr-0' : 'mr-2'">
            @else
                <!-- SVG Cadangan jika Logo Kosong -->
                <svg class="w-6 h-6 text-blue-500" :class="sidebarCollapsed ? 'mr-0' : 'mr-2'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21l-8-4.5v-9L12 3l8 4.5v9L12 21z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12l8-4.5M12 12v9M12 12L4 7.5"></path>
                </svg>
            @endif
            <span x-show="!sidebarCollapsed" x-transition.opacity class="font-bold text-sm tracking-wider text-white truncate">
                {{ $setting->school_name ?? 'Not Setting yet!' }}
            </span>
        </div>

        <div class="flex-1 overflow-y-auto px-3 py-4 space-y-6">
        
            <!-- Kelompok: Menu Utama -->
            <div>
                <p x-show="!sidebarCollapsed" x-transition.opacity class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">
                    Menu Utama
                </p>
                <div class="space-y-1">
                    <!-- Beranda Dashboard -->
                    <a href="{{ url('/dashboard') }}" 
                    class="flex items-center px-3 py-2 rounded-lg text-xs font-medium transition group {{ Request::is('dashboard') && !Request::is('dashboard/users*') && !Request::is('dashboard/settings*') ? 'bg-blue-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}"
                    :class="sidebarCollapsed ? 'justify-center' : ''">
                        <!-- SVG Dashboard / Grid -->
                        <svg class="w-4 h-4 flex-shrink-0 transition" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition.opacity>Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Kelompok: Manajemen -->
            <div>
                <p x-show="!sidebarCollapsed" x-transition.opacity class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">
                    Manajemen
                </p>
                <div class="space-y-1">
                    <!-- Kelola Pengguna -->
                    <a href="{{ route('users.index') }}" 
                    class="flex items-center px-3 py-2 rounded-lg text-xs font-medium transition group {{ Request::is('dashboard/users*') ? 'bg-blue-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}"
                    :class="sidebarCollapsed ? 'justify-center' : ''">
                        <!-- SVG Users / Kelompok Pengguna -->
                        <svg class="w-4 h-4 flex-shrink-0 transition" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition.opacity>Kelola Pengguna</span>
                    </a>

                    <!-- Pengaturan Web -->
                    <a href="{{ route('settings.index') }}" 
                    class="flex items-center px-3 py-2 rounded-lg text-xs font-medium transition group {{ Request::is('dashboard/settings*') ? 'bg-blue-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}"
                    :class="sidebarCollapsed ? 'justify-center' : ''">
                        <!-- SVG Gear / Cog Pengaturan -->
                        <svg class="w-4 h-4 flex-shrink-0 transition" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition.opacity>Pengaturan Web</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Sidebar Footer / Logout -->
        <div class="p-3 border-t border-slate-800 bg-slate-950/20">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center rounded-lg text-left px-4 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition duration-150">
                    <!-- SVG Logout -->
                    <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition.opacity>Keluar Aplikasi</span>
                </button>
            </form>
        </div>
    </aside>

        <!-- MAIN CONTENT AREA -->
        <!-- Margin dinamis disesuaikan dengan kondisi lebar/ciut dari sidebar -->
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out"
             :class="{
                 'lg:ml-64': !sidebarCollapsed,
                 'lg:ml-20': sidebarCollapsed,
                 'ml-0': true
             }">
             
            <!-- NAVBAR ATAS -->
            <header class="bg-white h-16 border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-40 shadow-sm">
                
                <!-- Tombol Hamburgers / Toggles -->
                <div class="flex items-center space-x-3">
                    <!-- Tombol Mobile (Aksi seperti Offcanvas Bootstrap) -->
                    <!-- TOMBOL HAMBURGER / OFFCANVAS TOGGLE SIDEBAR -->
                    <button @click="sidebarCollapsed = !sidebarCollapsed" 
                            class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition duration-150"
                            title="Toggle Sidebar">
                        <!-- SVG Hamburger Menu Dinamis (Berubah bentuk panah/garis saat diklik) -->
                        <svg class="w-5 h-5 transition-transform duration-300" 
                            :class="sidebarCollapsed ? 'rotate-180' : ''"
                            fill="none" 
                            stroke="currentColor" 
                            stroke-width="2" 
                            viewBox="0 0 24 24">
                            <!-- Kondisi Garis Hamburger Standar (Saat Sidebar Terbuka) -->
                            <path x-show="!sidebarCollapsed" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                            <!-- Kondisi Berubah Menjadi Panah / Garis Penuh (Saat Sidebar Tertutup) -->
                            <path x-show="sidebarCollapsed" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <div class="text-xs font-semibold text-slate-500 hidden sm:flex items-center bg-slate-100 px-3 py-1.5 rounded-md">
                        <span class="flex items-center text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-md">
                        <!-- SVG Kalender -->
                        <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
                    </span>
                    </div>
                </div>
                
                <!-- Profil Pojok Kanan -->
                <!-- Sisi Kanan: Dropdown Profil Pengguna & Logout -->
                <!-- Menggunakan Alpine.js untuk kontrol buka/tutup dropdown -->
                <div x-data="{ openProfile: false }" class="relative">
                    
                    <!-- Tombol Pemicu Dropdown -->
                    <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center space-x-3 focus:outline-none focus:ring-2 focus:ring-blue-500/20 rounded-lg p-1 hover:bg-slate-50 transition duration-150">
                        <!-- Avatar Bulat Huruf Depan Nama -->
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <!-- Nama Pengguna & Tanda Panah -->
                        <div class="hidden md:flex flex-col text-left">
                            <span class="text-xs font-bold text-slate-700 leading-none">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-slate-400 font-medium capitalize mt-0.5">{{ Auth::user()->role }}</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{'rotate-180': openProfile}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Kotak Sub-Menu Dropdown (Muncul di kanan bawah tombol) -->
                    <div x-show="openProfile" 
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-lg shadow-lg py-1 z-50 overflow-hidden"
                        x-cloak>
                        
                        <!-- Header Dropdown: Info Akun Singkat -->
                        <div class="px-4 py-2 border-b border-slate-100 bg-slate-50/50">
                            <p class="text-[10px] font-semibold text-slate-400 tracking-wider uppercase">Masuk Sebagai</p>
                            <p class="text-xs font-bold text-slate-700 truncate mt-0.5">{{ Auth::user()->username }}</p>
                        </div>

                        <!-- Tautan Navigasi Dropdown Lainnya (Opsional) -->
                        <a href="#" class="flex items-center px-4 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition duration-150">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil Saya
                        </a>

                        <!-- Tombol Keluar / Logout Terproteksi Form POST -->
                        <div class="border-t border-slate-100 mt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center text-left px-4 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition duration-150">
                                    <!-- SVG Logout -->
                                    <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Keluar Aplikasi
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </header>

            <!-- AREA VIEW KONTEN -->
            <main class="p-8 flex-1">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>