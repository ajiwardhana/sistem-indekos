<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function adminDashboard()
{
    $totalPenghuni = \App\Models\penyewaan::count();
    $totalKamar = \App\Models\Kamar::count();
    $kamarTersedia = \App\Models\Kamar::where('status', 'tersedia')->count();
    $pembayaranPending = \App\Models\Pembayaran::where('status', 'pending')->count();

    return view('admin.dashboard', compact('totalPenghuni', 'totalKamar', 'kamarTersedia', 'pembayaranPending'));
}
}