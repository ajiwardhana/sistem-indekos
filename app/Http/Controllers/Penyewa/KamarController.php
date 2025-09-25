<?php

namespace App\Http\Controllers\Penyewa;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

class KamarController extends Controller
{
    // Menampilkan semua kamar
    public function index(Request $request)
{
    $query = Kamar::with('fotos', 'penyewa');

    if ($request->q) {
        $query->where('nomor_kamar', 'like', "%{$request->q}%")
              ->orWhere('fasilitas', 'like', "%{$request->q}%")
              ->orWhere('deskripsi', 'like', "%{$request->q}%");
    }

    if ($request->status == 'tersedia') {
        $query->doesntHave('penyewa');
    } elseif ($request->status == 'disewa') {
        $query->has('penyewa');
    }

    if ($request->sort == 'harga_asc') {
        $query->orderBy('harga', 'asc');
    } elseif ($request->sort == 'harga_desc') {
        $query->orderBy('harga', 'desc');
    } elseif ($request->sort == 'baru') {
        $query->latest();
    }

    $kamars = $query->paginate(9);

    return view('penyewa.kamars.index', compact('kamars'));
}


    // Form sewa kamar
    public function sewa(Kamar $kamar)
    {
        return view('penyewa.kamars.sewa', compact('kamar'));
    }

    // Simpan transaksi sewa
public function storeSewa(Request $request, Kamar $kamar)
{
    $request->validate([
        'durasi' => 'required|integer|min:1',
    ]);

    $user = auth()->user();

    if (Penyewa::where('user_id', $user->id)->whereNotNull('kamar_id')->exists()) {
        return back()->with('error', 'Anda sudah menyewa kamar lain.');
    }

    $durasi = (int) $request->durasi;
    $tanggalMasuk = now();
    $tanggalKeluar = $tanggalMasuk->copy()->addMonths($durasi);

    \DB::transaction(function () use ($user, $kamar, $durasi, $tanggalMasuk, $tanggalKeluar) {
        $penyewa = Penyewa::create([
            'user_id' => auth()->id(),
            'kamar_id' => $kamar->id,
            'tanggal_masuk' => $tanggalMasuk,
            'tanggal_keluar' => $tanggalKeluar,
        ]);

        Pembayaran::create([
            'penyewa_id' => $penyewa->id,
            'kamar_id' => $kamar->id,
            'jumlah' => $kamar->harga * $durasi,
            'status' => 'pending',
            'bulan' => $durasi,
            'tahun' => $tanggalMasuk->year,
            'tanggal_bayar' => null,
        ]);

        $kamar->update(['status' => 'pending']);
    });

    return redirect()->route('penyewa.dashboard')->with('success', 'Kamar berhasil dipesan, menunggu konfirmasi admin.');
}


}
