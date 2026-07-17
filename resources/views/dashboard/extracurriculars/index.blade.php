@extends('dashboard.layouts.admin')
@section('title', 'Kelola Ekskul')
@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Manajemen Ekstrakurikuler</h2>
            <p class="text-[11px] text-slate-500 mt-1">Kelola daftar kegiatan ekstrakurikuler yang aktif di sekolah.</p>
        </div>
        <a href="{{ route('dashboard.extracurriculars.create') }}" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition flex items-center space-x-1.5">
            <span>➕</span>
            <span>Tambah Ekskul</span>
        </a>
    </div>

    <!-- Alert Sukses Flash Message -->
    @if(session('success'))
    <div class="mb-5 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl text-xs font-medium">
        ✨ {{ session('success') }}
    </div>
    @endif

    <!-- Data Table Container -->
    <div class="bg-white border border-slate-200/60 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold uppercase text-slate-500 tracking-wider">
                        <th class="py-3.5 px-4 w-16 text-center">Logo</th>
                        <th class="py-3.5 px-4">Nama Ekskul</th>
                        <th class="py-3.5 px-4 hidden md:table-cell">Foto Kegiatan</th>
                        <th class="py-3.5 px-4 hidden lg:table-cell w-1/3">Deskripsi Singkat</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse($ekskuls as $ekskul)
                    <tr class="hover:bg-slate-50/50 transition">
                        <!-- Logo -->
                        <td class="py-3 px-4 text-center">
                            @if($ekskul->logo)
                                <img src="{{ Storage::url($ekskul->logo) }}" alt="Logo" class="w-10 h-10 object-contain mx-auto rounded-lg border border-slate-150 p-0.5 bg-white">
                            @else
                                <span class="text-xl">🎯</span>
                            @endif
                        </td>
                        <!-- Nama -->
                        <td class="py-3 px-4 font-bold text-slate-800">
                            {{ $ekskul->name }}
                        </td>
                        <!-- Foto Sampul Kegiatan -->
                        <td class="py-3 px-4 hidden md:table-cell">
                            @if($ekskul->image)
                                <img src="{{ Storage::url($ekskul->image) }}" alt="Sampul" class="w-24 h-14 object-cover rounded-lg border border-slate-100">
                            @else
                                <span class="text-[10px] text-slate-400 font-medium italic">Tidak ada foto</span>
                            @endif
                        </td>
                        <!-- Deskripsi Singkat -->
                        <td class="py-3 px-4 hidden lg:table-cell text-slate-500 leading-relaxed">
                            {{ Str::limit($ekskul->description, 90) }}
                        </td>
                        <!-- Tombol Aksi -->
                        <td class="py-3 px-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <!-- Tombol Edit -->
                                <a href="{{ route('dashboard.extracurriculars.edit', $ekskul->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-slate-200 rounded-md transition" title="Edit">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path></svg>
                                </a>
                                <!-- Tombol Hapus Form -->
                                <form action="{{ route('dashboard.extracurriculars.destroy', $ekskul->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="p-1.5 text-rose-600 hover:bg-rose-50 border border-rose-100 rounded-md transition btn-delete" title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400 italic">
                            Belum ada data ekstrakurikuler yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Konfirmasi Hapus Menggunakan SweetAlert2
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ekstrakurikuler ini akan dihapus permanen dari sistem!",
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