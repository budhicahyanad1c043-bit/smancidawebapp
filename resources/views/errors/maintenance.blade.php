<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situs Dalam Pemeliharaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full text-center space-y-6">
        
        <!-- Ilustrasi SVG -->
        <div class="inline-flex p-4 rounded-full bg-slate-800 text-purple-400 border border-slate-700 shadow-xl">
            <svg class="w-16 h-16 animate-pulse" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l5.654-4.654m0 0l-3.03 2.496a2.002 2.002 0 01-.766 1.208m0 0L3 21m0 0l3-3"></path>
            </svg>
        </div>

        <div class="space-y-2">
            <h1 class="text-3xl font-extrabold tracking-tight">Sedang Pemeliharaan System</h1>
            <p class="text-slate-400 text-sm leading-relaxed">
                Mohon maaf atas ketidaknyamanannya. Website sekolah kami saat ini sedang dalam proses pembaruan data dan peningkatan layanan.
            </p>
        </div>

        <div class="p-4 bg-slate-800/60 rounded-xl border border-slate-700/50 text-xs text-slate-400">
            ⏳ Kami akan segera kembali online. Terima kasih atas kesabaran Anda.
        </div>

        <!-- Tombol Login Admin (Akses Tersembunyi) -->
        <div class="pt-4">
            <a href="{{ route('login') }}" class="text-xs text-slate-500 hover:text-slate-300 transition-colors">
                Login Petugas / Admin &rarr;
            </a>
        </div>
    </div>
</body>
</html>