<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penyewa;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Hash;

class PemilikController extends Controller
{
    public function index()
    {
        $totalPenyewa = Penyewa::whereNotNull('kamar_id')->count();

        $pendapatanBulanIni = Pembayaran::whereMonth('created_at', now()->month)
                                        ->where('status', 'lunas')
                                        ->sum('jumlah');

        $penyewaAktif = Penyewa::with('user','kamar')
                               ->whereNotNull('kamar_id')
                               ->get();

        return view('pemilik.dashboard', compact('totalPenyewa','pendapatanBulanIni','penyewaAktif'));
    }

    public function createAdmin()
    {
        return view('pemilik.users.create_admin');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('pemilik.dashboard')->with('success', 'Admin berhasil dibuat!');
    }
}
