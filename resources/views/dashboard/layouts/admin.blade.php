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
            
            <!-- Brand Logo -->
            <div class="h-16 flex items-center border-b border-slate-800 bg-slate-950/40 transition-all duration-300"
                 :class="sidebarCollapsed ? 'px-4 justify-center' : 'px-6'">
                <div class="bg-blue-600 text-white font-black px-2 py-1 rounded text-xs shadow-md shadow-blue-500/20"
                     :class="sidebarCollapsed ? 'mr-0 text-center' : 'mr-2'">
                    SMAN1
                </div>
                <span x-show="!sidebarCollapsed" x-transition.opacity class="font-bold text-sm tracking-wider text-white">CIDAHU</span>
            </div>

            <!-- User Panel -->
            <div class="p-4 border-b border-slate-800 flex items-center bg-slate-950/10 transition-all duration-300"
                 :class="sidebarCollapsed ? 'justify-center space-x-0' : 'space-x-3'">
                <div class="h-9 w-9 bg-slate-800 text-blue-400 font-bold rounded-full flex items-center justify-center border border-slate-700 shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div x-show="!sidebarCollapsed" x-transition.opacity class="overflow-hidden">
                    <p class="text-xs font-semibold text-white leading-none mb-1 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider flex items-center">
                        <span class="h-1.5 w-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span>
                        Online
                    </span>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
                <span x-show="!sidebarCollapsed" class="px-3 py-2 block text-[10px] font-bold uppercase tracking-wider text-slate-500">Menu Utama</span>
                
                <!-- Menu Beranda -->
                <a href="{{ route('dashboard') }}" class="flex items-center rounded-lg font-medium text-xs transition duration-150 {{ Request::routeIs('dashboard') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
                   :class="sidebarCollapsed ? 'p-2.5 justify-center' : 'px-3 py-2.5'">
                    <span class="text-sm" :class="sidebarCollapsed ? '' : 'mr-3'">📊</span> 
                    <span x-show="!sidebarCollapsed" x-transition.opacity>Beranda Dashboard</span>
                </a>

                <span x-show="!sidebarCollapsed" class="px-3 py-2 block text-[10px] font-bold uppercase tracking-wider text-slate-500 pt-4">Manajemen</span>

                <!-- Menu Kelola User -->
                <a href="{{ route('users.index') }}" class="flex items-center rounded-lg font-medium text-xs transition duration-150 {{ Request::routeIs('users.index*') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
                   :class="sidebarCollapsed ? 'p-2.5 justify-center' : 'px-3 py-2.5'">
                    <span class="text-sm" :class="sidebarCollapsed ? '' : 'mr-3'">👥</span> 
                    <span x-show="!sidebarCollapsed" x-transition.opacity>Kelola Pengguna</span>
                </a>

                <!-- Menu Setting Website -->
                <a href="{{ route('settings.index') }}" class="flex items-center rounded-lg font-medium text-xs transition duration-150 {{ Request::routeIs('settings.index*') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}"
                   :class="sidebarCollapsed ? 'p-2.5 justify-center' : 'px-3 py-2.5'">
                    <span class="text-sm" :class="sidebarCollapsed ? '' : 'mr-3'">⚙️</span> 
                    <span x-show="!sidebarCollapsed" x-transition.opacity>Pengaturan Web</span>
                </a>
            </nav>

            <!-- Sidebar Footer / Logout -->
            <div class="p-3 border-t border-slate-800 bg-slate-950/20">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-slate-500 hover:text-red-400 font-medium text-xs flex items-center rounded-lg hover:bg-red-500/5 transition"
                            :class="sidebarCollapsed ? 'p-2 justify-center' : 'px-3 py-2'">
                        <span class="text-sm" :class="sidebarCollapsed ? '' : 'mr-3'">🚪</span> 
                        <span x-show="!sidebarCollapsed" x-transition.opacity>Kelola Keluar</span>
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
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 lg:hidden focus:outline-none">
                        ☰
                    </button>
                    <!-- Tombol Desktop (Aksi menciutkan / memaksimalisasi) -->
                    <button @click="sidebarCollapsed = !sidebarCollapsed" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 hidden lg:block focus:outline-none text-base">
                        🔀
                    </button>
                    
                    <div class="text-xs font-semibold text-slate-500 hidden sm:flex items-center bg-slate-100 px-3 py-1.5 rounded-md">
                        📅 &nbsp; <span class="text-slate-700 font-medium">{{ date('d M Y') }}</span>
                    </div>
                </div>
                
                <!-- Profil Pojok Kanan -->
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-xs font-bold text-slate-800">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-[9px] uppercase font-extrabold tracking-widest text-blue-600 mt-0.5 px-1.5 py-0.5 bg-blue-50 border border-blue-100 rounded inline-block">
                            {{ auth()->user()->role ?? 'Guest' }}
                        </p>
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