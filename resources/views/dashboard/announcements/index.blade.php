@extends('dashboard.layouts.admin')

@section('title', 'Kelola Pengumuman')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Manajemen Pengumuman</h2>
            <p class="text-xs text-slate-500">Kelola informasi resmi dan maklumat internal SMAN 1 Cidahu</p>
        </div>
        <a href="{{ route('announcements.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold shadow-sm shadow-blue-500/20 hover:bg-blue-700 transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
            Tambah Pengumuman
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 mb-4 text-xs text-green-800 bg-green-50 border border-green-200 rounded-xl">
           ✨ {{ session('success') }}
        </div>
    @endif
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden w-full max-w-full min-w-0">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-slate-600 text-[11px] font-bold uppercase tracking-wider">
                        <th class="p-4">Judul</th>
                        <th class="p-4">Penulis</th>
                        <th class="p-4">Tingkat</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-slate-700 divide-y divide-slate-100">
                    @forelse($announcements as $announcement)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4 font-semibold text-slate-800 max-w-xs truncate">{{ $announcement->title }}</td>
                            <td class="p-4 text-slate-500">{{ $announcement->user->name }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $announcement->type == 'penting' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-blue-50 text-blue-600 border border-blue-200' }}">
                                    {{ $announcement->type }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $announcement->status == 'active' ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $announcement->status == 'active' ? 'Publish' : 'Draft' }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-400">{{ $announcement->created_at->format('d M Y') }}</td>
                            <td class="p-4 flex items-center justify-center gap-2">
                                <a href="{{ route('announcements.edit', $announcement->id) }}" class="p-2 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition">Edit</a>
                                
                                <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" class="delete-form-announce">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="p-2 btn-delete-announce text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 italic">Belum ada pengumuman yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $announcements->links() }}
    </div>
</div>
@endsection
@push('scripts')
<script>
    // Konfirmasi Hapus Menggunakan SweetAlert2
    document.querySelectorAll('.btn-delete-announce').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form-announce');
            
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