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
    <!-- Container Tombol Share -->
    <div class="flex flex-wrap items-center gap-3 py-4 my-6 border-y border-slate-100">
        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mr-2">Bagikan Berita:</span>

        <!-- 1. WhatsApp -->
        <a href="https://api.whatsapp.com/send?text={{ rawurlencode($post->title . ' - ' . request()->url()) }}" 
        target="_blank" 
        class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold px-3 py-2 rounded-lg transition shadow-sm">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.516 2.266 2.27 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.713-1.457L0 24zm6.59-4.846c1.66.986 3.298 1.506 4.966 1.507 5.489 0 9.954-4.41 9.957-9.829.002-2.624-1.017-5.093-2.871-6.951-1.854-1.857-4.32-2.879-6.945-2.88-5.49 0-9.953 4.411-9.956 9.83-.001 1.93.504 3.812 1.464 5.483L2.14 21.36l4.507-1.182z"/></svg>
            WhatsApp
        </a>

        <!-- 2. Facebook -->
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode(request()->url()) }}" 
        target="_blank" 
        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-3 py-2 rounded-lg transition shadow-sm">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            Facebook
        </a>

        <!-- 3. X (Twitter) -->
        <a href="https://twitter.com/intent/tweet?url={{ rawurlencode(request()->url()) }}&text={{ rawurlencode($post->title) }}" 
        target="_blank" 
        class="inline-flex items-center gap-2 bg-slate-900 hover:bg-black text-white text-xs font-bold px-3 py-2 rounded-lg transition shadow-sm">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            X / Twitter
        </a>

        <!-- 4. Instagram (Membuka Direct Message Instagram) -->
        <a href="https://www.instagram.com/direct/inbox/" 
        target="_blank" 
        class="inline-flex items-center gap-2 bg-gradient-to-tr from-yellow-500 via-red-500 to-purple-600 hover:opacity-90 text-white text-xs font-bold px-3 py-2 rounded-lg transition shadow-sm">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
            Instagram
        </a>

        <!-- 5. Tombol Pintar: Salin Link (Alternatif Terbaik untuk Instagram Story) -->
        <button onclick="copyToClipboard()" 
                class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-3 py-2 rounded-lg transition shadow-sm border border-slate-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
            Salin Tautan
        </button>
    </div>
    <!-- DOKUMENTASI MEDIA SOSIAL TERKAIT (Hanya muncul jika diisi) -->
    @if($post->instagram_link || $post->youtube_link)
        <div class="mt-8 pt-6 border-t border-slate-200">
            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3.5 flex items-center gap-2">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
                Dokumentasi Terkait Postingan
            </h4>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                
                <!-- Link Instagram -->
                @if($post->instagram_link)
                    <a href="{{ $post->instagram_link }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-gradient-to-r from-purple-50 to-pink-50/50 border border-purple-100 hover:border-purple-300 transition shadow-sm group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-yellow-500 via-red-500 to-purple-600 flex items-center justify-center text-white flex-shrink-0 shadow-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-purple-950 uppercase tracking-wide">Lihat di Instagram</p>
                                <p class="text-[10px] text-purple-700/80 truncate">Buka postingan terkait →</p>
                            </div>
                        </div>
                    </a>
                @endif

                <!-- Link YouTube -->
                @if($post->youtube_link)
                    <a href="{{ $post->youtube_link }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl bg-gradient-to-r from-red-50 to-orange-50/50 border border-red-100 hover:border-red-300 transition shadow-sm group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-red-600 flex items-center justify-center text-white flex-shrink-0 shadow-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 0 0-2.11-2.11C19.518 3.545 12 3.545 12 3.545s-7.518 0-9.388.508a3.003 3.003 0 0 0-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 0 0 2.11 2.11c1.87.508 9.388.508 9.388.508s7.518 0 9.388-.508a3.003 3.003 0 0 0 2.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-red-950 uppercase tracking-wide">Tonton di YouTube</p>
                                <p class="text-[10px] text-red-700/80 truncate">Buka video terkait →</p>
                            </div>
                        </div>
                    </a>
                @endif

            </div>
        </div>
    @endif
    <!-- ================= SEKSI TOPIC TERKAIT & SOSIAL MEDIA ================= -->
    <div class="mt-12 pt-8 border-t border-slate-100">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- KOLOM KIRI & TENGAH: BERITA TERKAIT (Mengambil 2 Kolom) -->
            <div class="lg:col-span-2 space-y-4">
                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-1 h-4 bg-blue-600 rounded-full"></span>
                    Artikel Terkait
                </h3>

                <!-- Grid Card Berita Terkait -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Pastikan di Controller Anda sudah mengirimkan data $relatedPosts --}}
                    @forelse($relatedPosts as $related)
                        <div class="group bg-white border border-slate-200/60 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition duration-200">
                            <div class="aspect-video w-full overflow-hidden bg-slate-100 relative">
                                <img src="{{ $related->image ? Storage::url($related->image) : 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?q=80&w=500' }}" 
                                    alt="{{ $related->title }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                <span class="absolute top-2 left-2 bg-blue-600 text-[9px] font-bold text-white uppercase px-2 py-0.5 rounded">
                                    {{ $related->category->name }}
                                </span>
                            </div>
                            <div class="p-4 space-y-2">
                                <span class="text-[10px] text-slate-400 block font-medium">
                                    📅 {{ $related->created_at->translatedFormat('d F Y') }}
                                </span>
                                <a href="{{ url('/news/'.$related->id) }}" class="block text-xs font-bold text-slate-800 hover:text-blue-600 transition line-clamp-2 leading-relaxed">
                                    {{ $related->title }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-[11px] text-slate-400 italic">Belum ada artikel terkait untuk kategori ini.</p>
                    @endforelse
                </div>
            </div>

            <!-- KOLOM KANAN: AJAKAN IKUTI SOSIAL MEDIA SEKOLAH -->
            <div class="space-y-5">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 flex items-center gap-2.5">
                    <span class="w-1.5 h-5 bg-purple-600 rounded-full"></span>
                    Media Sosial Sekolah
                </h3>

                <!-- Card Mading Medsos -->
                <div class="bg-gradient-to-b from-slate-50 to-white border border-slate-200/70 rounded-2xl p-5 space-y-5 shadow-sm overflow-hidden">
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Dapatkan informasi kegiatan, prestasi, dan pengumuman resmi akademik secara <span class="italic font-medium text-slate-700">real-time</span> melalui kanal media sosial resmi <span class="font-bold text-slate-800">SMAN 1 Cidahu</span>:
                    </p>

                    <!-- Container List Menggunakan Grid Tunggal -->
                    <div class="grid grid-cols-1 gap-3">
                        
                        <!-- 1. Instagram Sekolah -->
                        <a href="{{ $setting->instagram_url }}" target="_blank" class="flex items-center gap-4.5 p-3 rounded-xl bg-white border border-slate-200/60 hover:border-purple-300 hover:bg-purple-50/20 shadow-sm transition-all duration-200 group w-full">
                            <div class="w-9 h-9 rounded-lg bg-gradient-to-tr from-yellow-500 via-red-500 to-purple-600 flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[12px] font-bold text-slate-700 tracking-wide truncate">@sman1cidahu</p>
                                <p class="text-[10px] text-purple-600 font-semibold mt-0.5 group-hover:underline">Kunjungi Instagram →</p>
                            </div>
                        </a>

                        <!-- 2. Facebook Sekolah (BARU) -->
                        <a href="{{ $setting->facebook_url }}" target="_blank" class="flex items-center gap-4.5 p-3 rounded-xl bg-white border border-slate-200/60 hover:border-blue-300 hover:bg-blue-50/20 shadow-sm transition-all duration-200 group w-full">
                            <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[12px] font-bold text-slate-700 tracking-wide truncate">SMAN 1 Cidahu</p>
                                <p class="text-[10px] text-blue-600 font-semibold mt-0.5 group-hover:underline">Sukai Halaman →</p>
                            </div>
                        </a>

                        <!-- 4. YouTube Sekolah -->
                        <a href="{{ $setting->youtube_url }}" target="_blank" class="flex items-center gap-4.5 p-3 rounded-xl bg-white border border-slate-200/60 hover:border-red-300 hover:bg-red-50/20 shadow-sm transition-all duration-200 group w-full">
                            <div class="w-9 h-9 rounded-lg bg-red-600 flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 0 0-2.11-2.11C19.518 3.545 12 3.545 12 3.545s-7.518 0-9.388.508a3.003 3.003 0 0 0-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 0 0 2.11 2.11c1.87.508 9.388.508 9.388.508s7.518 0 9.388-.508a3.003 3.003 0 0 0 2.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[12px] font-bold text-slate-700 tracking-wide truncate">SMAN 1 Cidahu Official</p>
                                <p class="text-[10px] text-red-600 font-semibold mt-0.5 group-hover:underline">Subscribe Channel →</p>
                            </div>
                        </a>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Script Tambahan Untuk Fungsi Salin Tautan (Letakkan di bawah/push scripts) -->
    <script>
        function copyToClipboard() {
            const currentUrl = window.location.href;
            
            // Membuat elemen temporary untuk menyalin teks
            const tempInput = document.createElement("input");
            tempInput.value = currentUrl;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);

            // Notifikasi SweetAlert2 yang selaras dengan proyek Anda
            Swal.fire({
                icon: 'success',
                title: 'Tautan Berhasil Disalin!',
                text: 'Silakan tempel (paste) link ini di Story atau Bio Instagram Sekolah.',
                showConfirmButton: false,
                timer: 2500,
                toast: true,
                position: 'top-end'
            });
        }
    </script>
</article>
@endsection