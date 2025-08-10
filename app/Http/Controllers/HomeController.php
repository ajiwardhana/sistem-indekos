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
        ->with(['kamar:id,nomor_kamar', 'pembayaran' => fn($q) => $q->latest()])
        ->where('status', 'aktif')
        ->first(['id', 'kamar_id', 'tanggal_mulai', 'status']);

    return view('user.dashboard', [
        'penyewaanAktif' => $penyewaanAktif,
        'riwayatPembayaran' => $penyewaanAktif?->pembayaran ?? collect()
    ]);
}
}