<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penyewaan;
use App\Models\Kamar;
use App\Models\Penyewa;
use App\Models\Pembayaran;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_kamar' => Kamar::count(),
            'kamar_tersedia' => Kamar::where('status', 'tersedia')->count(),
            'penyewa_aktif' => Penyewa::where('status', 'aktif')->count(),
            'pendapatan_bulan_ini' => Pembayaran::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum('jumlah')
        ];

        $pembayaran_terakhir = Pembayaran::with('penyewa')
            ->latest()
            ->take(5)
            ->get();

        $penyewa_baru = Penyewa::with('kamar')
            ->latest()
            ->take(5)
            ->get();

        // Data untuk chart
        $chart_pendapatan = $this->getChartData();

        return view('admin.dashboard', compact(
            'stats',
            'pembayaran_terakhir',
            'penyewa_baru',
            'chart_pendapatan'
        ));
    }

    private function getChartData()
    {
        $data = [];
        $labels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M Y');
            
            $total = Pembayaran::whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->sum('jumlah');
            
            $data[] = $total;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}