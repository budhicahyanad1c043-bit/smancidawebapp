<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->paginate(10);
        return view('dashboard.users.index', compact('users'));
    }

    public function store(Request $request)
    {
    // 1. Simpan hasil validasi ke dalam variabel
    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username', // Tanpa spasi setelah koma
        'email'    => 'required|string|email|max:255|unique:users,email',    // Tanpa spasi setelah koma
        'password' => 'required|string|min:8',
        'role'     => 'required|in:admin,web-journalist',
    ]);

        // 2. Timpa password yang belum di-hash dengan yang sudah di-hash
        $validated['password'] = Hash::make($validated['password']);

        // 3. Masukkan langsung semua data yang sudah valid
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role'     => 'required|in:admin,web-journalist',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        // $user->name = $validate['name'];
        // $user->username = $validate['username'];
        // $user->email = $validate['email'];
        // $user->role = $validate['role'];

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Anda tidak bisa menghapus akun Anda sendiri yang sedang aktif!']);
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus dari sistem.');
    }

    public function toggleStatus(User $user)
    {
        // Mencegah admin menonaktifkan akunnya sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'Status pengguna berhasil diperbarui.');
    }

    
}