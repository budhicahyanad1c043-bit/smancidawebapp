@extends('dashboard.layouts.admin')

@section('title', 'Galleries')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Galeri Foto Kegiatan</h2>
            <p class="text-xs text-slate-500">Kelola dokumentasi visual seluruh kegiatan resmi SMAN 1 Cidahu</p>
        </div>
        <a href="{{ route('galleries.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold shadow-sm shadow-blue-500/20 hover:bg-blue-700 transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>Unggah Foto
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 mb-4 text-xs text-green-800 bg-green-50 border border-green-200 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Grid Layout Kartu Galeri -->
    <div class="sm:grid sm:grid-cols-2 md:grid-cols-4 gap-4">
        @forelse($galleries as $gallery)
            <div class="border border-slate-100 rounded-xl overflow-hidden shadow-sm bg-slate-50/50 group flex flex-col justify-between">
                <div class="relative aspect-video overflow-hidden bg-slate-200">
                    <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>
                <div class="p-3">
                    <h4 class="text-xs font-bold text-slate-800 line-clamp-1 mb-1">{{ $gallery->title }}</h4>
                    <p class="text-[11px] text-slate-400 line-clamp-2">{{ $gallery->description ?? 'Tidak ada keterangan.' }}</p>
                    
                    <!-- Tombol Aksi -->
                    <div class="flex items-center gap-3 mt-3 pt-2 border-t border-slate-100">
                        <a href="{{ route('galleries.edit', $gallery->id) }}" class="text-[10px] border font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded hover:bg-amber-100 transition">Edit</a>
                        <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST" class="flex  items-center delete-form-image">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="text-[10px] btn-delete-image border font-bold text-red-600 bg-red-50 px-2 py-1 rounded hover:bg-red-100 transition">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 p-8 text-center text-slate-400 italic text-xs">Belum ada foto dokumentasi kegiatan.</div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $galleries->links() }}
    </div>
</div>
@endsection
@push('scripts')
<script>
    // Konfirmasi Hapus Menggunakan SweetAlert2
    document.querySelectorAll('.btn-delete-image').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form-image');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data Pengumuman ini akan dihapus permanen dari sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg text-xs px-4 py-2 font-bold',
                    cancelButton: 'rounded-lg text-xs px-4 py-2 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush