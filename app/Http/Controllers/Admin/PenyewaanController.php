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
        // Untuk admin: tampilkan semua penyewaan
        // Untuk pelanggan: tampilkan hanya penyewaan miliknya
        $penyewaan = auth()->user()->isAdmin() 
            ? Penyewaan::with(['user', 'kamar'])->latest()->get()
            : Penyewaan::where('user_id', auth()->id())->with('kamar')->latest()->get();
            
        return view('penyewaan.index', compact('penyewaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kamar = Kamar::where('status', 'tersedia')->get();
        return view('penyewaan.create', compact('kamar'));
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
        
        $penyewaan = Penyewaan::create([
            'user_id' => auth()->id(),
            'kamar_id' => $validated['kamar_id'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => now()->parse($validated['tanggal_mulai'])->addMonths($validated['durasi']),
            'total_pembayaran' => $kamar->harga * $validated['durasi'],
            'status' => 'aktif',
        ]);

        // Update status kamar
        $kamar->update(['status' => 'terisi']);

        return redirect()->route('penyewaan.show', $penyewaan->id)
            ->with('success', 'Penyewaan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penyewaan $penyewaan)
    {
        // Authorization: pastikan user yang melihat adalah pemilik atau admin
        $this->authorize('view', $penyewaan);
        
        return view('penyewaan.show', compact('penyewaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penyewaan $penyewaan)
    {
        $this->authorize('update', $penyewaan);
        
        $kamar = Kamar::where('status', 'tersedia')
            ->orWhere('id', $penyewaan->kamar_id)
            ->get();
            
        return view('penyewaan.edit', compact('penyewaan', 'kamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penyewaan $penyewaan)
    {
        $this->authorize('update', $penyewaan);
        
        $validated = $request->validate([
            'kamar_id' => 'required|exists:kamar,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,selesai,dibatalkan',
        ]);

        $penyewaan->update($validated);

        return redirect()->route('penyewaan.show', $penyewaan->id)
            ->with('success', 'Penyewaan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penyewaan $penyewaan)
    {
        $this->authorize('delete', $penyewaan);
        
        // Kembalikan status kamar ke tersedia
        $penyewaan->kamar->update(['status' => 'tersedia']);
        
        $penyewaan->delete();

        return redirect()->route('penyewaan.index')
            ->with('success', 'Penyewaan berhasil dihapus');
    }

    public function sewa(Request $request, $kamar_id)
    {
        // Validasi data
        $validated = $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'durasi' => 'required|integer|min:1|max:12',
        ]);

        // Cari kamar
        $kamar = Kamar::findOrFail($kamar_id);

        // Pastikan kamar tersedia
        if ($kamar->status !== 'tersedia') {
            return redirect()->back()->with('error', 'Kamar tidak tersedia untuk disewa.');
        }

        // Hitung total harga
        $totalHarga = $kamar->harga * $validated['durasi'];

        // Buat penyewaan
        $penyewaan = Penyewaan::create([
            'user_id' => Auth::id(),
            'kamar_id' => $kamar->id,
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'durasi' => $validated['durasi'],
            'total_harga' => $totalHarga,
            'status' => 'menunggu_pembayaran',
        ]);

        // Update status kamar menjadi terisi
        $kamar->update(['status' => 'terisi']);

        return redirect()->route('user.penyewaan.index')
            ->with('success', 'Kamar berhasil dipesan. Silakan lakukan pembayaran.');
    }
}
