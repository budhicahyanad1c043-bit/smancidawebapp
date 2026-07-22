@extends('dashboard.layouts.admin') {{-- Sesuaikan dengan nama layout admin Anda --}}
@section('title', 'Manajemen Menu')
@section('content')
<div class="p-6 bg-slate-50 min-h-screen">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Manajemen Menu Dinamis</h1>
            <p class="text-xs text-slate-500">Kelola susunan menu topbar dan sidebar aplikasi</p>
        </div>
        <!-- Tombol Buka Modal Tambah -->
        <button onclick="openAddModal()" class="px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-lg hover:bg-blue-700 transition shadow-sm">
            + Tambah Menu
        </button>
    </div>

    <!-- Tabel Daftar Menu -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="bg-slate-50 border-b border-slate-100 text-slate-700 uppercase font-semibold">
                <tr>
                    <th class="p-3">Urutan</th>
                    <th class="p-3">Nama Menu</th>
                    <th class="p-3">Menu Induk (Parent)</th>
                    <th class="p-3">URL / Route</th>
                    <th class="p-3">Lokasi</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($menus as $menu)
                    <!-- Menu Utama (Induk) -->
                    <tr class="hover:bg-slate-50 font-semibold bg-slate-50/50">
                        <td class="p-3">{{ $menu->order }}</td>
                        <td class="p-3 text-slate-800">{{ $menu->name }}</td>
                        <td class="p-3 text-slate-400"><i>- (Menu Utama) -</i></td>
                        <td class="p-3">{{ $menu->route_name ?? $menu->url }}</td>
                        <td class="p-3"><span class="px-2 py-0.5 rounded text-[10px] bg-blue-100 text-blue-700">{{ strtoupper($menu->location) }}</span></td>
                        <td class="p-3 text-center">
                            @if($menu->is_active)
                                <span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-100 text-emerald-700 font-bold">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] bg-rose-100 text-rose-700 font-bold">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="p-3 text-center space-x-2">
                            <button onclick="openEditModal({{ json_encode($menu) }})" class="text-blue-600 hover:underline">Edit</button>
                            
                            <!-- Form Hapus Menu Induk -->
                            <form id="delete-form-{{ $menu->id }}" action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $menu->id }}, '{{ $menu->name }}')" class="text-rose-600 hover:underline">
                                    Hapus
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
                                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-100 text-emerald-700 font-bold">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-rose-100 text-rose-700 font-bold">Non-Aktif</span>
                                @endif
                            </td>
                            <td class="p-3 text-center space-x-2">
                                <button onclick="openEditModal({{ json_encode($child) }})" class="text-blue-600 hover:underline">Edit</button>
                                
                                <!-- Form Hapus Sub Menu -->
                                <form id="delete-form-{{ $child->id }}" action="{{ route('menus.destroy', $child->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $child->id }}, '{{ $child->name }}')" class="text-rose-600 hover:underline">
                                        Hapus
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
                <select name="parent_id" class="w-full text-xs rounded-lg border-slate-200 focus:ring-blue-500 p-2 focus:border-blue-500">
                    <option value="">-- Tanpa Induk (Menu Utama / Top Level) --</option>
                    @foreach($parentMenus as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
                <p class="text-[10px] text-slate-400 mt-1">Pilih jika menu ini dijadikan sub-menu / dropdown.</p>
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Menu</label>
                <input type="text" name="name" required placeholder="Contoh: Visi & Misi" class="w-full text-xs rounded-lg p-2 border-slate-200">
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">URL (Custom Link)</label>
                <input type="text" name="url" placeholder="Contoh: /visi-misi" class="w-full text-xs rounded-lg p-2 border-slate-200">
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Route (Opsional)</label>
                <input type="text" name="route_name" placeholder="Contoh: front.posts.index" class="w-full text-xs p-2 rounded-lg border-slate-200">
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Tampil</label>
                    <select name="location" class="w-full text-xs rounded-lg p-2 border-slate-200">
                        <option value="topbar">Top Bar</option>
                        <option value="sidebar">Sidebar</option>
                        <option value="both">Keduanya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Urutan</label>
                    <input type="number" name="order" value="0" class="w-full text-xs rounded-lg p-2 border-slate-200">
                </div>
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_active" id="add_is_active" value="1" checked class="rounded border-slate-300 text-blue-600">
                <label for="add_is_active" class="ml-2 text-xs text-slate-700">Aktifkan Menu</label>
            </div>

            <div class="flex justify-end space-x-2 border-t pt-4">
                <button type="button" onclick="closeAddModal()" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold">Batal</button>
                <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700">Simpan</button>
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
                <select name="parent_id" id="edit_parent_id" class="w-full text-xs rounded-lg border-slate-200 p-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Tanpa Induk (Menu Utama / Top Level) --</option>
                    @foreach($parentMenus as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Menu</label>
                <input type="text" name="name" id="edit_name" required class="w-full text-xs rounded-lg p-2 border-slate-200">
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">URL</label>
                <input type="text" name="url" id="edit_url" class="w-full text-xs rounded-lg p-2 border-slate-200">
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Route</label>
                <input type="text" name="route_name" id="edit_route_name" class="w-full text-xs p-2 rounded-lg border-slate-200">
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Tampil</label>
                    <select name="location" id="edit_location" class="w-full text-xs p-2 rounded-lg border-slate-200">
                        <option value="topbar">Top Bar</option>
                        <option value="sidebar">Sidebar</option>
                        <option value="both">Keduanya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Urutan</label>
                    <input type="number" name="order" id="edit_order" class="w-full text-xs rounded-lg p-2 border-slate-200">
                </div>
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_active" id="edit_is_active" value="1" class="rounded border-slate-300 text-blue-600">
                <label for="edit_is_active" class="ml-2 text-xs text-slate-700">Aktifkan Menu</label>
            </div>

            <div class="flex justify-end space-x-2 border-t pt-4">
                <button type="button" onclick="closeEditModal()" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold">Batal</button>
                <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700">Update</button>
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