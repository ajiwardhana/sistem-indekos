<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Daftar admin
    public function index()
    {
        $admins = User::where('role','admin')->get();
        return view('pemilik.admin.index', compact('admins'));
    }

    // Form tambah admin
    public function create()
    {
        return view('pemilik.admin.create');
    }

    // Simpan admin baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('pemilik.admin.index')
                         ->with('success','Admin berhasil ditambahkan');
    }

    // Form edit admin
    public function edit(User $user)
    {
        return view('pemilik.admin.edit', compact('user'));
    }

    // Update admin
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        $user->alamat = $request->alamat;
        if($request->filled('password')){
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('pemilik.admin.index')
                         ->with('success','Admin berhasil diperbarui');
    }

    // Hapus admin
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('pemilik.admin.index')
                         ->with('success','Admin berhasil dihapus');
    }
}
