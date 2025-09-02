<?php

namespace App\Http\Controllers\Penyewa;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KamarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Hanya tampilkan kamar yang tersedia
        $kamars = Kamar::where('status', 'tersedia')->with('kos')->get();
        return view('penyewa.kamar.index', compact('kamars'));
    }

    public function sewa(Kamar $kamar)
    {
        // Pastikan kamar masih tersedia
        if ($kamar->status !== 'tersedia') {
            return redirect()->back()->with('error', 'Kamar sudah tidak tersedia');
        }

        // Cek apakah user sudah menyewa kamar lain
        $existingSewa = Penyewa::where('user_id', Auth::id())->first();
        if ($existingSewa) {
            return redirect()->back()->with('error', 'Anda sudah menyewa kamar');
        }

        return view('penyewa.kamar.sewa', compact('kamar'));
    }

    public function storeSewa(Request $request, Kamar $kamar)
    {
        // Validasi
        $validated = $request->validate([
            'tanggal_mulai' => 'required|date',
            'durasi_sewa' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        // Pastikan kamar masih tersedia
        if ($kamar->status !== 'tersedia') {
            return redirect()->back()->with('error', 'Kamar sudah tidak tersedia');
        }

        // Cek apakah user sudah menyewa kamar lain
        $existingSewa = Penyewa::where('user_id', Auth::id())->first();
        if ($existingSewa) {
            return redirect()->back()->with('error', 'Anda sudah menyewa kamar');
        }

        // Buat penyewa
        Penyewa::create([
            'user_id' => Auth::id(),
            'kamar_id' => $kamar->id,
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'durasi_sewa' => $validated['durasi_sewa'],
            'catatan' => $validated['catatan'],
            'status' => 'aktif',
        ]);

        // Update status kamar
        $kamar->update(['status' => 'terisi']);

        return redirect()->route('penyewa.dashboard')
            ->with('success', 'Kamar berhasil disewa');
    }
}