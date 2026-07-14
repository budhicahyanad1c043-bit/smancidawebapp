@extends('layouts.app')

@section('title', $post->title . ' - SMAN 1 Cidahu')

@section('content')
<article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">
    <!-- Tombol Kembali -->
    <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-700">
        &larr; Kembali ke Beranda
    </a>

    <!-- Judul & Meta Informasi -->
    <div class="space-y-3">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-100">
            {{ $post->category->name ?? 'Tanpa Kategori' }}
        </span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight tracking-tight">{{ $post->title }}</h1>
        <div class="flex items-center space-x-3 text-xs text-slate-400">
            <span class="font-medium text-slate-700">Oleh: {{ $post->user->name }}</span>
            <span>•</span>
            <span>Diterbitkan: {{ $post->created_at->format('d F Y') }}</span>
        </div>
    </div>

    <!-- Gambar Utama -->
    @if($post->image)
    <div class="rounded-xl overflow-hidden border border-slate-200">
        <img src="{{ Storage::url($post->image) }}" class="w-full max-h-[400px] object-cover">
    </div>
    @endif

    <!-- Konten Isi (Renders HTML aman yang diinput dari Trix Editor) -->
    <div class="prose prose-slate max-w-none text-sm text-slate-700 leading-relaxed space-y-4">
        {!! $post->content !!}
    </div>
</article>
@endsection