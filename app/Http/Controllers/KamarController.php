<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KamarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    try {
        $kamar = Kamar::where('status', 'tersedia')->get();
        
        // Pastikan $kamars adalah collection, bukan boolean
        if ($kamar->isEmpty()) {
            return view('user.kamar.index', compact('kamar'))
                ->with('info', 'Tidak ada kamar tersedia saat ini.');
        }
        
        return view('user.kamar.index', compact('kamar'));
        
    } catch (\Exception $e) {
        return redirect()->route('user.dashboard')
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

public function show($id)
{
    try {
        $kamar = Kamar::where('status', 'tersedia')->find($id);
        
        // Jika kamar tidak ditemukan atau tidak tersedia
        if (!$kamar) {
            return redirect()->route('user.kamar.index')
                ->with('error', 'Kamar tidak tersedia atau tidak ditemukan.');
        }
        
        return view('user.kamar.show', compact('kamar'));
        
    } catch (\Exception $e) {
        return redirect()->route('user.kamar.index')
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
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
        $validated = $request->validate([
            'nomor_kamar' => 'required|unique:kamar|max:10',
            'harga' => 'required|numeric',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:tersedia,terisi,perbaikan',
        ]);

        Kamar::create($validated);

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */



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
        $validated = $request->validate([
            'nomor_kamar' => 'required|max:10|unique:kamar,nomor_kamar,'.$kamar->id,
            'harga' => 'required|numeric',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:tersedia,terisi,perbaikan',
        ]);

        $kamar->update($validated);

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Data kamar berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kamar $kamar)
    {
        $kamar->delete();

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil dihapus');
    }



}