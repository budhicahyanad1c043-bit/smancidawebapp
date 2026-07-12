@extends('dashboard.layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="space-y-6">
    <!-- Header Halaman -->
    <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Pengguna</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola akun administrator dan jurnalis web SMAN 1 Cidahu</p>
        </div>
        <div class="text-xs text-slate-400 font-medium">
            Dashboard &nbsp;/&nbsp; <span class="text-slate-600 font-semibold">User</span>
        </div>
    </div>

    <!-- Alert Status -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs p-4 rounded-lg flex items-center space-x-2 shadow-sm">
            <span>✅</span>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- AdminLTE Style Card -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Card Header dengan Tombol Aksi -->
        <div class="bg-slate-50 px-5 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <form action="{{ route('users.index') }}" method="GET" class="w-full sm:max-w-xs">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full pl-9 pr-4 py-2 border border-slate-300 rounded-lg text-xs bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                    <span class="absolute left-3 top-2.5 text-slate-400 text-xs">🔍</span>
                </div>
            </form>

            <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-xs transition flex items-center space-x-2 shadow-sm">
                <span>➕</span>
                <span>Tambah Pengguna</span>
            </button>
        </div>

        <!-- Card Body: Tabel Data -->
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
                            <td class="p-3.5 text-center font-medium text-slate-400">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="p-3.5 font-bold text-slate-900">
                                <div class="flex items-center space-x-2.5">
                                    <div class="h-7 w-7 bg-slate-100 text-blue-600 font-black rounded-full flex items-center justify-center text-[10px]">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="p-3.5 font-mono text-slate-500 text-[11px] bg-slate-50/40">@ {{ $user->username }}</td>
                            <td class="p-3.5 text-slate-600">{{ $user->email }}</td>
                            <td class="p-3.5 text-center">
                                @if($user->role === 'admin')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-50 text-purple-600 border border-purple-200 uppercase">
                                        👑 {{ $user->role }}
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-200 uppercase">
                                        ✍️ {{ $user->role }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-3.5 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <button class="p-1 hover:bg-slate-100 border border-slate-200 rounded text-slate-600" title="Ubah">📝</button>
                                    @if($user->id !== auth()->id())
                                        <button class="p-1 hover:bg-red-50 border border-transparent hover:border-red-200 rounded text-red-600" title="Hapus">🗑️</button>
                                    @else
                                        <span class="text-[10px] text-slate-400 italic font-medium">Aktif</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 bg-slate-50/50">
                                <div class="text-xl mb-1">📦</div>
                                Tidak ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card Footer: Pagination -->
        @if($users->hasPages())
            <div class="px-5 py-4 border-t border-slate-200 bg-slate-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection