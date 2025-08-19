<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KamarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kamar = Kamar::orderBy('nomor_kamar')->get();
        return view('admin.kamar.index', compact('kamar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kamar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|string|max:10|unique:kamar',
            'tipe' => 'required|in:standar,vip,vvip',
            'harga' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,terisi,perbaikan',
            'fasilitas' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kamar', 'public');
        }

        Kamar::create($data);

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kamar $kamar)
    {
        return view('admin.kamar.edit', compact('kamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'nomor_kamar' => 'required|string|max:10|unique:kamar,nomor_kamar,' . $kamar->id,
            'tipe' => 'required|in:standar,vip,vvip',
            'harga' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,terisi,perbaikan',
            'fasilitas' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($kamar->foto) {
                Storage::disk('public')->delete($kamar->foto);
            }
            $data['foto'] = $request->file('foto')->store('kamar', 'public');
        }

        $kamar->update($data);

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kamar $kamar)
    {
        // Hapus foto jika ada
        if ($kamar->foto) {
            Storage::disk('public')->delete($kamar->foto);
        }

        $kamar->delete();

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil dihapus!');
    }
}