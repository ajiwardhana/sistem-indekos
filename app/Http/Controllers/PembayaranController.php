<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayarans = Pembayaran::with('penyewa')->latest()->paginate(10);
        return view('pembayaran.index', compact('pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penyewas = Penyewa::where('status', 'aktif')->get();
        return view('pembayaran.create', compact('penyewas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'penyewa_id' => 'required|exists:penyewas,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
            'bulan' => 'required|date_format:Y-m',
            'metode_pembayaran' => 'required|in:transfer,tunai',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Tambahkan tahun ke bulan
        $validated['bulan'] = Carbon::createFromFormat('Y-m', $validated['bulan'])->format('Y-m');

        Pembayaran::create($validated);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dicatat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran)
    {
        return view('pembayaran.show', compact('pembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        $penyewas = Penyewa::where('status', 'aktif')->get();
        return view('pembayaran.edit', compact('pembayaran', 'penyewa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            'penyewa_id' => 'required|exists:penyewa,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
            'bulan' => 'required|date_format:Y-m',
            'metode_pembayaran' => 'required|in:transfer,tunai',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $validated['bulan'] = Carbon::createFromFormat('Y-m', $validated['bulan'])->format('Y-m');

        $pembayaran->update($validated);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus');
    }

    /**
     * Cetak bukti pembayaran
     */
    public function cetak(Pembayaran $pembayaran)
    {
        return view('pembayaran.cetak', compact('pembayaran'));
    }
}