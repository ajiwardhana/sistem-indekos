<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamar = Kamar::latest()->paginate(10);
        return view('admin.kamar.index', compact('kamar'));
    }

    public function create()
    {
        return view('admin.kamar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_kamar' => 'required|unique:kamar|max:10',
            'harga' => 'required|numeric',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:tersedia,terisi,perbaikan',
        ]);

        Kamar::create($validated);

        return redirect()->route('kamar.index')
            ->with('success', 'Kamar berhasil ditambahkan');
    }

    public function edit(Kamar $kamar)
    {
        return view('admin.kamar.edit', compact('kamar'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $validated = $request->validate([
            'nomor_kamar' => 'required|max:10|unique:kamar,nomor_kamar,'.$kamar->id,
            'harga' => 'required|numeric',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:tersedia,terisi,perbaikan',
        ]);

        $kamar->update($validated);

        return redirect()->route('kamar.index')
            ->with('success', 'Data kamar berhasil diperbarui');
    }

    public function destroy(Kamar $kamar)
    {
        $kamar->delete();

        return redirect()->route('kamar.index')
            ->with('success', 'Kamar berhasil dihapus');
    }
}