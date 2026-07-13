<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ $setting->school_name ?? 'SMAN 1 Cidahu' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 antialiased">

    <!-- PEMBUNGKUS UTAMA (Semua Variabel Didandani di Sini) -->
    <div x-data="{ 
        sidebarCollapsed: window.innerWidth <= 768 ? false : true, 
        sidebarCollapsed: window.innerWidth >= 768 ? true : false,
        openMobileSidebar: false 
        }" @resize.window="if (window.innerWidth >= 768) openMobileSidebar = false" class="flex-1 transition-all duration-300 min-h-screen flex flex-col min-w-0 max-w-full overflow-x-clip">

        <!-- 1. SIDEBAR NAVIGASI -->
        <aside class="fixed inset-y-0 left-0 z-40 bg-slate-900 text-slate-400 transition-all duration-300 flex flex-col shadow-xl md:translate-x-0"
               :class="{
                   'translate-x-0': openMobileSidebar, 
                   '-translate-x-full': !openMobileSidebar,
                   'md:w-16': sidebarCollapsed, 
                   'md:w-64': !sidebarCollapsed
               }">
            
            <!-- Brand Logo Area -->
            <div class="h-16 flex items-center border-b border-slate-800 bg-slate-950/40 px-4"
                 :class="sidebarCollapsed ? 'md:justify-center' : 'md:px-6'">
                @if($setting && $setting->logo)
                    <img src="{{ Storage::url($setting->logo) }}" alt="Logo" class="h-8 w-auto" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-2'">
                @else
                    <svg class="w-6 h-6 text-blue-500" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-2'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21l-8-4.5v-9L12 3l8 4.5v9L12 21z"></path>
                    </svg>
                @endif
                <span x-show="!sidebarCollapsed" class="font-bold text-sm tracking-wider text-white truncate">
                    {{ $setting ? strtoupper(explode(' ', $setting->school_name)[0]) : 'CIDAHU' }}
                </span>
            </div>

            <!-- Menu Isi Sidebar -->
            <div class="flex-1 overflow-y-auto px-3 py-4 space-y-6">
                <div>
                    <p x-show="!sidebarCollapsed" class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Menu Utama</p>
                    <a href="{{ url('/dashboard') }}" class="flex items-center px-3 py-2 rounded-lg text-xs font-medium transition {{ Request::is('dashboard') && !Request::is('dashboard/users*') && !Request::is('dashboard/settings*') ? 'bg-blue-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}" :class="sidebarCollapsed ? 'md:justify-center' : ''">
                        <svg class="w-4 h-4 flex-shrink-0" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
                        <span x-show="!sidebarCollapsed">Beranda Dashboard</span>
                    </a>
                </div>
                <div>
                    <p x-show="!sidebarCollapsed" class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Manajemen</p>
                    <div class="space-y-1">
                        <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2 rounded-lg text-xs font-medium transition {{ Request::is('dashboard/users*') ? 'bg-blue-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}" :class="sidebarCollapsed ? 'md:justify-center' : ''">
                            <svg class="w-4 h-4 flex-shrink-0" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span x-show="!sidebarCollapsed">Kelola Pengguna</span>
                        </a>
                        <a href="{{ route('settings.index') }}" class="flex items-center px-3 py-2 rounded-lg text-xs font-medium transition {{ Request::is('dashboard/settings*') ? 'bg-blue-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}" :class="sidebarCollapsed ? 'md:justify-center' : ''">
                            <svg class="w-4 h-4 flex-shrink-0" :class="sidebarCollapsed ? 'md:mr-0' : 'mr-3'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span x-show="!sidebarCollapsed">Pengaturan Web</span>
                        </a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- OVERLAY BACKGROUND MOBILE -->
        <div x-show="openMobileSidebar" @click="openMobileSidebar = false" class="fixed inset-0 z-30 bg-slate-900/40 md:hidden" x-cloak></div>

        <!-- 2. KONTEN AREA UTAMA -->
        <div class="flex-1 transition-all duration-300 min-h-screen flex flex-col"
             :class="{ 'md:pl-16': sidebarCollapsed, 'md:pl-64': !sidebarCollapsed }">
            
            <!-- TOPBAR / NAVBAR UTAMA -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-slate-200 h-16">
                <!-- Sisi Kiri: Tombol Hamburger Menu -->
                <div class="flex items-center space-x-3">
                    <button @click="if (window.innerWidth < 768) { openMobileSidebar = !openMobileSidebar } else { sidebarCollapsed = !sidebarCollapsed }" 
                            class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="hidden sm:flex items-center text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-md">
                        <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
                    </span>
                </div>

                <!-- Sisi Kanan: Dropdown Akun -->
                <div x-data="{ openProfile: false }" class="relative">
                    <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center space-x-2 p-1 rounded-lg hover:bg-slate-50 transition">
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="{'rotate-180': openProfile}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <!-- ISI DROPDOWN DROPDOWN -->
                    <div x-show="openProfile" class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-lg shadow-lg py-1 z-50 overflow-hidden" x-cloak>
                        <div class="px-4 py-2 border-b border-slate-100 bg-slate-50/50">
                            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Masuk Sebagai</p>
                            <p class="text-xs font-bold text-slate-700 truncate">@ {{ Auth::user()->username }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 transition">
                                <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- 3. KONTEN HALAMAN UTAMA -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>