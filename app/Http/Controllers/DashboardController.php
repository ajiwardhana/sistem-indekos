<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Penyewaan;
use App\Models\Kamar;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            // Data untuk admin
            $currentMonth = now()->month;
            $currentYear = now()->year;
            
            $data = [
                'totalPendapatanBulanIni' => Pembayaran::whereMonth('tanggal_pembayaran', $currentMonth)
                    ->whereYear('tanggal_pembayaran', $currentYear)
                    ->where('status', 'lunas')
                    ->sum('jumlah'),
                
                'pembayaranLunasCount' => Pembayaran::where('status', 'lunas')->count(),
                'pembayaranPendingCount' => Pembayaran::where('status', 'pending')->count(),
                
                'kamarTerisiCount' => Penyewaan::where('status', 'aktif')->count(),
                'totalKamarCount' => Kamar::count(),
                
                'recentPayments' => Pembayaran::with('penyewaan.user')
                    ->latest()
                    ->take(5)
                    ->get(),
                
                'monthlyStats' => Pembayaran::select(
                        DB::raw('MONTH(tanggal_pembayaran) as month'),
                        DB::raw('SUM(jumlah) as total')
                    )
                    ->whereYear('tanggal_pembayaran', $currentYear)
                    ->where('status', 'lunas')
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get()
            ];
        } else {
            // Data untuk user biasa
            $data = [
                'lastPayment' => Pembayaran::whereHas('penyewaan', function($query) {
                        $query->where('user_id', auth()->id());
                    })
                    ->latest()
                    ->first(),
                
                'userKamarStatus' => Penyewaan::where('user_id', auth()->id())
                    ->value('status'),
                
                'currentBill' => 1000000, // Ganti dengan logika perhitungan tagihan
                
                'recentPayments' => Pembayaran::whereHas('penyewaan', function($query) {
                        $query->where('user_id', auth()->id());
                    })
                    ->latest()
                    ->take(5)
                    ->get(),
                
                'rentalHistory' => Penyewaan::where('user_id', auth()->id())
                    ->latest()
                    ->get()
            ];
        }

        return view('dashboard', $data);
    }
}