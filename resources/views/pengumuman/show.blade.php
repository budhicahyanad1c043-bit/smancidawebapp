@extends('layouts.app')
@section('title', 'Lihat Pengumuman')
@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4">
        
        <!-- Tombol Kembali -->
        <a href="{{ route('front.announcements.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-purple-600 mb-6 transition">
            ← Kembali ke Semua Pengumuman
        </a>

        <!-- Konten Utama -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm">
            
            <!-- Badge Kategori Kepentingan -->
            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider inline-block mb-4
                {{ $announcement->type == 'penting' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-blue-50 text-blue-600 border border-blue-200' }}">
                📢 Maklumat {{ $announcement->type }}
            </span>

            <!-- Judul -->
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-800 leading-snug mb-3">
                {{ $announcement->title }}
            </h1>

            <!-- Meta Data -->
            <div class="flex items-center gap-3 text-xs text-slate-400 border-b border-slate-100 pb-5 mb-6 font-medium">
                <span class="flex items-center gap-1">
                    Diterbitkan: {{ $announcement->created_at->format('d F Y') }}
                </span>
                <span>•</span>
                <span>Oleh: {{ $announcement->user->name }}</span>
            </div>

            <!-- Isi Pengumuman -->
            <div class="text-slate-600 text-xs md:text-sm leading-relaxed space-y-4 whitespace-pre-line">
                {!! $announcement->content !!}
            </div>

        </div>

    </div>
</div>
@endsection