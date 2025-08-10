<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Penyewaan;
use App\Models\Pembayaran;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $total_kamar = Kamar::count();
        $total_pelanggan = User::where('role', 'pelanggan')->count();
        $total_penyewaan = Penyewaan::count();
        $total_pendapatan = Pembayaran::where('status', 'lunas')->sum('jumlah');
        
        return view('admin.dashboard', compact(
            'total_kamar',
            'total_pelanggan',
            'total_penyewaan',
            'total_pendapatan'
        ));
    }


}