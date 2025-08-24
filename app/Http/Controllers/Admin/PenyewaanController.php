<?php

namespace App\Http\Controllers\Admin;

use App\Models\Penyewaan;
use App\Models\Kamar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PenyewaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Untuk admin: tampilkan semua penyewa
        // Untuk pelanggan: tampilkan hanya penyewa miliknya
        $penyewa = auth()->user()->isAdmin() 
            ? Penyewaan::with(['user', 'kamar'])->latest()->get()
            : Penyewaan::where('user_id', auth()->id())->with('kamar')->latest()->get();
            
        return view('penyewa.index', compact('penyewa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kamar = Kamar::where('status', 'tersedia')->get();
        return view('penyewa.create', compact('kamar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kamar_id' => 'required|exists:kamar,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'durasi' => 'required|integer|min:1', // durasi dalam bulan
        ]);

        $kamar = Kamar::findOrFail($validated['kamar_id']);
        
        $penyewa = Penyewaan::create([
            'user_id' => auth()->id(),
            'kamar_id' => $validated['kamar_id'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => now()->parse($validated['tanggal_mulai'])->addMonths($validated['durasi']),
            'total_pembayaran' => $kamar->harga * $validated['durasi'],
            'status' => 'aktif',
        ]);

        // Update status kamar
        $kamar->update(['status' => 'terisi']);

        return redirect()->route('penyewa.show', $penyewa->id)
            ->with('success', 'Penyewaan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penyewaan $penyewa)
    {
        // Authorization: pastikan user yang melihat adalah pemilik atau admin
        $this->authorize('view', $penyewa);
        
        return view('penyewa.show', compact('penyewa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penyewaan $penyewa)
    {
        $this->authorize('update', $penyewa);
        
        $kamar = Kamar::where('status', 'tersedia')
            ->orWhere('id', $penyewa->kamar_id)
            ->get();
            
        return view('penyewa.edit', compact('penyewa', 'kamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penyewaan $penyewa)
    {
        $this->authorize('update', $penyewa);
        
        $validated = $request->validate([
            'kamar_id' => 'required|exists:kamar,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,selesai,dibatalkan',
        ]);

        $penyewa->update($validated);

        return redirect()->route('penyewa.show', $penyewa->id)
            ->with('success', 'Penyewaan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penyewaan $penyewa)
    {
        $this->authorize('delete', $penyewa);
        
        // Kembalikan status kamar ke tersedia
        $penyewa->kamar->update(['status' => 'tersedia']);
        
        $penyewa->delete();

        return redirect()->route('penyewa.index')
            ->with('success', 'Penyewaan berhasil dihapus');
    }
}