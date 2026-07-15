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

<!-- Sambutan Kepala Sekolah Section (Estetik Card Baru) -->
<div id="sambutan" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 border-b border-slate-100">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center bg-white border border-slate-200/60 p-6 md:p-8 rounded-2xl shadow-xl shadow-slate-100/30">
        
        <!-- Card Foto Kepala Sekolah -->
        <div class="flex flex-col items-center md:items-start">
            <div class="relative group w-48 h-60 rounded-xl overflow-hidden shadow-md border border-slate-100 bg-slate-50 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                @if($setting && $setting->principal_photo)
                    <img src="{{ Storage::url($setting->principal_photo) }}" alt="Foto Kepala Sekolah" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center bg-blue-50 text-blue-600">
                        <span class="text-5xl mb-2">👤</span>
                        <p class="text-[10px] font-bold uppercase tracking-wider text-blue-400">Foto Kosong</p>
                    </div>
                @endif

                <!-- Efek Hover Gradasi Nama -->
                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-900/80 via-slate-900/40 to-transparent p-4 pt-12 opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                    <p class="text-white text-xs font-bold">{{ $setting->principal_name ?? 'Nama Kepala Sekolah' }}</p>
                    <p class="text-slate-300 text-[10px]">Kepala Sekolah</p>
                </div>
            </div>

            <!-- Identitas Bawah Foto -->
            <div class="mt-4 text-center md:text-left">
                <h3 class="text-sm font-bold text-slate-800 tracking-tight">{{ $setting->principal_name ?? 'Nama Kepala Sekolah, M.Pd.' }}</h3>
                <p class="text-[11px] font-medium text-blue-600">Kepala Sekolah</p>
            </div>
        </div>

        <!-- Konten Narasi Teks Sambutan -->
        <div class="md:col-span-2 space-y-4 text-center md:text-left">
            <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700 uppercase tracking-wider">
                Sambutan Kepala Sekolah
            </div>
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                Membangun Generasi Unggul Melalui <br class="hidden sm:inline"> Transformasi Digital Berkarakter
            </h2>
            <div class="w-12 h-1 bg-blue-600 rounded-full mx-auto md:mx-0"></div>
            <p class="text-xs text-slate-600 leading-relaxed font-medium">
                "{{ $setting->welcome_message ?? 'Selamat datang di website resmi sekolah kami. Kami berkomitmen memberikan ekosistem pembelajaran terbaik yang adaptif, inovatif, serta transparan demi kemajuan seluruh anak didik.' }}"
            </p>
        </div>

    </div>
</div>

<!-- News Grid Section -->
<div id="berita" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
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