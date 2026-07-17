@extends('layouts.app')
@section('title', 'Tampil Pengumuman')
@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
        
        <div class="text-center mb-12">
            <span class="text-xs font-bold text-purple-600 uppercase tracking-widest block mb-1">Informasi Resmi</span>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Semua Pengumuman Sekolah</h1>
            <p class="text-xs text-slate-500 mt-2">Daftar maklumat, arsip pengumuman, dan berita resmi SMAN 1 Cidahu</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($announcements as $announcement)
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between relative overflow-hidden group">
                    @if($announcement->type == 'penting')
                        <div class="absolute top-0 right-0 bg-red-500 text-white text-[9px] font-black uppercase tracking-wider px-3 py-1 rounded-bl-xl shadow-sm">
                            Penting
                        </div>
                    @endif

                    <div>
                        <div class="flex items-center gap-2 text-[11px] text-slate-400 font-medium mb-3">
                            <span>{{ $announcement->created_at->format('d M Y') }}</span>
                            <span>•</span>
                            <span>{{ $announcement->user->name }}</span>
                        </div>

                        <h3 class="text-sm font-bold text-slate-800 line-clamp-2 mb-2.5 group-hover:text-purple-600 transition">
                            {{ $announcement->title }}
                        </h3>

                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-5">
                            {{ strip_tags($announcement->content) }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-semibold {{ $announcement->type == 'penting' ? 'text-red-500' : 'text-blue-500' }} uppercase tracking-wider">
                            📢 {{ $announcement->type }}
                        </span>
                        <a href="{{ route('front.announcements.show', $announcement->slug) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 border border-slate-200 text-slate-600 hover:bg-purple-600 hover:text-white hover:border-purple-600 transition duration-200">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-3 p-12 text-center bg-white border border-dashed border-slate-200 rounded-2xl">
                    <p class="text-xs text-slate-400 italic">Belum ada pengumuman resmi saat ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination Links -->
        <div class="mt-10">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
@endsection