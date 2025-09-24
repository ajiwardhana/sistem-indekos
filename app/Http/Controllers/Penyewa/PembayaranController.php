<?php

namespace App\Http\Controllers\Penyewa;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index()
    {
        $penyewa = Penyewa::where('user_id', Auth::id())->first();
        $pembayarans = Pembayaran::where('penyewa_id', $penyewa->id)
            ->with('kamar')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('penyewa.pembayarans.index', compact('pembayarans'));
    }

    public function bayar(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('bukti_pembayaran', 'public');
            $pembayaran->bukti = $path;
        }

        $pembayaran->status = 'pending'; // menunggu admin cek
        $pembayaran->save();

        return redirect()->route('penyewa.pembayaran.index')
            ->with('success', 'Bukti pembayaran berhasil dikirim, menunggu konfirmasi admin.');
    }
}
