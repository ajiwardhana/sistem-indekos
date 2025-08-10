<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
{
    return view('admin.dashboard', [
        'totalKamar' => Kamar::count(),
        'kamarTersedia' => Kamar::where('status', 'tersedia')->count(),
        'totalPenghuni' => User::where('role', 'penghuni')->count(),
        'pendapatanBulanIni' => Pembayaran::whereMonth('tanggal_bayar', now()->month)->sum('jumlah'),
        'penyewaanTerbaru' => Penyewaan::with(['kamar', 'user'])
            ->latest()
            ->take(5)
            ->get()
    ]);
}
}
