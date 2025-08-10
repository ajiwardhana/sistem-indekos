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
    // Optimasi query dengan membatasi field dan menggunakan cache
    $penyewaanAktif = cache()->remember('penyewaan_aktif_'.auth()->id(), 3600, function() {
        return auth()->user()->penyewaan()
            ->with([
                'kamar:id,nomor_kamar', 
                'pembayaran' => fn($q) => $q->select('id','penyewaan_id','jumlah','tanggal')
                    ->latest()
                    ->take(10) // Batasi riwayat yang diambil
            ])
            ->where('status', 'aktif')
            ->first(['id', 'kamar_id', 'tanggal_mulai', 'status']);
    });

    // Fallback jika tidak ada penyewaan aktif
    if(!$penyewaanAktif) {
        return view('user.dashboard', [
            'penyewaanAktif' => null,
            'riwayatPembayaran' => collect()
        ]);
    }

    return view('user.dashboard', [
        'penyewaanAktif' => $penyewaanAktif,
        'riwayatPembayaran' => $penyewaanAktif->pembayaran
    ]);
}
}