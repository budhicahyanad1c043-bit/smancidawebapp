@extends('dashboard.layouts.admin') {{-- Sesuaikan dengan nama layout dashboard Anda --}}
@section('title', 'Main Dashboard')
@section('content')
<div class="space-y-6">

    <!-- HERO / WELCOME CARD -->
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 space-y-3">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-xs font-medium border border-white/20">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Dashboard Admin & Penulis</span>
            </div>
            
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                Selamat Datang Kembali, {{ $user->name }}! 👋
            </h1>
            
            <p class="text-blue-100 text-xs sm:text-sm max-w-xl leading-relaxed">
                Senang melihat Anda kembali. Kelola postingan, pengumuman, dan aktivitas web sekolah dengan mudah di sini.
            </p>

            <!-- LAST LOGIN BADGE -->
            <div class="pt-2 flex items-center space-x-2 text-xs text-blue-200">
                <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>
                    Login Terakhir: 
                    <strong class="text-white font-semibold">
                        {{ $user->last_login_at ? $user->last_login_at->translatedFormat('d F Y, H:i') . ' WIB' : 'Baru Pertama Login' }}
                    </strong>
                </span>
            </div>
        </div>

        <!-- Decorative Background Circle -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- STATISTIK RINGKASAN -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        
        <!-- Total Postingan Saya -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Postingan Saya</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $userPostsCount }} Artikel</h3>
            </div>
        </div>

        <!-- Role Status -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Peran Anda</p>
                <h3 class="text-lg font-bold text-slate-800 capitalize">{{ $user->role ?? 'Penulis' }}</h3>
            </div>
        </div>

        <!-- Total Seluruh Artikel Web (Opsional) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Artikel Web</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $totalAllPosts }} Artikel</h3>
            </div>
        </div>

    </div>

    <!-- TABEL POSTINGAN TERBARU MILIK USER -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-800">Postingan Terbaru Anda</h2>
                <p class="text-xs text-slate-400">Daftar artikel/berita yang terakhir Anda buat.</p>
            </div>
            <a href="{{ route('posts.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-md transition">
                + Buat Postingan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3 px-4">Judul Artikel</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4 text-center">Tanggal Dibuat</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse($recentPosts as $post)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4 font-semibold text-slate-800">
                                {{ Str::limit($post->title, 50) }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 font-medium text-[10px]">
                                    {{ $post->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center text-slate-400">
                                {{ $post->created_at->translatedFormat('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-center space-x-2">
                                <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-600 font-semibold hover:underline">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">
                                Belum ada postingan yang Anda buat. Yuk buat artikel pertama Anda!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection