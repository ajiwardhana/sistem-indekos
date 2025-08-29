<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran;
use App\Models\Penyewaan;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $pembayaran = Pembayaran::with('penyewaan.user')
                ->latest()
                ->get();
        } else {
            $pembayaran = Pembayaran::whereHas('penyewaan', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->latest()
                ->get();
        }
        
        return view('pembayaran.index', compact('pembayaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Logika untuk form create pembayaran
        return view('pembayaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Logika untuk menyimpan pembayaran baru
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran)
    {
        return view('pembayaran.show', compact('pembayaran'));
    }

    /**
     * Approve pembayaran (untuk admin)
     */
    public function approve(Pembayaran $pembayaran)
    {
        $pembayaran->update(['status' => 'lunas']);
        return redirect()->back()->with('success', 'Pembayaran berhasil disetujui');
    }

    /**
     * Reject pembayaran (untuk admin)
     */
    public function reject(Pembayaran $pembayaran)
    {
        $pembayaran->update(['status' => 'ditolak']);
        return redirect()->back()->with('success', 'Pembayaran ditolak');
    }

    public function userIndex()
{
    // Ambil penyewaan user yang sedang login dan status menunggu_pembayaran
    $penyewaan = Penyewaan::with('kamar')
        ->where('user_id', Auth::id())
        ->where('status', 'menunggu_pembayaran')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('user.pembayaran.index', compact('penyewaan'));
}
}