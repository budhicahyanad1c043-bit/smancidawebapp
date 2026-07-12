@extends('layouts.app')

@section('title', 'Situs Resmi SMAN 1 Cidahu - Sukabumi')

@section('content')

    <!-- HERO IMAGE SECTION -->
    <section class="relative bg-slate-900 text-white min-h-[460px] flex items-center overflow-hidden">
        <!-- Latar belakang gambar utama (Tempatkan berkas IMG-20251125-WA0009.jpg di folder public/images/) -->
        <div class="absolute inset-0 z-0 bg-cover bg-center opacity-45 transform scale-105" style="background-image: url('{{ asset('images/guru_smancida.jpg') }}');"></div>
        
        <!-- Overlay Gradasi Efek Biru Elegan -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-950 via-blue-900/80 to-transparent z-10"></div>
        
        <!-- Konten Hero -->
        <div class="max-w-7xl mx-auto px-6 relative z-20 py-20">
            <span class="inline-flex items-center py-1 px-3 rounded bg-blue-600/30 border border-blue-400/40 text-xs font-semibold text-blue-300 uppercase tracking-widest mb-4">
                Selamat Datang di Website Resmi
            </span>
            <h2 class="text-3xl md:text-5xl font-extrabold tracking-tight max-w-2xl leading-tight text-white">
                Membangun Insan Cerdas, Kompetitif & Berakhlak Mulia
            </h2>
            <p class="mt-4 text-base md:text-lg text-slate-200 max-w-xl leading-relaxed">
                Bersama SMAN 1 Cidahu, kami berkomitmen memberikan ekosistem pendidikan terbaik demi masa depan gemilang anak bangsa.
            </p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="#profil" class="px-5 py-3 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded shadow transition">
                    Jelajahi Profil Sekolah
                </a>
                <a href="#tentang-kami" class="px-5 py-3 bg-white/10 hover:bg-white/20 text-white text-sm font-semibold rounded border border-white/20 transition backdrop-blur-sm">
                    Hubungi Kontak
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION PROFIL SAMBUTAN -->
    <section id="profil" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="w-12 h-1 bg-blue-600"></div>
                    <h3 class="text-2xl font-bold tracking-tight text-slate-900">Sambutan Kepala Sekolah</h3>
                    <p class="text-slate-600 leading-relaxed text-sm">
                        "Puji dan syukur kita panjatkan ke hadirat Tuhan Yang Maha Esa atas peluncuran portal digital resmi SMAN 1 Cidahu. Kehadiran website ini merupakan langkah nyata transparansi informasi serta jembatan komunikasi interaktif antara sekolah, orang tua, alumni, dan masyarakat luas."
                    </p>
                    <p class="text-slate-600 leading-relaxed text-sm">
                        Kami mengundang Anda sekalian untuk melihat rekam jejak akademis, ragam aktivitas kreativitas siswa, serta berbagai sarana pendukung mutu pembelajaran di sekolah kami.
                    </p>
                </div>
                <div class="bg-slate-50 p-6 rounded-xl border border-slate-100 shadow-inner text-center">
                    <div class="w-24 h-24 bg-slate-300 rounded-full mx-auto mb-4 flex items-center justify-center text-slate-500 text-2xl font-bold">📷</div>
                    <h5 class="font-bold text-slate-800">Nama Kepala Sekolah, M.Pd.</h5>
                    <p class="text-xs text-blue-600 font-semibold uppercase mt-0.5 tracking-wider">Kepala Sekolah SMAN 1 Cidahu</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION AKADEMIS & EKSTRAKURIKULER -->
    <section id="akademis" class="py-20 bg-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h3 class="text-2xl font-bold tracking-tight text-slate-900">Program Utama Sekolah</h3>
                <p class="mt-2 text-slate-500 text-sm">Berbagai pilar keunggulan kurikulum akademis dan pengembangan diri siswa.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Bidang Akademis -->
                <div class="bg-white p-8 rounded-xl border border-slate-200/60 shadow-sm">
                    <div class="text-2xl mb-4 text-blue-600">📖</div>
                    <h4 class="text-lg font-bold text-slate-900 mb-2">Kurikulum & Akademis</h4>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">
                        Penerapan pembelajaran berbasis kompetensi terkini guna mempersiapkan lulusan unggul yang siap bersaing dalam seleksi perguruan tinggi negeri (PTN) maupun vokasi profesional.
                    </p>
                    <ul class="text-xs space-y-2 text-slate-500 font-medium">
                        <li>• Pendalaman Materi UTBK & SNBP</li>
                        <li>• Fasilitas Laboratorium IPA Komplit</li>
                        <li>• Perpustakaan Digital Terintegrasi</li>
                    </ul>
                </div>

                <!-- Bidang Ekstrakurikuler -->
                <div id="ekstrakurikuler" class="bg-white p-8 rounded-xl border border-slate-200/60 shadow-sm">
                    <div class="text-2xl mb-4 text-blue-600">🏆</div>
                    <h4 class="text-lg font-bold text-slate-900 mb-2">Pengembangan Ekstrakurikuler</h4>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">
                        Wadah mengasah soft-skill, kepemimpinan, kerja tim, serta penyaluran minat bakat siswa di bidang olahraga, seni, kepanduan, dan sains teknologi.
                    </p>
                    <ul class="text-xs space-y-2 text-slate-500 font-medium">
                        <li>• Gerakan Pramuka (Gugus Depan Aktif)</li>
                        <li>• Pasukan Pengibar Bendera (Paskibra)</li>
                        <li>• Sanggar Seni Musik & Olahraga Prestasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

@endsection