@extends('layouts.app')

@section('title', 'Beranda - Portal Informasi Sekolah')

@section('content')
<!-- Hero Section -->
<div class="bg-white border-b border-slate-100 py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">Pusat Informasi Utama</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight max-w-2xl mx-auto">Selamat Datang di Portal Berita</h1>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight max-w-2xl mx-auto">{{ $setting->school_name ?? 'Nama Sekolah' }}</h2>
        <p class="text-sm text-slate-500 max-w-xl mx-auto">Temukan berita terhangat, pengumuman resmi, agenda, dan berbagai prestasi akademik maupun non-akademik di sini.</p>
    </div>
</div>

<!-- News Grid Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-lg font-extrabold text-slate-900 mb-8 flex items-center">
        <span class="w-1.5 h-5 bg-blue-600 rounded-full mr-2.5 inline-block"></span>
        Kabar Terbaru Sekolah
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $post)
        <div class="bg-white border border-slate-200/60 rounded-xl overflow-hidden hover:shadow-md hover:-translate-y-1 transition duration-200 flex flex-col h-full">
            <!-- Thumbnail Cover -->
            @if($post->image)
                <img src="{{ Storage::url($post->image) }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-slate-100 flex items-center justify-center text-slate-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375 0 11-.75 0 .375 0 01.75 0z"></path></svg>
                </div>
            @endif

            <!-- Body Card -->
            <div class="p-5 flex-grow flex flex-col justify-between">
                <div class="space-y-2.5">
                    <div class="flex items-center space-x-2 text-[10px] font-bold uppercase tracking-wider">
                        <span class="text-blue-600">{{ $post->category->name ?? 'Tanpa Kategori' }}</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-slate-400">{{ $post->created_at->format('d M Y') }}</span>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm sm:text-base line-clamp-2 hover:text-blue-600 transition">
                        <a href="{{ route('home.posts.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>
                    <!-- Menghilangkan tag html menggunakan strip_tags agar teks pratonton bersih -->
                    <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                        {{ strip_tags($post->content) }}
                    </p>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-50 flex items-center justify-between">
                    <span class="text-[10px] font-semibold text-slate-400">Penulis: {{ $post->user->name }}</span>
                    <a href="{{ route('home.posts.show', $post->slug) }}" class="text-[11px] font-bold text-blue-600 hover:text-blue-700">Baca Selengkapnya &rarr;</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-slate-400 text-xs">
            Belum ada berita yang diterbitkan untuk saat ini.
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-10">
        {{ $posts->links() }}
    </div>
</div>
@endsection