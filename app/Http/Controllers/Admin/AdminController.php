<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
{
    // Gunakan eager loading dan select hanya kolom yang diperlukan
    $penyewaanTerbaru = Penyewaan::with(['kamar:id,nomor_kamar', 'user:id,name'])
        ->latest()
        ->take(5)
        ->get(['id', 'kamar_id', 'user_id', 'tanggal_mulai', 'status']);

    return view('admin.dashboard', [
        'totalKamar' => Kamar::count(),
        'kamarTersedia' => Kamar::where('status', 'tersedia')->count(),
        'totalPenghuni' => User::where('role', 'penghuni')->count(),
        'pendapatanBulanIni' => Pembayaran::whereMonth('tanggal_bayar', now()->month)->sum('jumlah'),
        'penyewaanTerbaru' => $penyewaanTerbaru
    ]);

    $stats = Cache::remember('dashboard_stats', now()->addHours(1), function () {
        return [
            'totalKamar' => Kamar::count(),
            'kamarTersedia' => Kamar::where('status', 'tersedia')->count(),
            'totalPenghuni' => User::where('role', 'penghuni')->count()
        ];
    });
    
    return view('admin.dashboard', array_merge($stats, [
        'penyewaanTerbaru' => Penyewaan::with(['kamar', 'user'])->latest()->take(5)->get()
    ]));
}
}
