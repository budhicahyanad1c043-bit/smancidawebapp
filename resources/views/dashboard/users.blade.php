@extends('dashboard.layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<!-- Container Utama x-data untuk mengontrol semua modal -->
<div class="space-y-6" x-data="{ 
    openAdd: false, 
    openEdit: false, 
    openDelete: false,
    editData: { id: '', name: '', username: '', email: '', role: '' },
    deleteUrl: ''
}">
    <!-- Header Halaman -->
    <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Pengguna</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola hak akses administrator dan jurnalis SMAN 1 Cidahu</p>
        </div>
        <div class="text-xs text-slate-400 font-medium">
            Dashboard &nbsp;/&nbsp; <span class="text-slate-600 font-semibold">User</span>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs p-4 rounded-lg flex items-center space-x-2 shadow-sm">
            <span>✅</span> <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-xs p-4 rounded-lg mb-4 space-y-1 shadow-sm">
            @foreach ($errors->all() as $error) <p>⚠️ {{ $error }}</p> @endforeach
        </div>
    @endif

    <!-- AdminLTE Card -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-slate-50 px-5 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <form action="{{ route('users.index') }}" method="GET" class="w-full sm:max-w-xs">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full pl-9 pr-4 py-2 border border-slate-300 rounded-lg text-xs bg-white focus:border-blue-500 outline-none transition">
                    <span class="absolute left-3 top-2.5 text-slate-400 text-xs">🔍</span>
                </div>
            </form>

            <button @click="openAdd = true" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-xs transition flex items-center space-x-2 shadow-sm">
                <span>➕</span> <span>Tambah Pengguna</span>
            </button>
        </div>

        <!-- Tabel Utama -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-200 font-bold text-slate-600 uppercase tracking-wider">
                        <th class="p-3.5 pl-5 w-12 text-center">No</th>
                        <th class="p-3.5">Nama Lengkap</th>
                        <th class="p-3.5">Username</th>
                        <th class="p-3.5">Email</th>
                        <th class="p-3.5 text-center w-36">Hak Akses</th>
                        <th class="p-3.5 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-3.5 text-center font-medium text-slate-400">{{ $users->firstItem() + $index }}</td>
                            <td class="p-3.5 font-bold text-slate-900">{{ $user->name }}</td>
                            <td class="p-3.5 font-mono text-slate-500 text-[11px]">@ {{ $user->username }}</td>
                            <td class="p-3.5 text-slate-600">{{ $user->email }}</td>
                            <td class="p-3.5 text-center">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold border {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-600 border-purple-200' : 'bg-blue-50 text-blue-600 border-blue-200' }} uppercase">
                                    {{ $user->role === 'admin' ? '👑 Admin' : '✍️ Jurnalis' }}
                                </span>
                            </td>
                            <td class="p-3.5 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <!-- Tombol Pemicu Edit Modal + Mengisi Data -->
                                    <button @click="
                                        editData = { id: '{{ $user->id }}', name: '{{ $user->name }}', username: '{{ $user->username }}', email: '{{ $user->email }}', role: '{{ $user->role }}' };
                                        openEdit = true;
                                    " class="p-1 hover:bg-slate-100 border border-slate-200 rounded text-slate-600" title="Ubah">📝</button>
                                    
                                    @if($user->id !== auth()->id())
                                        <!-- Tombol Pemicu Delete Modal -->
                                        <button @click="
                                            deleteUrl = '{{ route('users.destroy', $user->id) }}';
                                            openDelete = true;
                                        " class="p-1 hover:bg-red-50 border border-transparent hover:border-red-200 rounded text-red-600" title="Hapus">🗑️</button>
                                    @else
                                        <span class="text-[10px] text-slate-400 italic">Aktif</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 bg-slate-50/50">Tidak ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-slate-200 bg-slate-50/50">{{ $users->links() }}</div>
    </div>

    <!-- ================= MODAL: TAMBAH USER ================= -->
    <div x-show="openAdd" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40" x-cloak>
        <div @click.away="openAdd = false" class="bg-white rounded-lg border border-slate-200 shadow-xl max-w-md w-full overflow-hidden">
            <div class="bg-slate-50 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                <h3 class="font-bold text-slate-700 text-sm">➕ Tambah Pengguna Baru</h3>
                <button @click="openAdd = false" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
            </div>
            <form action="{{ route('users.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-3 py-1.5 border border-slate-300 rounded text-xs outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Username</label>
                    <input type="text" name="username" required class="w-full px-3 py-1.5 border border-slate-300 rounded text-xs outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-3 py-1.5 border border-slate-300 rounded text-xs outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full px-3 py-1.5 border border-slate-300 rounded text-xs outline-none focus:border-blue-500" placeholder="Minimal 8 karakter">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Hak Akses Role</label>
                    <select name="role" required class="w-full px-3 py-1.5 border border-slate-300 rounded text-xs outline-none focus:border-blue-500 bg-white">
                        <option value="web-journalist">Jurnalis Web</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <div class="pt-2 flex justify-end space-x-2 border-t border-slate-100">
                    <button type="button" @click="openAdd = false" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded text-xs font-semibold">Batal</button>
                    <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= MODAL: EDIT USER ================= -->
    <div x-show="openEdit" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40" x-cloak>
        <div @click.away="openEdit = false" class="bg-white rounded-lg border border-slate-200 shadow-xl max-w-md w-full overflow-hidden">
            <div class="bg-slate-50 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                <h3 class="font-bold text-slate-700 text-sm">📝 Ubah Data Pengguna</h3>
                <button @click="openEdit = false" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
            </div>
            <form :action="'{{ route('users.index') }}' + '/' + editData.id" method="POST" class="p-5 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" x-model="editData.name" required class="w-full px-3 py-1.5 border border-slate-300 rounded text-xs outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Username</label>
                    <input type="text" name="username" x-model="editData.username" required class="w-full px-3 py-1.5 border border-slate-300 rounded text-xs outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Email</label>
                    <input type="email" name="email" x-model="editData.email" required class="w-full px-3 py-1.5 border border-slate-300 rounded text-xs outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Kata Sandi Baru <span class="text-slate-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="w-full px-3 py-1.5 border border-slate-300 rounded text-xs outline-none focus:border-blue-500" placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Hak Akses Role</label>
                    <select name="role" x-model="editData.role" required class="w-full px-3 py-1.5 border border-slate-300 rounded text-xs outline-none focus:border-blue-500 bg-white">
                        <option value="web-journalist">Jurnalis Web</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <div class="pt-2 flex justify-end space-x-2 border-t border-slate-100">
                    <button type="button" @click="openEdit = false" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded text-xs font-semibold">Batal</button>
                    <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= MODAL: KONFIRMASI DELETE ================= -->
    <div x-show="openDelete" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40" x-cloak>
        <div @click.away="openDelete = false" class="bg-white rounded-lg border border-slate-200 shadow-xl max-w-sm w-full overflow-hidden">
            <div class="bg-red-50 px-5 py-3 border-b border-red-100 flex items-center justify-between">
                <h3 class="font-bold text-red-700 text-sm">🗑️ Konfirmasi Hapus Data</h3>
                <button @click="openDelete = false" class="text-red-400 hover:text-red-600 text-sm">✕</button>
            </div>
            <div class="p-5">
                <p class="text-xs text-slate-600 leading-relaxed">Apakah Anda yakin ingin menghapus akun pengguna ini secara permanen? Tindakan ini tidak dapat dibatalkan.</p>
                <form :action="deleteUrl" method="POST" class="mt-4 flex justify-end space-x-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="openDelete = false" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded text-xs font-semibold">Batal</button>
                    <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-semibold">Ya, Hapus Akun</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection