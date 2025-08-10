<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penyewa;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Data Statistik
        $totalKamar = Kamar::count();
        $kamarTersedia = Kamar::where('status', 'tersedia')->count();
        $penyewaAktif = Penyewa::where('status', 'aktif')->count();
        
        // Pendapatan bulan ini
        $pendapatanBulanIni = Pembayaran::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('jumlah');
        
        // Data untuk chart pendapatan
        $chartBulan = [];
        $chartPendapatan = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartBulan[] = $date->format('M Y');
            
            $total = Pembayaran::whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->sum('jumlah');
            
            $chartPendapatan[] = $total;
        }
        
        // Data status kamar
        $kamarStatus = [
            Kamar::where('status', 'tersedia')->count(),
            Kamar::where('status', 'terisi')->count(),
            Kamar::where('status', 'perbaikan')->count()
        ];
        
        // Penyewa terbaru
        $penyewaTerbaru = Penyewa::with('kamar')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalKamar',
            'kamarTersedia',
            'penyewaAktif',
            'pendapatanBulanIni',
            'chartBulan',
            'chartPendapatan',
            'kamarStatus',
            'penyewaTerbaru'
        ));
    }
}