<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // ✅ TAMBAHKAN INI

class PenyewaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Ganti all() dengan paginate()
    $penyewaan = Penyewaan::with(['user', 'kamar'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
    
    return view('penyewaan.index', compact('penyewaan'));
}

    /**
     * Method untuk menyewa kamar (POST request dari modal)
     */
    public function sewa(Request $request, $kamar_id)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'tanggal_mulai' => 'required|date|after_or_equal:today',
                'durasi' => 'required|integer|min:1|max:12'
            ]);

            // Cari kamar berdasarkan ID
            $kamar = Kamar::findOrFail($kamar_id);
            
            // Cek ketersediaan kamar
            if ($kamar->status !== 'tersedia') {
                return redirect()->back()
                    ->with('error', 'Maaf, kamar ini sudah tidak tersedia.');
            }

            // Cek jika user sudah memiliki penyewaan aktif
            $existingPenyewaan = Penyewaan::where('user_id', Auth::id())
                ->whereIn('status', ['aktif', 'menunggu_pembayaran', 'dikonfirmasi'])
                ->exists();

            if ($existingPenyewaan) {
                return redirect()->back()
                    ->with('error', 'Anda sudah memiliki penyewaan aktif.');
            }

            // Hitung tanggal selesai dan total harga
            $tanggal_selesai = date('Y-m-d', strtotime($validated['tanggal_mulai'] . ' + ' . $validated['durasi'] . ' months'));
            $totalHarga = $kamar->harga * $validated['durasi'];

            // Buat penyewaan
            $penyewaan = Penyewaan::create([
                'user_id' => Auth::id(),
                'kamar_id' => $kamar->id,
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $tanggal_selesai,
                'durasi' => $validated['durasi'],
                'total_harga' => $totalHarga,
                'status' => 'menunggu_pembayaran'
            ]);

            // Update status kamar
            $kamar->update(['status' => 'terisi']);

            return redirect()->route('user.penyewaan.index')
                ->with('success', 'Kamar berhasil dipesan! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
     * Display the specified resource.
     */
    public function show($id)
{
    $penyewaan = Penyewaan::with(['user', 'kamar'])->findOrFail($id);
    return view('penyewaan.show', compact('penyewaan'));
}

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penyewaan $penyewaan)
    {
        // Pastikan user hanya bisa edit penyewaannya sendiri
        if ($penyewaan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $kamar = Kamar::where('status', 'tersedia')
            ->orWhere('id', $penyewaan->kamar_id)
            ->get();
            
        return view('user.penyewaan.edit', compact('penyewaan', 'kamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penyewaan $penyewaan)
    {
        // Pastikan user hanya bisa update penyewaannya sendiri
        if ($penyewaan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'tanggal_mulai' => 'required|date',
            'durasi' => 'required|integer|min:1'
        ]);

        // Hitung ulang tanggal selesai dan total harga
        $tanggal_selesai = date('Y-m-d', strtotime($validated['tanggal_mulai'] . ' + ' . $validated['durasi'] . ' months'));
        $totalHarga = $penyewaan->kamar->harga * $validated['durasi'];

        $penyewaan->update([
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'durasi' => $validated['durasi'],
            'tanggal_selesai' => $tanggal_selesai,
            'total_harga' => $totalHarga
        ]);

        return redirect()->route('user.penyewaan.index')
            ->with('success', 'Penyewaan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penyewaan $penyewaan)
    {
        // Pastikan user hanya bisa hapus penyewaannya sendiri
        if ($penyewaan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Kembalikan status kamar ke tersedia
        Kamar::where('id', $penyewaan->kamar_id)->update(['status' => 'tersedia']);
        
        $penyewaan->delete();

        return redirect()->route('user.penyewaan.index')
            ->with('success', 'Penyewaan berhasil dibatalkan');
    }
}