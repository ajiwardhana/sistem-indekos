<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    
    public function dashboard()
{
    $penyewaanAktif = auth()->user()->penyewaan()
        ->where('status', 'aktif')
        ->with('kamar')
        ->first();

    return view('user.dashboard', [
        'penyewaanAktif' => $penyewaanAktif,
        'riwayatPembayaran' => $penyewaanAktif 
            ? $penyewaanAktif->pembayaran()->latest()->get()
            : collect()
    ]);
}
}