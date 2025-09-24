<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with(['penyewa.user', 'kamar'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pembayarans.index', compact('pembayarans'));
    }

    public function konfirmasi($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->status = 'lunas';
        $pembayaran->tanggal_bayar = now();
        $pembayaran->save();

        return redirect()->route('admin.pembayarans.index')
            ->with('success', 'Pembayaran berhasil dikonfirmasi ✅');
    }

    public function tolak($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->status = 'ditolak';
        $pembayaran->save();

        return redirect()->route('admin.pembayarans.index')
            ->with('error', 'Pembayaran ditolak ❌');
    }
}
