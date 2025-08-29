<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Penyewaan;
use App\Models\Pembayaran;
use App\Models\Kamar;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Redirect berdasarkan role user
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    
    public function adminDashboard()
    {
        // Hitung statistik untuk admin
        $total_kamar = DB::table('kamar')->count();
        $kamar_tersedia = DB::table('kamar')->where('status', 'tersedia')->count();
        $total_penghuni = DB::table('penyewaan')->where('status', 'aktif')->count();
        $pembayaran_pending = DB::table('pembayaran')->where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'total_kamar', 
            'kamar_tersedia', 
            'total_penghuni', 
            'pembayaran_pending'
        ));
    }
    
    public function userDashboard()
{
    $user_id = Auth::id();

    // Query untuk mendapatkan penyewaan aktif user (HANYA nomor_kamar)
    $penyewaan_aktif = DB::table('penyewaan')
        ->join('kamar', 'penyewaan.kamar_id', '=', 'kamar.id')
        ->where('penyewaan.user_id', $user_id)
        ->where('penyewaan.status', 'aktif')
        ->select('penyewaan.*', 'kamar.nomor_kamar', 'kamar.harga')
        ->first();

    // Query untuk mendapatkan pembayaran terbaru user
    $pembayaran_terbaru = DB::table('pembayaran')
        ->join('penyewaan', 'pembayaran.penyewaan_id', '=', 'penyewaan.id')
        ->where('penyewaan.user_id', $user_id)
        ->orderBy('pembayaran.created_at', 'desc')
        ->select('pembayaran.*')
        ->limit(5)
        ->get();

    // Query untuk riwayat penyewaan user (HANYA nomor_kamar)
    $riwayat_penyewaan = DB::table('penyewaan')
        ->join('kamar', 'penyewaan.kamar_id', '=', 'kamar.id')
        ->where('penyewaan.user_id', $user_id)
        ->orderBy('penyewaan.created_at', 'desc')
        ->select('penyewaan.*', 'kamar.nomor_kamar')
        ->limit(10)
        ->get();

    // Return view dengan semua data
    return view('user.dashboard', compact('penyewaan_aktif', 'pembayaran_terbaru', 'riwayat_penyewaan'));
}
}