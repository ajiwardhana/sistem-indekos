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
        $pembayarans = Pembayaran::where('penyewa_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('penyewa.pembayarans.index', compact('pembayarans'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $pembayaran = Pembayaran::where('id', $id)
            ->where('penyewa_id', auth()->id())
            ->firstOrFail();

        // Simpan file
        $path = $request->file('bukti')->store('bukti_pembayaran', 'public');

        // Update pembayaran
        $pembayaran->update([
            'bukti' => $path,
            'status' => 'pending', // default setelah upload
        ]);

        return redirect()->route('penyewa.pembayarans.index')
            ->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}