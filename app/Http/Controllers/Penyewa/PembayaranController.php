<?php

namespace App\Http\Controllers\Penyewa;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::whereHas('penyewa', function($q){
            $q->where('user_id', auth()->id());
        });

        // ✅ Filter berdasarkan status jika ada
        if ($request->has('status') && in_array($request->status, ['pending','lunas','ditolak'])) {
            $query->where('status', $request->status);
        }

        $pembayarans = $query->orderBy('created_at','desc')->paginate(10);

        return view('penyewa.pembayarans.index', compact('pembayarans'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $pembayaran = Pembayaran::where('id', $id)
            ->whereHas('penyewa', fn($q) => $q->where('user_id', auth()->id()))
            ->firstOrFail();

        $path = $request->file('bukti')->store('bukti_pembayaran', 'public');

        $pembayaran->update([
            'bukti_pembayaran' => $path,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('penyewa.pembayarans.index')
            ->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}
