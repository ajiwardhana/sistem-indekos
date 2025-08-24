<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenyewaanController extends Controller
{
    /**
     * Menyimpan data penyewaan baru
     */
    public function store(Request $request, Kamar $kamar)
    {
        // Validasi
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'durasi' => 'required|integer|min:1'
        ]);

        // Cek apakah kamar masih tersedia
        if ($kamar->status !== 'tersedia') {
            return redirect()->back()
                ->with('error', 'Maaf, kamar ini sudah tidak tersedia.');
        }

        // Hitung tanggal selesai
        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_selesai = date('Y-m-d', strtotime($tanggal_mulai . ' + ' . $request->durasi . ' months'));

        // Buat penyewaan
        $penyewaan = Penyewaan::create([
            'user_id' => Auth::id(),
            'kamar_id' => $kamar->id,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'status' => 'aktif'
        ]);

        // Update status kamar menjadi disewa
        $kamar->update(['status' => 'disewa']);

        return redirect()->route('user.dashboard')
            ->with('success', 'Kamar berhasil disewa! Silakan lakukan pembayaran.');
    }
}