<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Website Resmi Sekolah')</title>
    <!-- Tailwind CSS (Gunakan CDN atau build local Anda) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    <!-- Navbar Publik -->
    <nav class="bg-white border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">S</div>
                    <span class="font-extrabold text-slate-800 tracking-tight text-sm sm:text-base">{{ $setting->school_name ?? 'Nama Sekolah' }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-xs font-semibold text-blue-600">Beranda</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-3.5 py-1.5 bg-slate-900 text-white rounded-lg text-xs font-bold hover:bg-slate-800 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-3.5 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-8 border-t border-slate-800 text-center text-xs">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; 2026 {{ $setting->school_name ?? 'Nama Sekolah' }}. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>