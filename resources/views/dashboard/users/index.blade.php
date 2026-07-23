@extends('dashboard.layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<div x-data="{ 
    openAdd: false, 
    openEdit: false, 
    openDelete: false,
    editData: { id: '', name: '', username: '', email: '', role: '' },
    deleteUrl: ''
    }" class="space-y-6 w-full max-w-full min-w-0">

    <!-- Header Halaman -->
    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-black text-slate-800 tracking-tight">Pengelolaan Pengguna</h1>
            <p class="text-xs text-slate-500">Manajemen hak akses admin dan jurnalis sistem informasi sekolah.</p>
        </div>
        <div class="text-xs text-right text-slate-400 font-medium">
            Dashboard &nbsp;/&nbsp; <span class="text-slate-600 font-semibold">Users</span>
        </div>
    </div>
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs p-4 rounded-lg flex items-center space-x-2 shadow-sm">
            <span>✅</span>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Card Tabel Utama -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden w-full max-w-full min-w-0">
        <!-- Topbar Tabel: Pencarian & Tombol Tambah -->
        <div class="bg-slate-50 px-5 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <form action="{{ route('users.index') }}" method="GET" class="w-full sm:max-w-xs">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, username, atau email..." 
                        class="w-full pl-9 pr-4 py-2 border border-slate-300 rounded-lg text-xs bg-white focus:border-blue-500 outline-none transition">
                    <span class="absolute left-3 top-2.5 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                </div>
            </form>

            <button @click="openAdd = true" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-lg text-xs transition flex items-center space-x-1.5 shadow-sm shadow-blue-500/10 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Pengguna</span>
            </button>
        </div>
        <div class="w-full overflow-x-auto block clear-both">        
    
            <table class="min-w-[850px] w-full text-left text-xs text-slate-600 table-fixed sm:table-auto">
                <thead class="bg-slate-50 text-[10px] font-bold uppercase tracking-wider text-slate-700 border-b border-slate-200">
                    <tr class="">
                        <th class="p-4 pl-5 w-16 text-center">No</th>
                        <th class="p-4">Nama Lengkap</th>
                        <th class="p-4">Username</th>
                        <th class="p-4">Email</th>
                        <th class="p-4 text-center w-36">Hak Akses</th>
                        <th class="p-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-4 text-center font-medium text-slate-400">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="p-4 font-bold text-slate-900">
                                {{ $user->name }}
                            </td>
                            <td class="p-4 font-mono text-slate-500 text-[11px]">
                                @<span class="underline decoration-slate-200">{{ $user->username }}</span>
                            </td>
                            <td class="p-4 text-slate-600">
                                {{ $user->email }}
                            </td>
                            <td class="p-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold border {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-600 border-purple-200' : 'bg-blue-50 text-blue-600 border-blue-200' }} uppercase tracking-wide">
                                    @if($user->role === 'admin')
                                        <svg class="w-3 h-3 mr-1 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                        Admin
                                    @else
                                        <svg class="w-3 h-3 mr-1 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                        Jurnalis
                                    @endif
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <!-- Tombol Edit -->
                                    <button @click="
                                                editData = { id: '{{ $user->id }}', name: '{{ $user->name }}', username: '{{ $user->username }}', email: '{{ $user->email }}', role: '{{ $user->role }}' };
                                                openEdit = true;
                                            " 
                                            class="p-1.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-md text-slate-600 transition cursor-pointer" title="Ubah User">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.5 2.5 0 113.536 3.536L12 14.586l-4 1 1-4 9.414-9.414z"></path>
                                        </svg>
                                    </button>
                                    
                                    @if($user->id !== auth()->id())
                                        <!-- Tombol Hapus -->
                                        <button @click="
                                                    deleteUrl = '{{ route('users.index') }}' + '/' + '{{ $user->id }}';
                                                    openDelete = true;
                                                " 
                                                class="p-1.5 bg-white hover:bg-red-50 border border-slate-200 hover:border-red-200 rounded-md text-red-600 transition cursor-pointer" title="Hapus User">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    @else
                                        <span class="text-[10px] text-slate-400 italic font-medium px-2 py-1 bg-slate-100 rounded-md select-none">Anda</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400 bg-slate-50/30">
                                <svg class="w-8 h-8 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path>
                                </svg>
                                <span class="text-xs">Tidak ditemukan data pengguna yang cocok.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
    
            <!-- Pagination Panel -->
            @if($users->hasPages())
                <div class="px-5 py-4 border-t border-slate-200 bg-slate-50/50">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>


    <!-- ==================== MODAL PLACEHOLDERS (ALPINE.JS) ==================== -->
    
    <!-- 1. Modal Tambah User -->
    <div x-show="openAdd" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/40" x-cloak>
        <div @click.away="openAdd = false" class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 border border-slate-200">
            <h3 class="text-sm font-black text-slate-800 mb-4">Tambah Pengguna Baru</h3>
            <form action="{{ route('users.store') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Username</label>
                    <input type="text" name="username" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Hak Akses / Role</label>
                    <select name="role" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none bg-white">
                        <option value="web-journalist">Jurnalis</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2 pt-3 border-t border-slate-200 mt-4">
                    <button type="button" @click="openAdd = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition cursor-pointer">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. Modal Edit User -->
    <div x-show="openEdit" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/40" x-cloak>
        <div @click.away="openEdit = false" class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 border border-slate-200">
            <h3 class="text-sm font-black text-slate-800 mb-4">Ubah Data Pengguna</h3>
            <form :action="'{{ route('users.index') }}' + '/' + editData.id" method="POST" class="space-y-3">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" x-model="editData.name" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Username</label>
                    <input type="text" name="username" x-model="editData.username" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Email</label>
                    <input type="email" name="email" x-model="editData.email" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Password Baru <span class="text-[10px] text-slate-400 lowercase italic">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Hak Akses / Role</label>
                    <select name="role" x-model="editData.role" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none bg-white">
                        <option value="web-journalist">Jurnalis</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2 pt-3 border-t border-slate-100 mt-4">
                    <button type="button" @click="openEdit = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition cursor-pointer">Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. Modal Konfirmasi Hapus -->
    <div x-show="openDelete" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/40" x-cloak>
        <div @click.away="openDelete = false" class="bg-white rounded-xl shadow-xl max-w-sm w-full p-6 border border-slate-200 text-center">
            <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-xs font-black text-slate-800 mb-1">Konfirmasi Hapus Data</h3>
            <p class="text-[11px] text-slate-500 mb-4">Apakah Anda yakin ingin menghapus akun ini? Tindakan ini permanen dan tidak dapat dibatalkan.</p>
            <form :action="deleteUrl" method="POST" class="flex justify-center space-x-2">
                @csrf
                @method('DELETE')
                <button type="button" @click="openDelete = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">Batal</button>
                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition">Ya, Hapus Akun</button>
            </form>
        </div>
    </div>

</div>
@endsection