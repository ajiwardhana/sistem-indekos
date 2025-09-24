<?php

namespace App\Http\Controllers\Penyewa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Penyewa;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data penyewa dari user login
        $penyewa = Penyewa::where('user_id', Auth::id())
            ->with('kamar')
            ->first();

        // Ambil pembayaran terakhir si penyewa
        $pembayaranTerakhir = null;
        if ($penyewa) {
            $pembayaranTerakhir = Pembayaran::where('penyewa_id', $penyewa->id)
                ->latest()
                ->first();
        }

        return view('penyewa.dashboard', compact('penyewa', 'pembayaranTerakhir'));
    }
}