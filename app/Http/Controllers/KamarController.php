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
    $kamar = Kamar::latest()->paginate(10);
    
    // Hitung statistik
    $totalKamar = Kamar::count();
    $tersedia = Kamar::where('status', 'tersedia')->count();
    $terisi = Kamar::where('status', 'terisi')->count();
    $maintenance = Kamar::where('status', 'perbaikan')->count();

    return view('admin.kamar.index', compact('kamar', 'totalKamar', 'tersedia', 'terisi', 'maintenance'));
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

    public function show(Kamar $kamar)
    {
        // Cek apakah kamar tersedia
        if ($kamar->status !== 'tersedia') {
            return redirect()->route('user.kamar.index')
                ->with('error', 'Kamar tidak tersedia untuk disewa.');
        }
        
        return view('user.kamar.show', compact('kamar'));
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