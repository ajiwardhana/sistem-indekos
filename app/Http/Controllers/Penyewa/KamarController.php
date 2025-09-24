<?php

namespace App\Http\Controllers\Penyewa;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Pembayaran;

class KamarController extends Controller
{
    // Menampilkan semua kamar
    public function index()
    {
        $kamars = Kamar::with('penyewa')->get();
        return view('penyewa.kamar.index', compact('kamars'));
    }

    // Form sewa kamar
    public function sewa(Kamar $kamar)
    {
        return view('penyewa.kamar.sewa', compact('kamar'));
    }

    // Simpan transaksi sewa
public function storeSewa(Request $request, Kamar $kamar)
    {
        // ✅ Validasi input
        $request->validate([
            'durasi' => 'required|integer|min:1', // durasi minimal 1 bulan
        ]);

        $user = Auth::user();

        // ✅ Pastikan user belum sewa kamar lain
        if (Penyewa::where('user_id', $user->id)->whereNotNull('kamar_id')->exists()) {
            return back()->with('error', 'Anda sudah menyewa kamar lain.');
        }

        $durasi = (int) $request->durasi; // konversi string -> int
        $tanggalMasuk = Carbon::now();
        $tanggalKeluar = $tanggalMasuk->copy()->addMonths($durasi);

        // ✅ Simpan data penyewa
        $penyewa = Penyewa::create([
            'user_id'       => $user->id,
            'kamar_id'      => $kamar->id,
            'tanggal_masuk' => $tanggalMasuk,
            'tanggal_keluar'=> $tanggalKeluar,
        ]);

        // ✅ Simpan data pembayaran (status pending dulu)
        Pembayaran::create([
            'penyewa_id' => $penyewa->id,
            'kamar_id'   => $kamar->id,
            'jumlah'     => $kamar->harga * $durasi,
            'status'     => 'pending',
            'bulan'      => $durasi, // ⬅️ jangan lupa ini!
            'tanggal_bayar' => null, // default null
        ]);

        // ✅ Update status kamar
        $kamar->update([
            'status' => 'pending', // pending sampai admin konfirmasi
        ]);

        return redirect()->route('penyewa.dashboard')->with('success', 'Kamar berhasil dipesan, menunggu konfirmasi admin.');
    }

}
