<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penyewaan;
use App\Models\Pembayaran;
use App\Models\Kamar;
use App\Models\Kost;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Redirect berdasarkan role
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }
        
        return $this->userDashboard();
    }
    
    protected function adminDashboard()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        // Initialize semua variable dengan default values
        $defaultVariables = [
            'totalPendapatanBulanIni' => 0,
            'pembayaranLunasCount' => 0,
            'pembayaranPendingCount' => 0,
            'totalKamarCount' => 0,
            'kamarTersedia' => 0,
            'kamarTerisi' => 0,
            'kamarMaintenance' => 0,
            'totalKostCount' => 0,
            'monthlyStats' => collect(),
            'recentPayments' => collect(),
        ];
        
        try {
            // Hitung total pendapatan bulan ini
            $totalPendapatanBulanIni = Pembayaran::where('status', 'lunas')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('jumlah');
            
            // Hitung pembayaran lunas
            $pembayaranLunasCount = Pembayaran::where('status', 'lunas')->count();
            
            // Hitung pembayaran pending
            $pembayaranPendingCount = Pembayaran::where('status', 'pending')->count();
            
            // Hitung total kamar
            $totalKamarCount = Kamar::count();
            
            // Hitung kamar berdasarkan status
            $kamarTersedia = Kamar::where('status', 'tersedia')->count();
            $kamarTerisi = Kamar::where('status', 'terisi')->count();
            $kamarMaintenance = Kamar::where('status', 'maintenance')->count();
            
            // Hitung total kost
            $totalKostCount = Kost::count();
            
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
                
        } catch (\Exception $e) {
            \Log::error('Admin Dashboard Error: ' . $e->getMessage());
            // Gunakan default values jika error
            extract($defaultVariables);
        }
        
        return view('admin.dashboard', compact(
            'totalPendapatanBulanIni',
            'pembayaranLunasCount',
            'pembayaranPendingCount',
            'totalKamarCount',
            'kamarTersedia',
            'kamarTerisi',
            'kamarMaintenance',
            'totalKostCount',
            'monthlyStats',
            'recentPayments'
        ));
    }
    
    protected function userDashboard()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Initialize default values
        $defaultVariables = [
            'lastPayment' => null,
            'userKamarStatus' => 'Tidak aktif',
            'currentBill' => 0,
            'recentPayments' => collect(),
            'rentalHistory' => collect(),
        ];
        
        try {
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
                
        } catch (\Exception $e) {
            \Log::error('User Dashboard Error: ' . $e->getMessage());
            // Gunakan default values jika error
            extract($defaultVariables);
        }
        
        return view('user.dashboard', compact(
            'lastPayment',
            'userKamarStatus',
            'currentBill',
            'recentPayments',
            'rentalHistory'
        ));
    }
}