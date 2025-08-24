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
    $penyewaAktif = cache()->remember('penyewa_aktif_'.auth()->id(), 3600, function() {
        return auth()->user()->penyewa()
            ->with([
                'kamar:id,nomor_kamar', 
                'pembayaran' => fn($q) => $q->select('id','penyewa_id','jumlah','tanggal')
                    ->latest()
                    ->take(10) // Batasi riwayat yang diambil
            ])
            ->where('status', 'aktif')
            ->first(['id', 'kamar_id', 'tanggal_mulai', 'status']);
    });

    // Fallback jika tidak ada penyewa aktif
    if(!$penyewaAktif) {
        return view('user.dashboard', [
            'penyewaAktif' => null,
            'riwayatPembayaran' => collect()
        ]);
    }

    return view('user.dashboard', [
        'penyewaAktif' => $penyewaAktif,
        'riwayatPembayaran' => $penyewaAktif->pembayaran
    ]);
}
}