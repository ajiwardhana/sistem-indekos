<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penyewaan;
use App\Models\Pembayaran;
use App\Models\Kamar;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return $this->adminDashboard($user);
        }
        
        return $this->userDashboard($user);
    }
    
    protected function adminDashboard($user)
    {
        // Hitung total pendapatan bulan ini
        $totalPendapatanBulanIni = Pembayaran::where('status', 'lunas')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('jumlah');
        
        // Hitung pembayaran lunas
        $pembayaranLunasCount = Pembayaran::where('status', 'lunas')->count();
        
        // Hitung pembayaran pending
        $pembayaranPendingCount = Pembayaran::where('status', 'pending')->count();
        
        // Hitung kamar terisi dan total
        $kamarTerisiCount = Penyewaan::where('status', 'aktif')->count();
        $totalKamarCount = Kamar::count();
        
        // Statistik bulanan untuk chart
        $monthlyStats = Pembayaran::selectRaw('
                MONTH(created_at) as month, 
                SUM(jumlah) as total,
                COUNT(*) as count
            ')
            ->where('status', 'lunas')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                return [
                    'month' => Carbon::create()->month($item->month)->format('M'),
                    'total' => $item->total,
                    'count' => $item->count
                ];
            });
        
        // Pembayaran terbaru
        $recentPayments = Pembayaran::with(['penyewaan.user'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard', compact(
            'totalPendapatanBulanIni',
            'pembayaranLunasCount',
            'pembayaranPendingCount',
            'kamarTerisiCount',
            'totalKamarCount',
            'monthlyStats',
            'recentPayments'
        ));
    }
    
    protected function userDashboard($user)
    {
        // Pembayaran terakhir user
        $lastPayment = Pembayaran::whereHas('penyewaan', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->first();
        
        // Status kamar user
        $activeRental = Penyewaan::with('kamar')
            ->where('user_id', $user->id)
            ->where('status', 'aktif')
            ->first();
        
        $userKamarStatus = $activeRental ? $activeRental->kamar->nomor_kamar : 'Tidak aktif';
        
        // Tagihan bulan ini
        $currentBill = $activeRental ? $activeRental->kamar->harga : 0;
        
        // Pembayaran terbaru user
        $recentPayments = Pembayaran::whereHas('penyewaan', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->take(5)
            ->get();

        // Riwayat penyewaan user
        $rentalHistory = Penyewaan::with('kamar')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // GUNAKAN VIEW 'dashboard' BUKAN 'dashboard_user'
        return view('dashboard', compact(
            'lastPayment',
            'userKamarStatus',
            'currentBill',
            'recentPayments',
            'rentalHistory'
        ));
    }
}