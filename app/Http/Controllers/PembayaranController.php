<?php

namespace App\Http\Controllers\Auth;

use App\Models\Pembayaran;
use App\Models\Penyewaan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Admin melihat semua pembayaran, pelanggan hanya melihat miliknya
        $pembayarans = auth()->user()->isAdmin()
            ? Pembayaran::with('penyewaan')->latest()->get()
            : Pembayaran::whereHas('penyewaan', function($query) {
                $query->where('user_id', auth()->id());
            })->with('penyewaan')->latest()->get();

        return view('pembayaran.index', compact('pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya ambil penyewaan aktif yang dimiliki user (untuk pelanggan)
        $penyewaans = Penyewaan::where('user_id', auth()->id())
                        ->where('status', 'aktif')
                        ->get();

        return view('pembayaran.create', compact('penyewaans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'penyewaan_id' => 'required|exists:penyewaan,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_pembayaran' => 'required|date',
            'metode_pembayaran' => 'required|in:transfer,tunai',
            'bukti_pembayaran' => 'required_if:metode_pembayaran,transfer|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan bukti pembayaran jika ada
        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            $validated['bukti_pembayaran'] = $path;
        }

        // Default status pending
        $validated['status'] = $validated['metode_pembayaran'] === 'tunai' ? 'lunas' : 'pending';

        Pembayaran::create($validated);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil direkam');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran)
    {
        // Authorization: pastikan user yang melihat adalah pemilik atau admin
        $this->authorize('view', $pembayaran);

        return view('pembayaran.show', compact('pembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        $this->authorize('update', $pembayaran);

        // Hanya admin yang bisa edit pembayaran
        $penyewaans = Penyewaan::all();
        return view('pembayaran.edit', compact('pembayaran', 'penyewaans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $this->authorize('update', $pembayaran);

        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'tanggal_pembayaran' => 'required|date',
            'status' => 'required|in:pending,lunas,gagal',
            'keterangan' => 'nullable|string',
        ]);

        $pembayaran->update($validated);

        return redirect()->route('pembayaran.show', $pembayaran->id)
            ->with('success', 'Pembayaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        $this->authorize('delete', $pembayaran);

        // Hapus file bukti pembayaran jika ada
        if ($pembayaran->bukti_pembayaran) {
            Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
        }

        $pembayaran->delete();

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus');
    }

    /**
     * Custom method untuk verifikasi pembayaran oleh admin
     */
    public function verify($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $this->authorize('verify', $pembayaran);

        $pembayaran->update(['status' => 'lunas']);

        return back()->with('success', 'Pembayaran telah diverifikasi');
    }
}