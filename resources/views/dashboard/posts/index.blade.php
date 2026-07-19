@extends('dashboard.layouts.admin')

@section('title', 'Kelola Berita & Artikel')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Artikel & Berita</h1>
            <p class="text-xs text-slate-500">Kelola konten berita yang akan tampil di website publik sekolah.</p>
        </div>
        <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold shadow-sm shadow-blue-500/20 hover:bg-blue-700 transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
            Tulis Artikel
        </a>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-xs font-semibold">
        {{ session('success') }}
    </div>
    @endif

    <!-- Card Tabel Responsif -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden w-full max-w-full min-w-0">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-3.5 w-20">Gambar</th>
                        <th class="px-6 py-3.5">Judul Artikel</th>
                        <th class="px-6 py-3.5">Penulis</th>
                        <th class="px-6 py-3.5 w-28">Status</th>
                        <th class="px-6 py-3.5 w-36 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700 font-medium">
                    @forelse($posts as $post)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4">
                            @if($post->image)
                                <img src="{{ Storage::url($post->image) }}" class="w-12 h-12 object-cover rounded-md border border-slate-200">
                            @else
                                <div class="w-12 h-12 bg-slate-100 border border-slate-200 rounded-md flex items-center justify-center text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375 0 11-.75 0 .375 0 01.75 0z"></path></svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-800 block text-sm mb-0.5 truncate max-w-xs">{{ $post->title }}</span>
                            <span class="text-[10px] text-slate-400">{{ $post->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $post->user->name }}</td>
                        <td class="px-6 py-4">
                            @if($post->status === 'published')
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">PUBLISHED</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">DRAFT</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('posts.edit', $post->id) }}" class="p-1.5 bg-slate-50 border border-slate-200 rounded-md hover:bg-slate-100 text-slate-600 transition" title="Edit">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path></svg>
                                </a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="delete-form-post">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" class="p-1.5 bg-rose-50 border border-rose-100 rounded-md btn-delete-post hover:bg-rose-100 text-rose-600 transition" title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-400 font-medium">Belum ada artikel berita yang dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Konfirmasi Hapus Menggunakan SweetAlert2
    document.querySelectorAll('.btn-delete-post').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form-post');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data post ini akan dihapus permanen dari sistem!",
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