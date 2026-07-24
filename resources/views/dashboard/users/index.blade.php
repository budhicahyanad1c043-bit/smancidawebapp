@extends('dashboard.layouts.admin')

@section('title', 'Pengelolaan Pengguna')

@section('content')
<div x-data="{ 
    // State Modal Preview Detail
    showPreviewModal: false, 
    selectedUser: null,
    openPreview(user) {
        this.selectedUser = user;
        this.showPreviewModal = true;
    },

    // State Modal Form (Tambah & Edit)
    showFormModal: false,
    isEdit: false,
    formAction: '{{ route('users.store') }}',
    formData: {
        id: null,
        name: '',
        username: '',
        email: '',
        role: 'web-journalist'
    },

    openCreateModal() {
        this.isEdit = false;
        this.formAction = '{{ route('users.store') }}';
        this.formData = { id: null, name: '', username: '', email: '', role: 'web-journalist' };
        this.showFormModal = true;
    },

    openEditModal(user) {
        this.isEdit = true;
        this.formAction = `/dashboard/users/${user.id}`;
        this.formData = {
            id: user.id,
            name: user.name,
            username: user.username,
            email: user.email,
            role: user.role ?? (user.is_admin ? 'admin' : 'web-journalist')
        };
        this.showFormModal = true;
    }
}" class="space-y-6">

    <!-- HEADER PAGE -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Pengelolaan Pengguna</h1>
            <p class="text-xs text-slate-500 mt-1">Manajemen hak akses admin, jurnalis, dan status keaktifan akun.</p>
        </div>
        
        <!-- BREADCRUMB -->
        <nav class="flex text-xs font-medium text-slate-400 space-x-2">
            <a href="{{ route('dashboard.index') }}" class="hover:text-blue-600 transition">Dashboard</a>
            <span>/</span>
            <span class="text-slate-600">Users</span>
        </nav>
    </div>

    <!-- ALERT SUCCESS / ERROR -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-2xl flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-2xl flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-2xl">
            <p class="font-bold mb-1">Gagal menyimpan data:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- MAIN CARD TABLE -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        
        <!-- TOOLBAR: SEARCH & ADD BUTTON -->
        <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
            
            <!-- SEARCH INPUT -->
            <form method="GET" action="{{ route('users.index') }}" class="relative w-full sm:w-96 group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari nama, username, atau email..." 
                       class="w-full pl-10 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200">
                
                @if(request('search'))
                    <a href="{{ route('users.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </a>
                @endif
            </form>

            <!-- TOMBOL TAMBAH PENGGUNA (MEMBUAT MODAL FORM) -->
            <button @click="openCreateModal()" 
                    type="button"
                    class="inline-flex items-center justify-center space-x-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold text-xs rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/30 active:scale-95 transition-all duration-200 w-full sm:w-auto cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Pengguna</span>
            </button>
        </div>

        <!-- TABEL DATA PENGGUNA -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-x-auto w-full [-webkit-overflow-scrolling:touch]">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 text-center w-12">NO</th>
                        <th class="py-3.5 px-4">PENGGUNA</th>
                        <th class="py-3.5 px-4">USERNAME</th>
                        <th class="py-3.5 px-4">EMAIL</th>
                        <th class="py-3.5 px-4 text-center">HAK AKSES</th>
                        <th class="py-3.5 px-4 text-center">STATUS</th>
                        <th class="py-3.5 px-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-3.5 px-4 text-center font-medium text-slate-400">
                                {{ $users->firstItem() + $index }}
                            </td>

                            <td class="py-3.5 px-4">
                                <div class="flex items-center space-x-3">
                                    @if($user->avatar)
                                        <img src="{{ Storage::url($user->avatar) }}" 
                                             alt="{{ $user->name }}" 
                                             class="w-10 h-10 rounded-xl object-cover border border-slate-200/80 shadow-sm flex-shrink-0">
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 text-white font-bold text-sm flex items-center justify-center shadow-sm flex-shrink-0 uppercase">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-slate-800 hover:text-blue-600 transition">{{ $user->name }}</p>
                                        <p class="text-[10px] text-slate-400">Terdaftar: {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="py-3.5 px-4 font-mono text-slate-500">
                                @ {{ $user->username }}
                            </td>

                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $user->email }}
                            </td>

                            <td class="py-3.5 px-4 text-center">
                                @if($user->role === 'admin' || $user->is_admin)
                                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-purple-100 text-purple-700 border border-purple-200/60">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span>ADMIN</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-100 text-blue-700 border border-blue-200/60">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" /></svg>
                                        <span>JURNALIS</span>
                                    </span>
                                @endif
                            </td>

                            <!-- STATUS (SLIDE TOGGLE SWITCH) -->
                            <td class="py-3.5 px-4 text-center">
                                @if(auth()->id() === $user->id)
                                    <!-- Badge untuk akun sendiri yang sedang login -->
                                    <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span>AKTIF (Anda)</span>
                                    </span>
                                @else
                                    <!-- Slide Toggle Form -->
                                    <form action="{{ route('users.toggle-status', $user->id) }}" method="POST" class="inline-flex items-center justify-center">
                                        @csrf
                                        @method('PATCH')
                                        
                                        <label for="toggle-{{ $user->id }}" class="flex items-center cursor-pointer group">
                                            <!-- Outer Track -->
                                            <div class="relative">
                                                <input id="toggle-{{ $user->id }}" 
                                                    type="checkbox" 
                                                    class="sr-only peer" 
                                                    {{ ($user->is_active ?? true) ? 'checked' : '' }}
                                                    onchange="this.form.submit()">
                                                
                                                <!-- Track Background -->
                                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-emerald-500 group-hover:opacity-90 shadow-inner"></div>
                                            </div>

                                            <!-- Label Status Keterangan -->
                                             <div>
                                                 <span class="ml-2.5 text-[11px] font-bold tracking-wide w-16 text-left transition-colors duration-200 {{ ($user->is_active ?? true) ? 'text-emerald-600' : 'text-slate-400' }}">
                                                     {{ ($user->is_active ?? true) ? 'Aktif' : 'Non-Aktif' }}
                                                 </span>
                                             </div>
                                        </label>
                                    </form>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    
                                    <!-- PREVIEW BUTTON -->
                                    <button @click="openPreview({{ json_encode([
                                                'name' => $user->name,
                                                'username' => $user->username,
                                                'email' => $user->email,
                                                'role' => $user->role ?? ($user->is_admin ? 'Admin' : 'Jurnalis'),
                                                'is_active' => $user->is_active ?? true,
                                                'avatar' => $user->avatar ? Storage::url($user->avatar) : null,
                                                'created_at' => $user->created_at ? $user->created_at->isoFormat('D MMMM YYYY') : '-'
                                            ]) }})" 
                                            class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition cursor-pointer" 
                                            title="Preview Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>

                                    <!-- EDIT BUTTON (MEMBUAT MODAL FORM) -->
                                    <button @click="openEditModal({{ json_encode($user) }})"
                                            type="button" 
                                            class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded transition cursor-pointer" 
                                            title="Edit Pengguna">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>

                                    <!-- DELETE / YOU BADGE -->
                                    @if(auth()->id() === $user->id)
                                        <span class="px-2 py-1 bg-slate-100 text-slate-400 font-semibold text-[10px] rounded-md italic">Anda</span>
                                    @else
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $user->id }}, '{{ $user->username }}')" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded transition cursor-pointer" title="Hapus Pengguna">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z" /></svg>
                                    <p class="font-semibold text-sm">Tidak ada data pengguna ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION FOOTER -->
        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $users->links() }}
            </div>
        @endif

    </div>

    <!-- MODAL 1: PREVIEW DETAIL PENGGUNA -->
    <div x-show="showPreviewModal" 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak>
        
        <div @click.away="showPreviewModal = false" 
             class="bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-sm w-full overflow-hidden transform transition-all">
            
            <div class="h-24 bg-gradient-to-r from-blue-600 to-indigo-600 relative p-4">
                <button @click="showPreviewModal = false" class="absolute top-3 right-3 p-1.5 rounded-full bg-black/20 text-white hover:bg-black/40 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="px-6 pb-6 pt-0 relative -mt-12 text-center">
                <template x-if="selectedUser?.avatar">
                    <img :src="selectedUser.avatar" class="w-24 h-24 rounded-2xl object-cover mx-auto border-4 border-white shadow-md bg-white">
                </template>
                <template x-if="!selectedUser?.avatar">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 text-white font-black text-3xl flex items-center justify-center mx-auto border-4 border-white shadow-md uppercase" x-text="selectedUser?.name ? selectedUser.name.charAt(0) : 'U'">
                    </div>
                </template>

                <h3 class="mt-3 text-lg font-bold text-slate-800" x-text="selectedUser?.name"></h3>
                <p class="text-xs text-slate-400 font-mono" x-text="'@' + selectedUser?.username"></p>

                <div class="mt-2 flex items-center justify-center space-x-2">
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider"
                          :class="selectedUser?.role?.toLowerCase() === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700'"
                          x-text="selectedUser?.role">
                    </span>

                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider"
                          :class="selectedUser?.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500'"
                          x-text="selectedUser?.is_active ? 'Aktif' : 'Non-Aktif'">
                    </span>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 space-y-3 text-left text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium">Email</span>
                        <span class="text-slate-700 font-semibold" x-text="selectedUser?.email"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium">Terdaftar Pada</span>
                        <span class="text-slate-700 font-semibold" x-text="selectedUser?.created_at"></span>
                    </div>
                </div>

                <div class="mt-6">
                    <button @click="showPreviewModal = false" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- MODAL 2: FORM TAMBAH & EDIT PENGGUNA -->
    <div x-show="showFormModal" 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak>
        
        <div @click.away="showFormModal = false" 
             class="bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-md w-full overflow-hidden transform transition-all p-6">
            
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-800" x-text="isEdit ? 'Edit Pengguna' : 'Tambah Pengguna Baru'"></h3>
                    <p class="text-xs text-slate-400 mt-0.5" x-text="isEdit ? 'Ubah data informasi pengguna' : 'Isi formulir untuk menambah akun baru'"></p>
                </div>
                <button @click="showFormModal = false" class="p-1.5 rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <form :action="formAction" method="POST" class="mt-5 space-y-4">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <!-- NAMA -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
                    <input type="text" 
                           name="name" 
                           x-model="formData.name" 
                           required 
                           placeholder="Contoh: Dinan Maisha" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition">
                </div>

                <!-- USERNAME -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Username *</label>
                    <input type="text" 
                           name="username" 
                           x-model="formData.username" 
                           required 
                           placeholder="Contoh: dinan_m" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition">
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email *</label>
                    <input type="email" 
                           name="email" 
                           x-model="formData.email" 
                           required 
                           placeholder="Contoh: dinan@gmail.com" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition">
                </div>

                <!-- ROLE -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Hak Akses *</label>
                    <select name="role" 
                            x-model="formData.role" 
                            required 
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition">
                        <option value="web-journalist">Web Journalist</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Password 
                        <span x-show="isEdit" class="text-[10px] text-slate-400 font-normal lowercase">(kosongkan jika tidak diubah)</span>
                        <span x-show="!isEdit">*</span>
                    </label>
                    <input type="password" 
                           name="password" 
                           :required="!isEdit"
                           placeholder="Minimal 8 karakter" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition">
                </div>

                <!-- BUTTON ACTIONS -->
                <div class="flex items-center justify-end space-x-2 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" 
                            @click="showFormModal = false" 
                            class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-xs rounded-xl transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold text-xs rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg transition cursor-pointer">
                        <span x-text="isEdit ? 'Simpan Perubahan' : 'Tambah Pengguna'"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
<script>
    // 1. POPUP KONFIRMASI HAPUS (DELETE)
    function confirmDelete(id, userName) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Pengguna "${userName}" akan dihapus secara permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Merah Tailwind
            cancelButtonColor: '#64748b',  // Slate Tailwind
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'px-4 py-2 text-xs font-semibold rounded-lg',
                cancelButton: 'px-4 py-2 text-xs font-semibold rounded-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit Form secara otomatis
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
@endsection