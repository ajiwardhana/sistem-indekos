<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Penyewaan;
use App\Models\Pembayaran;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalKamar = Kamar::count();
        $totalPenyewaan = Penyewaan::count();
        $totalPembayaran = Pembayaran::count();
        $totalPengguna = User::count();

        return view('admin.dashboard', compact('totalKamar', 'totalPenyewaan', 'totalPembayaran', 'totalPengguna'));
    }

    public function pembayaran()
    {
        $pembayaran = Pembayaran::with('penyewaan')->latest()->get();
        return view('admin.pembayaran', compact('pembayarans'));
    }
    // app/Http/Controllers/AdminController.php
    public function penyewaan()
    {
        $penyewaan = Penyewaan::with('kamar', 'user')->latest()->get();
        return view('admin.penyewaan', compact('penyewaans'));
    }
    public function pengguna()
    {
        $pengguna = User::latest()->get();
        return view('admin.pengguna', compact('penggunas'));
    }
    
}