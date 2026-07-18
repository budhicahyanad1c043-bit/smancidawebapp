@extends('layouts.app') <!-- Sesuaikan dengan nama file layout utama Anda -->

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Halaman -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-extrabold text-slate-900 sm:text-4xl tracking-tight">
                📰 Berita & Artikel Terbaru
            </h1>
            <p class="mt-3 max-w-2xl mx-auto text-base text-slate-500">
                Temukan informasi menarik, kabar terkini, dan artikel edukatif seputar sekolah kami di sini.
            </p>
        </div>
        <div class="my-8">
            <a href="/" class="text-xs font-bold text-purple-600 hover:text-purple-700 flex items-center gap-1 transition group">
                <span class="transform group-hover:-translate-x-1 transition-transform">←</span>
                Kembali ke Beranda 
            </a>
        </div>
        <!-- Grid Daftar Post -->
        @if($posts->count() > 0)
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($posts as $post)
                    <div class="flex flex-col rounded-2xl shadow-sm border border-slate-200 bg-white overflow-hidden transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                        
                        <!-- Thumbnail Gambar -->
                        <div class="flex-shrink-0 h-48 bg-slate-100 relative">
                            @if($post->image) <!-- Sesuaikan nama kolom gambar di DB Anda, misal: image/thumbnail/cover -->
                                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                            @else
                                <!-- Placeholder jika tidak ada gambar -->
                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                            @endif

                            <!-- Kategori Post (Jika ada relasi kategori) -->
                            @if($post->category)
                                <span class="absolute top-4 left-4 bg-purple-600 text-white text-[10px] font-bold uppercase px-2.5 py-1 rounded-md shadow-sm">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                        </div>

                        <!-- Konten Post -->
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <!-- Tanggal & Penulis -->
                                <div class="flex items-center text-xs font-medium text-slate-400 gap-2">
                                    <span>{{ $post->created_at->translatedFormat('d M Y') }}</span>
                                    <span>•</span>
                                    <span>Oleh: {{ $post->user->name ?? 'Admin' }}</span>
                                </div>
                                
                                <!-- Judul -->
                                <a href="{{ route('front.posts.show-post', $post->slug) }}" class="block mt-2">
                                    <h3 class="text-xl font-bold text-slate-900 hover:text-purple-600 transition-colors line-clamp-2">
                                        {{ $post->title }}
                                    </h3>
                                </a>
                                
                                <!-- Eksper / Cuplikan Konten -->
                                <p class="mt-3 text-sm text-slate-500 line-clamp-3">
                                    {{ strip_tags($post->content) }}
                                </p>
                            </div>

                            <!-- Tombol Selengkapnya -->
                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <a href="{{ route('front.posts.show-post', $post->slug) }}" 
                                   class="inline-flex items-center text-xs font-bold text-purple-600 hover:text-purple-700 group">
                                    Baca Artikel
                                    <svg class="ml-1.5 w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigasi Pagination -->
            <div class="mt-12 flex justify-center">
                <div class="bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                    {{ $posts->links() }}
                </div>
            </div>

        @else
            <!-- State Jika Post Masih Kosong -->
            <div class="text-center py-20 bg-white rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-slate-400 font-medium">Belum ada artikel atau berita yang dipublikasikan.</p>
            </div>
        @endif

    </div>
</div>
@endsection