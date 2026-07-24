@extends('dashboard.layouts.admin') {{-- Sesuaikan dengan nama layout admin Anda --}}
@section('title', 'Manajemen Menu')
@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Manajemen Menu Dinamis</h1>
            <p class="text-xs text-slate-500">Kelola susunan menu topbar dan sidebar aplikasi</p>
        </div>
        <!-- Tombol Buka Modal Tambah -->
        <button onclick="openAddModal()" class="px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-lg hover:bg-blue-700 flex items-center justify-center space-x-1.5 transition shadow-sm cursor-pointer">
           <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Tambah Menu</span>
        </button>
    </div>

    <!-- Tabel Daftar Menu -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-x-auto w-full [-webkit-overflow-scrolling:touch]">
    <table class="w-full min-w-[650px] text-left text-xs text-slate-600">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-700 uppercase font-semibold">
                <tr>
                    <th class="py-3.5 px-4 text-center w-12">Urutan</th>
                    <th class="py-3.5 px-4 text-slate-700">Nama Menu</th>
                    <th class="py-3.5 px-4 text-slate-700">Menu Induk (Parent)</th>
                    <th class="py-3.5 px-4 text-slate-700">URL / Route</th>
                    <th class="py-3.5 px-4 text-slate-700">Lokasi</th>
                    <th class="py-3.5 px-4 text-slate-700 text-center">Status</th>
                    <th class="py-3.5 px-4 text-slate-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                @forelse($menus as $menu)
                    <!-- Menu Utama (Induk) -->
                    <tr class="hover:bg-slate-50 font-semibold bg-slate-50/50">
                        <td class="py-3.5 px-4 text-center font-medium text-slate-400">{{ $menu->order }}</td>
                        <td class="py-3.5 px-4 text-slate-800">{{ $menu->name }}</td>
                        <td class="py-3.5 px-4 text-slate-400"><i>- (Menu Utama) -</i></td>
                        <td class="py-3.5 px-4">{{ $menu->route_name ?? $menu->url }}</td>
                        <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded text-[10px] bg-blue-100 text-blue-700">{{ strtoupper($menu->location) }}</span></td>
                        <td class="p-3 text-center">
                            @if($menu->is_active)
                                <span class="px-2 py-0.5 rounded text-[10px] bg-emerald-100 text-emerald-700 font-bold">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] bg-rose-100 text-rose-700 font-bold">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center space-x-2">
                            <button onclick="openEditModal({{ json_encode($menu) }})" class="text-slate-400 hover:bg-blue-200 p-1.5 rounded hover:text-blue-400 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                </svg>
                            </button>
                            
                            <!-- Form Hapus Menu Induk -->
                            <form id="delete-form-{{ $menu->id }}" action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $menu->id }}, '{{ $menu->name }}')" class="text-slate-400 p-1.5 rounded hover:text-red-400 hover:bg-red-200 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Sub-Menu (Anak) -->
                    @foreach($menu->children as $child)
                        <tr class="hover:bg-slate-50 text-slate-500">
                            <td class="p-3 pl-6">└ {{ $child->order }}</td>
                            <td class="p-3 pl-8 text-slate-700">↳ {{ $child->name }}</td>
                            <td class="p-3 text-blue-600 font-medium">{{ $menu->name }}</td>
                            <td class="p-3">{{ $child->route_name ?? $child->url }}</td>
                            <td class="p-3"><span class="px-2 py-0.5 rounded text-[10px] bg-slate-100 text-slate-600">{{ strtoupper($child->location) }}</span></td>
                            <td class="p-3 text-center">
                                @if($child->is_active)
                                    <span class="px-2 py-0.5 rounded text-[10px] bg-emerald-100 text-emerald-700 font-bold">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] bg-rose-100 text-rose-700 font-bold">Non-Aktif</span>
                                @endif
                            </td>
                            <td class="p-3 text-center space-x-2">
                                <button onclick="openEditModal({{ json_encode($child) }})" class="text-slate-400 hover:bg-blue-200 p-1.5 rounded hover:text-blue-400 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                    </svg>
                                </button>
                                
                                <!-- Form Hapus Sub Menu -->
                                <form id="delete-form-{{ $child->id }}" action="{{ route('menus.destroy', $child->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $child->id }}, '{{ $child->name }}')" class="text-slate-400 p-1.5 rounded hover:text-red-400 hover:bg-red-200 cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-slate-400">Belum ada menu yang dibuat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ================= MODAL TAMBAH MENU ================= -->
<div id="addModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative">
        <h2 class="text-base font-bold text-slate-800 mb-4">Tambah Menu Baru</h2>
        
        <form action="{{ route('menus.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Menu Induk (Parent)</label>
                <select name="parent_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                    <option value="">-- Tanpa Induk (Menu Utama / Top Level) --</option>
                    @foreach($parentMenus as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
                <p class="text-[10px] text-slate-400 mt-1">Pilih jika menu ini dijadikan sub-menu / dropdown.</p>
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Menu</label>
                <input type="text" name="name" required placeholder="Contoh: Visi & Misi" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">URL (Custom Link)</label>
                <input type="text" name="url" placeholder="Contoh: /visi-misi" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Route (Opsional)</label>
                <input type="text" name="route_name" placeholder="Contoh: front.posts.index" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Tampil</label>
                    <select name="location" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                        <option value="topbar">Top Bar</option>
                        <option value="sidebar">Sidebar</option>
                        <option value="both">Keduanya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Urutan</label>
                    <input type="number" name="order" value="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                </div>
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_active" id="add_is_active" value="1" checked class="rounded border-slate-300 text-blue-600">
                <label for="add_is_active" class="ml-2 text-xs text-slate-700">Aktifkan Menu</label>
            </div>

            <div class="flex justify-end space-x-2 border-t border-slate-200 pt-4">
                <button type="button" onclick="closeAddModal()" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-300 transition cursor-pointer">Batal</button>
                
                <!-- Tombol Simpan dengan State Loading -->
                <button type="submit" onclick="showBtnLoading(this)" class="px-4 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 flex items-center space-x-2 cursor-pointer">
                    <span class="btn-text">Simpan</span>
                    <svg class="btn-spinner hidden w-3.5 h-3.5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL EDIT MENU ================= -->
<div id="editModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative">
        <h2 class="text-base font-bold text-slate-800 mb-4">Edit Menu</h2>
        
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Menu Induk (Parent)</label>
                <select name="parent_id" id="edit_parent_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                    <option value="">-- Tanpa Induk (Menu Utama / Top Level) --</option>
                    @foreach($parentMenus as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Menu</label>
                <input type="text" name="name" id="edit_name" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">URL</label>
                <input type="text" name="url" id="edit_url" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Route</label>
                <input type="text" name="route_name" id="edit_route_name" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Tampil</label>
                    <select name="location" id="edit_location" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                        <option value="topbar">Top Bar</option>
                        <option value="sidebar">Sidebar</option>
                        <option value="both">Keduanya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Urutan</label>
                    <input type="number" name="order" id="edit_order" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:border-blue-500 outline-none">
                </div>
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_active" id="edit_is_active" value="1" class="rounded border-slate-300 text-blue-600">
                <label for="edit_is_active" class="ml-2 text-xs text-slate-700">Aktifkan Menu</label>
            </div>

            <div class="flex justify-end space-x-2 border-t border-slate-200 pt-4">
                <button type="button" onclick="closeEditModal()" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold cursor-pointer">Batal</button>
                
                <!-- Tombol Simpan dengan State Loading -->
                <button type="submit" onclick="showBtnLoading(this)" class="px-4 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 flex items-center space-x-2 cursor-pointer">
                    <span class="btn-text">Simpan</span>
                    <svg class="btn-spinner hidden w-3.5 h-3.5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= JAVASCRIPT SWEETALERT ================= -->
<script>
    // Modal Helpers
    function openAddModal() { document.getElementById('addModal').classList.remove('hidden'); }
    function closeAddModal() { document.getElementById('addModal').classList.add('hidden'); }

    function openEditModal(menu) {
        document.getElementById('editForm').action = `/dashboard/menus/${menu.id}`;
        document.getElementById('edit_parent_id').value = menu.parent_id || '';
        document.getElementById('edit_name').value = menu.name;
        document.getElementById('edit_url').value = menu.url || '';
        document.getElementById('edit_route_name').value = menu.route_name || '';
        document.getElementById('edit_location').value = menu.location;
        document.getElementById('edit_order').value = menu.order;
        document.getElementById('edit_is_active').checked = menu.is_active == 1;
        document.getElementById('editModal').classList.remove('hidden');
    }
    function closeEditModal() { document.getElementById('editModal').classList.add('hidden'); }

    // 1. POPUP KONFIRMASI HAPUS (DELETE)
    function confirmDelete(id, menuName) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Menu "${menuName}" akan dihapus secara permanen!`,
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

<!-- 2. POPUP BERHASIL DITAMBAHKAN / DIUPDATE / DIHAPUS (BERDASARKAN SESSION FLASH) -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    popup: 'rounded-xl'
                }
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#ef4444',
                customClass: {
                    popup: 'rounded-xl'
                }
            });
        </script>
    @endif
@endsection