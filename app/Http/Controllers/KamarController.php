<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    /**
     * Display a listing of the resource for users.
     */
    public function index()
    {
        try {
            $kamar = Kamar::where('status', 'tersedia')->get();
            
            if ($kamar->isEmpty()) {
                return view('user.kamar.index', compact('kamar'))
                    ->with('info', 'Tidak ada kamar tersedia saat ini.');
            }
            
            return view('user.kamar.index', compact('kamar'));
            
        } catch (\Exception $e) {
            return redirect()->route('user.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource for users.
     */
    public function show($id)
    {
        try {
            $kamar = Kamar::where('status', 'tersedia')->find($id);
            
            if (!$kamar) {
                return redirect()->route('user.kamar.index')
                    ->with('error', 'Kamar tidak tersedia atau tidak ditemukan.');
            }
            
            return view('user.kamar.show', compact('kamar'));
            
        } catch (\Exception $e) {
            return redirect()->route('user.kamar.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}