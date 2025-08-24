<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenyewaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyewaan = Penyewaan::with('kamar')->latest()->paginate(10);
        return view('admin.penyewaan.index', compact('penyewaan'));
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
    public function store(Request $request, Kamar $kamar)
{
    // Validasi
    $request->validate([
        'tanggal_mulai' => 'required|date|after_or_equal:today',
        'durasi' => 'required|integer|min:1'
    ]);

    // Cek apakah kamar masih tersedia
    if ($kamar->status !== 'tersedia') {
        return redirect()->back()
            ->with('error', 'Maaf, kamar ini sudah tidak tersedia.');
    }

    // Cek apakah user sudah menyewa kamar lain yang aktif
    $penyewaananAktif = Penyewaan::where('user_id', Auth::id())
        ->whereIn('status', ['aktif', 'menunggu_pembayaran'])
        ->exists();

    if ($penyewaananAktif) {
        return redirect()->back()
            ->with('error', 'Anda sudah memiliki kamar yang aktif. Tidak bisa menyewa lebih dari satu kamar.');
    }

    try {
        // Hitung tanggal selesai
        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_selesai = date('Y-m-d', strtotime($tanggal_mulai . ' + ' . $request->durasi . ' months'));

        // Buat penyewaan
        $penyewaan = Penyewaan::create([
            'user_id' => Auth::id(),
            'kamar_id' => $kamar->id,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'durasi' => $request->durasi,
            'status' => 'menunggu_pembayaran'
        ]);

        // Update status kamar menjadi dipesan
        $kamar->update(['status' => 'dipesan']);

        return redirect()->route('user.pembayaran.index')
            ->with('success', 'Kamar berhasil dipesan! Silakan lakukan pembayaran dalam 24 jam.');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Penyewaan $penyewaan)
    {
        return view('penyewaan.show', compact('penyewaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(penyewaan $penyewaan)
    {
        $kamar = Kamar::where('status', 'tersedia')
            ->orWhere('id', $penyewaan->kamar_id)
            ->get();
            
        return view('penyewaan.edit', compact('penyewaan', 'kamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, penyewaan $penyewaan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penyewaan,email,'.$penyewaan->id,
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'kamar_id' => 'required|exists:kamar,id',
            'tanggal_masuk' => 'required|date',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Handle foto KTP update
        if ($request->hasFile('foto_ktp')) {
            // Hapus foto lama jika ada
            if ($penyewaan->foto_ktp) {
                Storage::disk('public')->delete($penyewaan->foto_ktp);
            }
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp-images', 'public');
        }

        // Update status kamar jika kamar diubah
        if ($penyewaan->kamar_id != $validated['kamar_id']) {
            Kamar::where('id', $penyewaan->kamar_id)->update(['status' => 'tersedia']);
            Kamar::where('id', $validated['kamar_id'])->update(['status' => 'terisi']);
        }

        $penyewaan->update($validated);

        return redirect()->route('penyewaan.index')
            ->with('success', 'Data penyewaan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(penyewaan $penyewaan)
    {
        // Kembalikan status kamar ke tersedia
        Kamar::where('id', $penyewaan->kamar_id)->update(['status' => 'tersedia']);
        
        // Hapus foto KTP jika ada
        if ($penyewaan->foto_ktp) {
            Storage::disk('public')->delete($penyewaan->foto_ktp);
        }
        
        $penyewaan->delete();

        return redirect()->route('penyewaan.index')
            ->with('success', 'Data penyewaan berhasil dihapus');
    }

    /**
     * Cetak data penyewaan
     */
    public function cetak()
    {
        $penyewaan = penyewaan::with('kamar')->latest()->get();
        return view('penyewaan.cetak', compact('penyewaan'));
    }
}