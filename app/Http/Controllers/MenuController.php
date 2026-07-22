<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Mengambil semua menu beserta anak dan induknya untuk tabel
        $menus = Menu::with(['children', 'parent'])
            ->whereNull('parent_id')
            ->orderBy('order', 'asc')
            ->get();

        // Mengambil daftar menu tingkat atas yang bisa dijadikan "Parent/Induk"
        $parentMenus = Menu::whereNull('parent_id')->get();

        return view('dashboard.menus.index', compact('menus', 'parentMenus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'icon' => 'nullable|string',
            'parent_id' => 'nullable|exists:menus,id',
            'location' => 'required|in:sidebar,topbar,both',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Menu::create($validated);

        return redirect()->back()->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'icon' => 'nullable|string',
            'parent_id' => 'nullable|exists:menus,id',
            'location' => 'required|in:sidebar,topbar,both',
            'order' => 'integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $menu->update($validated);

        return redirect()->back()->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }
}
