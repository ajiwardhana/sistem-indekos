<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard'); // Pastikan view ini ada
    }

    public function Penghuni()
    {
        // ✅ PERBAIKAN: Query untuk mendapatkan semua penghuni aktif
        $penghuni = DB::table('penyewaan')
            ->join('users', 'penyewaan.user_id', '=', 'users.id')
            ->join('kamar', 'penyewaan.kamar_id', '=', 'kamar.id')
            ->where('penyewaan.status', 'aktif')
            ->select(
                'users.id as user_id',
                'users.name',
                'users.email',
                'users.telepon',
                'kamar.nama_kamar',
                'kamar.nomor_kamar',
                'penyewaan.tanggal_mulai',
                'penyewaan.tanggal_selesai',
                'penyewaan.status'
            )
            ->orderBy('penyewaan.tanggal_mulai', 'desc')
            ->get();

        return view('admin.penghuni.index', compact('penghuni'));
    }
}