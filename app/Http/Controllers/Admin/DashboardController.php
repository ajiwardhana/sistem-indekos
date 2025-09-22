<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Kos;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $kamars = Kamar::with('kos')->get();
        return view('admin.kamar.index', compact('kamars'));
    }

    public function create()
    {
        $kosList = Kos::all();
        return view('admin.kamar.create', compact('kosList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kos_id' => 'required|exists:kos,id',
            'nomor_kamar' => 'required|string|max:10',
            'ukuran' => 'required|string|max:20',
            'harga_per_bulan' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,terisi',
        ]);

        Kamar::create($validated);

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil ditambahkan');
    }

    public function show(Kamar $kamar)
    {
        return view('admin.kamar.show', compact('kamar'));
    }

    public function edit(Kamar $kamar)
    {
        $kosList = Kos::all();
        return view('admin.kamar.edit', compact('kamar', 'kosList'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $validated = $request->validate([
            'kos_id' => 'required|exists:kos,id',
            'nomor_kamar' => 'required|string|max:10',
            'ukuran' => 'required|string|max:20',
            'harga_per_bulan' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,terisi',
        ]);

        $kamar->update($validated);

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil diperbarui');
    }

    public function destroy(Kamar $kamar)
    {
        $kamar->delete();
        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil dihapus');
    }
}