// app/Http/Controllers/Admin/PenyewaanController.php
<?php

namespace App\Http\Controllers\Admin;

use App\Models\Penyewa;
use App\Models\Kamar;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PenyewaController extends Controller
{
    public function index()
    {
        $penyewa = Penyewa::with(['user', 'kamar'])->latest()->get();
        return view('admin.penyewa.index', compact('penyewa'));
    }

    public function create()
    {
        $kamars = Kamar::where('status', 'tersedia')->get();
        $users = User::where('role', 'penyewa')->get();
        return view('admin.penyewa.create', compact('kamars', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'kamar_id' => 'required|exists:kamars,id',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after:tanggal_masuk',
        ]);

        // Update status kamar
        $kamar = Kamar::find($validated['kamar_id']);
        $kamar->update(['status' => 'terisi']);

        Penyewa::create($validated);

        return redirect()->route('admin.penyewa.index')->with('success', 'Data penyewa berhasil ditambahkan.');
    }

    public function show($id)
    {
        $penyewa = Penyewa::with(['user', 'kamar'])->findOrFail($id);
        return view('admin.penyewa.show', compact('penyewa'));
    }
}