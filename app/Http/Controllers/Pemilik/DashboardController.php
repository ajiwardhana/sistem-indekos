<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewa;
use App\Models\Pembayaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    // Total penyewa aktif
    $totalPenyewa = Penyewa::where('status','aktif')->count();

    // Pendapatan bulan ini
    $pendapatanBulanIni = Pembayaran::whereMonth('created_at', now()->month)
                                    ->where('status','lunas')
                                    ->sum('jumlah');

    // Daftar penyewa aktif (relasi user dan kamar)
    $penyewaAktif = Penyewa::with(['user','kamar'])
                            ->where('status','aktif')
                            ->get();

    return view('pemilik.dashboard', compact('totalPenyewa','pendapatanBulanIni','penyewaAktif'));
}
}
