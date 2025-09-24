<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::orderBy('created_at', 'desc')->get();
        return view('admin.pembayarans.index', compact('pembayarans'));
    }

    public function konfirmasi($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update(['status' => 'lunas']);

        return redirect()->route('admin.pembayarans.index')->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function tolak($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update(['status' => 'ditolak']);

        return redirect()->route('admin.pembayarans.index')->with('error', 'Pembayaran ditolak.');
    }
}
