<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // Daftar pembayaran admin
    public function index()
    {
        $pembayarans = Pembayaran::with('penyewa.user', 'kamar')->get();
        return view('admin.pembayarans.index', compact('pembayarans'));
    }

    // Konfirmasi pembayaran
    public function konfirmasi($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update(['status' => 'lunas']);
        $pembayaran->kamar->update(['status' => 'terisi']); // kamar jadi terisi
        return back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    // Tolak pembayaran
    public function tolak($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update(['status' => 'ditolak']);
        $pembayaran->kamar->update(['status' => 'tersedia']); // kamar kembali tersedia
        return back()->with('success', 'Pembayaran berhasil ditolak!');
    }
}
