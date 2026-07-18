@extends('layouts.app')
@section('title', 'Lihat Pengumuman')
@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4">
        
        <!-- Tombol Kembali -->
        <a href="{{ route('front.announcements.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-blue-500 hover:text-purple-600 mb-6 transition">
            ← Kembali ke Semua Pengumuman
        </a>

        <!-- Grid Layout: Konten & Sidebar Share -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- KOLOM UTAMA: ISI PENGUMUMAN -->
            <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm">
                
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

                <!-- TAMPILAN IMAGE FLYER (PAMFLET) JIKA ADA -->
                @if($announcement->flyer)
                    <div class="mb-6 p-2 border border-dashed border-slate-200 rounded-2xl bg-slate-50">
                        <img src="{{ asset('storage/' . $announcement->flyer) }}" alt="Flyer Pengumuman" class="w-full h-auto  max-h-[500px] object-contain mx-auto">
                    </div>
                @endif

                <!-- Isi Pengumuman -->
                <div class="text-slate-600 text-xs md:text-sm leading-relaxed space-y-4 whitespace-pre-line mb-6">
                    {!! $announcement->content !!}
                </div>

                <!-- TAMPILAN TAUTAN EKSTERNAL JIKA ADA -->
                @if($announcement->link_url)
                    <div class="pt-5 border-t border-slate-100 flex items-center">
                        <a href="{{ $announcement->link_url }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-50 text-purple-700 hover:bg-purple-100 rounded-xl text-xs font-bold transition shadow-sm border border-purple-100">
                            🔗 Buka Tautan Resmi / Formulir Eksternal
                        </a>
                    </div>
                @endif

            </div>

            <!-- KOLOM SAMPING: SMART COPY & REFERENSI SOSMED -->
            <div class="space-y-4">
                
                <!-- Box Smart Copy -->
                <!-- Bagian Kotak Smart Copy yang Sudah Dibersihkan -->
                <div class="bg-slate-900 text-slate-100 p-5 rounded-2xl shadow-sm relative overflow-hidden">
                    <div class="mb-3">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-purple-400">📋 Bagikan Informasi</h3>
                        <p class="text-[10px] text-slate-400">Salin format rapi ini untuk disebarkan ke grup WhatsApp kelas atau wali murid</p>
                    </div>
                    
                    <!-- Element Input Tersembunyi khusus untuk disalin (Tanpa Spasi Tab/Komentar di dalamnya) -->
                <textarea id="smartCopyText" class="hidden">📢 *PENGUMUMAN RESMI SMAN 1 CIDAHU* 📢

                📌 *Judul:* {{ $announcement->title }}
                📝 *Isi Singkat:* {{ Str::limit(strip_tags($announcement->content), 180) }}

                @if($announcement->link_url)🔗 *Tautan Penting:* {{ $announcement->link_url }}
                @endif
                👉 *Selengkapnya baca di:* {{ route('front.announcements.show', $announcement->slug) }}

                {{ $announcement->related_topics }}</textarea>

                    <!-- Pratinjau Teks Kotak Gelap -->
                    <div class="bg-slate-800/80 p-3 rounded-xl text-[11px] font-mono border border-slate-700 text-slate-300 max-h-36 overflow-y-auto whitespace-pre-line leading-relaxed">
                    📢 *PENGUMUMAN RESMI...*
                    📌 *Judul:* {{ $announcement->title }}
                    @if($announcement->link_url)🔗 *Tautan Penting:* {{ Str::limit($announcement->link_url, 30) }}
                    @endif
                    👉 *Selengkapnya:* {{ Str::limit(url()->current(), 30) }}
                    </div>

                    <!-- Tombol Aksi Copy -->
                    <button onclick="copySmartText()" class="w-full mt-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-xl transition shadow flex items-center justify-center gap-1.5 active:scale-[0.98]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                        <span id="btnCopyText">Salin Teks Broadcast</span>
                    </button>
                </div>

                <!-- Box Sosmed Tagar / Related Topics -->
                @if($announcement->related_topics)
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-2.5">📱 Media Sosial Terkait</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(' ', $announcement->related_topics) as $tag)
                                @if(trim($tag) != '')
                                    @php
                                        // 1. Bersihkan tanda # di awal tagar
                                        $cleanTag = str_replace('#', '', $tag);
                                        $lowerTag = strtolower($cleanTag);
                                        
                                        // 2. Tentukan default URL
                                        $url = "#";
                                        
                                        // 3. Logika Pintar: Cek apakah user menginputkan URL lengkap (mengandung http/https)
                                        if (filter_var($cleanTag, FILTER_VALIDATE_URL)) {
                                            // Jika sudah berupa link valid, langsung pakai link tersebut!
                                            $url = $cleanTag;
                                        }

                                        // 4. Klasifikasi Platform untuk Warna, Icon, dan Fallback Link (jika yang diinput bukan URL)
                                        if (str_contains($lowerTag, 'instagram') || str_contains($lowerTag, 'ig')) {
                                            $platformName = 'Instagram';
                                            $bgColor = 'bg-pink-50 hover:bg-pink-100 text-pink-700 border-pink-200';
                                            $icon = '<svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>';
                                            
                                            // Jika bukan URL lengkap, buat link profile dasar dari teks tersebut
                                            if ($url == "#") {
                                                $url = "https://www.instagram.com/" . ($lowerTag == 'instagram' || $lowerTag == 'ig' ? '' : $cleanTag);
                                            }
                                        } elseif (str_contains($lowerTag, 'youtube') || str_contains($lowerTag, 'yt')) {
                                            $platformName = 'YouTube';
                                            $bgColor = 'bg-red-50 hover:bg-red-100 text-red-700 border-red-200';
                                            $icon = '<svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 00-2.11-2.11C19.518 3.545 12 3.545 12 3.545s-7.518 0-9.388.508a3.003 3.003 0 00-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 002.11 2.11c1.87.508 9.388.508 9.388.508s7.518 0 9.388-.508a3.002 3.002 0 002.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>';
                                            if ($url == "#") $url = "https://www.youtube.com";
                                        } elseif (str_contains($lowerTag, 'facebook') || str_contains($lowerTag, 'fb')) {
                                            $platformName = 'Facebook';
                                            $bgColor = 'bg-blue-50 hover:bg-blue-100 text-blue-700 border-blue-200';
                                            $icon = '<svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>';
                                            if ($url == "#") $url = "https://www.facebook.com";
                                        } elseif (str_contains($lowerTag, 'tiktok')) {
                                            $platformName = 'TikTok';
                                            $bgColor = 'bg-slate-950 hover:bg-slate-900 text-white border-slate-950';
                                            $icon = '<svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.02 1.59 4.23.99 1.25 2.37 2.14 3.92 2.53v3.91c-1.72-.03-3.42-.56-4.85-1.53-.44-.3-.85-.64-1.22-1.02V14c.04 2.87-1.27 5.65-3.55 7.4-2.28 1.81-5.39 2.44-8.19 1.67-2.8-1.78-4.52-5.02-4.49-8.32.06-3.23 1.9-6.26 4.81-7.66 2.05-.98 4.39-1.2 6.58-.61v3.96c-1.46-.49-3.09-.27-4.36.6-.74.52-1.32 1.25-1.66 2.09-.64 1.61-.31 3.51.86 4.77 1.18 1.25 2.99 1.76 4.67 1.3 1.67-.45 2.95-1.84 3.32-3.54.12-.55.16-1.11.15-1.68V.02z"/></svg>';
                                            if ($url == "#") $url = "https://www.tiktok.com";
                                        } else {
                                            // Jika tagar umum/topik teks biasa (Bukan Link Sosmed)
                                            $platformName = $tag;
                                            $bgColor = 'bg-purple-50 hover:bg-purple-100 text-purple-700 border-purple-200';
                                            $icon = '<span class="mr-1 text-purple-400 font-bold">#</span>';
                                            $url = "#";
                                        }
                                    @endphp

                                    <!-- Tombol Link Pintar Bebas Eror Dobel -->
                                    <a href="{{ $url }}" {{ $url != '#' ? 'target="_blank" rel="noopener noreferrer"' : '' }}
                                    class="inline-flex items-center text-xs px-3 py-1.5 rounded-xl font-bold border shadow-sm transition-all duration-200 hover:scale-105 {{ $bgColor }}">
                                        {!! $icon !!}
                                        <span>{{ $platformName }}</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        </div>

    </div>
</div>

<!-- SCRIPT LOGIK COPY TO CLIPBOARD -->
<script>
    function copySmartText() {
        const copyText = document.getElementById("smartCopyText");
        const btnText = document.getElementById("btnCopyText");
        
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* Dukungan browser HP/Mobile */
        navigator.clipboard.writeText(copyText.value);
        
        // Animasi Teks umpan balik sukses
        btnText.innerText = "✓ Berhasil Disalin!";
        setTimeout(() => {
            btnText.innerText = "Salin Teks Broadcast";
        }, 2000);
    }
</script>
@endsection