<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::all();
        return view('admin.kamars.index', compact('kamars'));
    }

    public function create()
    {
        return view('admin.kamar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|unique:kamars,nomor_kamar',
            'tipe' => 'required|in:standar,vip,vvip',
            'harga' => 'required|numeric',
            'status' => 'required|in:tersedia,terisi,perbaikan',
        ]);

        Kamar::create($request->all());

        return redirect()->route('admin.kamars.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function show($id)
{
    $kamar = Kamar::with(['penyewa.user'])->findOrFail($id);
    return view('admin.kamars.show', compact('kamar'));
}

    // Tambah edit(), update(), destroy() nanti bisa lanjut
}
