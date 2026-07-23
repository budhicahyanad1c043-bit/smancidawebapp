@extends('dashboard.layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-6">
    <!-- Content Header (Page Header) -->
    <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Dashboard</h1>
            <p class="text-xs text-slate-500 mt-0.5">Halaman kontrol utama SIM SMAN 1 Cidahu</p>
        </div>
        <div class="text-xs text-right text-slate-400 font-medium p-4">
            Home &nbsp;/&nbsp; <span class="text-slate-600 font-semibold">Dashboard</span>
        </div>
    </div>

    <!-- AdminLTE Style Info Boxes (Statistik Berwarna) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Info Box: Database -->
        <div class="bg-white flex rounded-lg shadow-sm border border-slate-200 overflow-hidden min-h-[80px]">
            <div class="w-16 bg-blue-600 flex items-center justify-center text-white text-2xl">
                ⚙️
            </div>
            <div class="p-3 flex flex-col justify-center">
                <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Engine</span>
                <span class="text-sm font-bold text-slate-700">MySQL Terhubung</span>
            </div>
        </div>

        <!-- Info Box: Total Artikel/Berita -->
        <div class="bg-white flex rounded-lg shadow-sm border border-slate-200 overflow-hidden min-h-[80px]">
            <div class="w-16 bg-teal-500 flex items-center justify-center text-white text-2xl">
                📰
            </div>
            <div class="p-3 flex flex-col justify-center">
                <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Artikel Web</span>
                <span class="text-lg font-black text-slate-800">12 <span class="text-xs font-normal text-slate-400">Post</span></span>
            </div>
        </div>

        <!-- Info Box: Role Pengguna -->
        <div class="bg-white flex rounded-lg shadow-sm border border-slate-200 overflow-hidden min-h-[80px]">
            <div class="w-16 bg-amber-500 flex items-center justify-center text-white text-2xl">
                👤
            </div>
            <div class="p-3 flex flex-col justify-center">
                <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Hak Akses</span>
                <span class="text-sm font-bold text-slate-700 capitalize">{{ auth()->user()->role }}</span>
            </div>
        </div>

        <!-- Info Box: Pengunjung / Traffic -->
        <div class="bg-white flex rounded-lg shadow-sm border border-slate-200 overflow-hidden min-h-[80px]">
            <div class="w-16 bg-red-500 flex items-center justify-center text-white text-2xl">
                📈
            </div>
            <div class="p-3 flex flex-col justify-center">
                <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Kunjungan</span>
                <span class="text-lg font-black text-slate-800">1,240 <span class="text-xs font-normal text-slate-400">Hits</span></span>
            </div>
        </div>
    </div>

    <!-- Main Row (Dua Kolom Khas AdminLTE) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri Luas (Card Ringkasan & Sistem) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- AdminLTE Card: Informasi Proyek -->
            <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-700 flex items-center">
                        <span class="mr-2">🖥️</span> Sistem Manajemen Informasi Sekolah
                    </h3>
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold uppercase rounded">Online</span>
                </div>
                <div class="p-6 space-y-4">
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Selamat datang di halaman panel kendali utama **SIM SMANCIDA**. Melalui halaman ini, Anda dapat memperbarui informasi seketika terkait profile instansi, manajemen jurnalis, serta publikasi berita resmi sekolah.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-lg">
                            <span class="text-xs text-slate-400 font-bold block mb-1">LOGGED IN AS</span>
                            <span class="text-sm font-bold text-slate-800 block">{{ auth()->user()->name }}</span>
                            <span class="text-xs text-slate-500 font-mono">{{ auth()->user()->email }}</span>
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-lg">
                            <span class="text-xs text-slate-400 font-bold block mb-1">LOCAL ENVIRONMENT</span>
                            <span class="text-sm font-bold text-slate-800 block">Host: 127.0.0.1</span>
                            <span class="text-xs text-emerald-600 font-semibold">Database: db_sman1cidahu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AdminLTE Card: Aktivitas Terbaru (Simulasi Tabel Kecil) -->
            <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200">
                    <h3 class="text-sm font-bold text-slate-700">📝 Log Aktivitas Terakhir</h3>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-slate-100/70 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase">
                                <th class="p-3 pl-4">Waktu</th>
                                <th class="p-3">User</th>
                                <th class="p-3">Aktivitas</th>
                                <th class="p-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            <tr>
                                <td class="p-3 pl-4 text-xs font-mono">Baru saja</td>
                                <td class="p-3 font-semibold text-slate-800">{{ auth()->user()->username }}</td>
                                <td class="p-3 text-xs">Berhasil melakukan autentikasi login</td>
                                <td class="p-3 text-center"><span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[10px] font-bold border border-emerald-100">Success</span></td>
                            </tr>
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-3 pl-4 text-xs font-mono">Hari ini</td>
                                <td class="p-3 font-semibold text-slate-800">System</td>
                                <td class="p-3 text-xs">Eksekusi `php artisan migrate:fresh --seed`</td>
                                <td class="p-3 text-center"><span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[10px] font-bold border border-blue-100">Migrated</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan Sempit (Informasi Server & Spek) -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200">
                    <h3 class="text-sm font-bold text-slate-700">📊 Informasi Spesifikasi</h3>
                </div>
                <div class="p-4 space-y-3 text-sm">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <span class="text-slate-500 font-medium">Laravel Version</span>
                        <span class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">v13.19.0</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <span class="text-slate-500 font-medium">PHP Version</span>
                        <span class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">v8.5.8</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <span class="text-slate-500 font-medium">Server Driver</span>
                        <span class="text-xs text-slate-600 font-semibold">Artisan Development</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Database Name</span>
                        <span class="font-mono text-xs text-blue-600 font-bold">db_sman1cidahu</span>
                    </div>
                </div>
            </div>

            <!-- Card Bantuan / Petunjuk Singkat -->
            <div class="bg-slate-900 rounded-lg p-4 text-white shadow-sm">
                <h4 class="text-xs uppercase font-bold text-blue-400 tracking-wider mb-2">💡 Tips Administrator</h4>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Pastikan untuk selalu menjaga kerahasiaan kredensial akun Anda. Jika ingin menambahkan jurnalis baru, gunakan modul <span class="text-blue-300 font-semibold">Kelola User</span>.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection