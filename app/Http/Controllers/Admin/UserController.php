<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user_id = Auth::id();
        
        // Query untuk mendapatkan status kamar dan penyewaan terbaru
        $rental = DB::table('penyewaan')
            ->join('kamar', 'penyewaan.kamar_id', '=', 'kamar.id')
            ->where('penyewaan.user_id', $user_id)
            ->orderBy('penyewaan.id', 'desc')
            ->first();
        
        // Query untuk mendapatkan pembayaran terbaru
        $payments = DB::table('pembayaran')
            ->where('user_id', $user_id)
            ->orderBy('tanggal_bayar', 'desc')
            ->limit(5)
            ->get();
        
        // Query untuk mendapatkan riwayat penyewaan
        $rental_history = DB::table('penyewaan')
            ->join('kamar', 'penyewaan.kamar_id', '=', 'kamar.id')
            ->where('penyewaan.user_id', $user_id)
            ->orderBy('penyewaan.id', 'desc')
            ->get();
        
        return view('user.dashboard', compact('rental', 'payments', 'rental_history'));
    }
}