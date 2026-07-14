<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SMAN 1 Cidahu - Sukabumi')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased font-sans">

    <!-- TOP HEADER (Logo & Nama Sekolah) -->
    <header class="bg-white border-b border-slate-100 py-4">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center gap-4">
            <!-- Tempatkan berkas logo smancida.jpg di folder public/images/ -->
            @if($setting && $setting->logo)
                <img src="{{ Storage::url($setting->logo) }}" alt="Logo" class="h-20 w-auto object-contain">
            @else
                <span class="text-2xl">🏫</span>
            @endif
            <div class="text-center sm:text-left">
                <h1 class="text-2xl font-bold tracking-tight text-blue-900">{{ $setting->school_name ?? 'SMAN 1 Cidahu' }}</h1>
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold mt-0.5">{{ $setting->vision ?? 'Visi dan misi belum diatur oleh administrator.' }}</p>
                <p class="text-xs text-slate-400 mt-1">Kabupaten Sukabumi, Jawa Barat</p>
            </div>
        </div>
    </header>

    <!-- NAVIGATION BAR (Tetap di atas pada semua ukuran layar) -->
    <nav class="sticky top-0 z-50 bg-blue-700 text-white shadow-md">
        <!-- Tambahkan kelas 'overflow-x-auto' agar menu di HP bisa digeser ke samping jika layarnya kekecilan -->
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-14 overflow-x-auto whitespace-nowrap scrollbar-none">
            <!-- Menu Utama -->
            <div class="flex items-center space-x-1 text-sm font-medium">
                <a href="#" class="px-3 py-1.5 rounded-lg bg-blue-800 text-white transition">Home</a>
                <a href="#profil" class="px-3 py-1.5 rounded-lg hover:bg-blue-600 transition text-blue-50">Profil</a>
                <a href="#akademis" class="px-3 py-1.5 rounded-lg hover:bg-blue-600 transition text-blue-50">Akademis</a>
                <a href="#ekstrakurikuler" class="px-3 py-1.5 rounded-lg hover:bg-blue-600 transition text-blue-50">Ekstrakurikuler</a>
                <a href="#tentang-kami" class="px-3 py-1.5 rounded-lg hover:bg-blue-600 transition text-blue-50">Tentang Kami</a>
            </div>
            
            <!-- Link Akses Cepat / Portal -->
            <div class="hidden md:block ml-4">
                <a href="#" class="bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold px-4 py-2 rounded shadow-sm uppercase tracking-wider transition">
                    PPDB 2026
                </a>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER & INFORMASI KONTAK -->
    <footer id="tentang-kami" class="bg-slate-900 text-slate-300 pt-16 pb-8 border-t-4 border-blue-700">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12 mb-12">
            <div>
                <h4 class="text-white font-bold text-lg mb-4 border-l-4 border-blue-500 pl-3">{{ $setting->school_name ?? 'SMAN 1 Cidahu' }}</h4>
                <p class="text-sm leading-relaxed text-slate-400">
                    Satuan pendidikan menengah atas negeri berkomitmen melahirkan generasi cerdas, berkarakter luhur, berbudaya lingkungan, serta siap bersaing di era global.
                </p>
            </div>
            <div>
                <h4 class="text-white font-bold text-lg mb-4 border-l-4 border-blue-500 pl-3">Hubungi Kami</h4>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li class="flex items-start gap-2.5">
                        <span class="text-blue-400 mt-1">📍</span>
                        <span>{{ $setting->address ?? 'Alamat belum diatur.' }}</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="text-blue-400 mt-1">📞</span>
                        <span>{{ $setting->phone ?? '-' }}</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="text-blue-400">✉️</span>
                        <a href="mailto:smanegeri1cidahu@gmail.com" class="hover:underline hover:text-white">{{ $setting->email ?? '-' }}</a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="text-blue-400">🌐</span>
                        <a href="{{ $setting->website ?? '#' }}" target="_blank" class="hover:underline hover:text-white">{{ $setting->website ?? 'www.sman1cidahusmi.sch.id' }}</a>
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold text-lg mb-4 border-l-4 border-blue-500 pl-3">Tautan Pintar</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="#" class="hover:text-white transition">Kementerian Pendidikan R.I</a></li>
                    <li><a href="#" class="hover:text-white transition">Dinas Pendidikan Provinsi Jabar</a></li>
                    <li><a href="#" class="hover:text-white transition">Sistem Informasi Kelulusan</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 pt-6 border-t border-slate-800 text-center text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} {{ $setting->school_name ?? 'SMAN 1 Cidahu' }}. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>