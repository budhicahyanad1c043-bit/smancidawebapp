<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Non-Aktif - SMAN 1 Cidahu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden text-center p-8 space-y-6">
        
        <!-- ICON WARNING / LOCK -->
        <div class="w-20 h-20 bg-rose-100 text-rose-600 rounded-3xl flex items-center justify-center mx-auto shadow-inner">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
            </svg>
        </div>

        <!-- JUDUL & PESAN -->
        <div class="space-y-2">
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Akun Anda Dinonaktifkan</h1>
            <p class="text-xs text-slate-500 leading-relaxed">
                Maaf, akses ke akun Anda saat ini sedang dibatasi atau ditangguhkan oleh sistem.
            </p>
        </div>

        <!-- BOX INFORMASI -->
        <div class="bg-amber-50 border border-amber-200/60 rounded-2xl p-4 text-left space-y-1">
            <div class="flex items-center space-x-2 text-amber-700 font-bold text-xs">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <span>Apa yang harus dilakukan?</span>
            </div>
            <p class="text-[11px] text-amber-800/80 leading-normal pl-6">
                Silakan hubungi <strong>Administrator Utama Web</strong> untuk mengajukan reaktivasi akun atau konfirmasi status keanggotaan Anda.
            </p>
        </div>

        <!-- TOMBOL AKSI -->
        <div class="pt-2 space-y-3">
            <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20akun%20saya%20dinonaktifkan.%20Mohon%20bantuan%20reaktivasi." 
               target="_blank"
               class="w-full inline-flex items-center justify-center space-x-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-md shadow-emerald-600/20 transition duration-200">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                </svg>
                <span>Hubungi Admin via WhatsApp</span>
            </a>

            <a href="{{ route('login') }}" 
               class="w-full inline-block py-2.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                Kembali ke Halaman Login
            </a>
        </div>

    </div>

</body>
</html>