<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::all();
        return view('admin.kamars.index', compact('kamars'));
    }

    public function create()
    {
        return view('admin.kamars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|unique:kamars',
            'harga'       => 'required|numeric',
            'status'      => 'required|in:tersedia,terisi,perbaikan',
            'fasilitas'   => 'nullable|string',
            'deskripsi'   => 'nullable|string',
        ]);

        Kamar::create($request->all());

        return redirect()->route('admin.kamars.index')
                         ->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kamar = Kamar::with(['penyewa.user'])->findOrFail($id);
        return view('admin.kamars.show', compact('kamar'));
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);
        return view('admin.kamars.edit', compact('kamar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_kamar' => 'required|unique:kamars,nomor_kamar,' . $id,
            'harga'       => 'required|numeric',
            'status'      => 'required|in:tersedia,terisi,perbaikan',
            'fasilitas'   => 'nullable|string',
            'deskripsi'   => 'nullable|string',
        ]);

        $kamar = Kamar::findOrFail($id);
        $kamar->update($request->all());

        return redirect()->route('admin.kamars.index')
                         ->with('success', 'Kamar berhasil diperbarui!');
    }

public function batalkan($id)
{
    $kamar = Kamar::with('penyewa')->findOrFail($id);

    if ($kamar->penyewa) {
        $penyewa = $kamar->penyewa;

        // Update data penyewa
        $penyewa->update([
            'tanggal_keluar' => now()
            // ❌ jangan set kamar_id ke null
        ]);

        // Update status kamar
        $kamar->update([
            'status' => 'tersedia'
        ]);

        return redirect()->route('admin.kamars.show', $id)
            ->with('success', 'Penyewaan kamar berhasil dibatalkan!');
    }

    return redirect()->route('admin.kamars.show', $id)
        ->with('error', 'Kamar ini tidak sedang disewa.');
}


    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();

        return redirect()->route('admin.kamars.index')
                         ->with('success', 'Kamar berhasil dihapus!');
    }
}
