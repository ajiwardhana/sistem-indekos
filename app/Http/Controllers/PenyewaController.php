<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenyewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyewa = Penyewa::with('kamar')->latest()->paginate(10);
        return view('admin.penyewa.index', compact('penyewa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kamar = Kamar::where('status', 'tersedia')->get();
        return view('penyewa.create', compact('kamar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penyewa',
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'kamar_id' => 'required|exists:kamar,id',
            'tanggal_masuk' => 'required|date',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Upload foto KTP
        if ($request->hasFile('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp-images', 'public');
        }

        // Update status kamar
        Kamar::where('id', $validated['kamar_id'])->update(['status' => 'terisi']);

        Penyewa::create($validated);

        return redirect()->route('penyewa.index')
            ->with('success', 'Data penyewa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penyewa $penyewa)
    {
        return view('penyewa.show', compact('penyewa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penyewa $penyewa)
    {
        $kamar = Kamar::where('status', 'tersedia')
            ->orWhere('id', $penyewa->kamar_id)
            ->get();
            
        return view('penyewa.edit', compact('penyewa', 'kamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penyewa $penyewa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penyewa,email,'.$penyewa->id,
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'kamar_id' => 'required|exists:kamar,id',
            'tanggal_masuk' => 'required|date',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Handle foto KTP update
        if ($request->hasFile('foto_ktp')) {
            // Hapus foto lama jika ada
            if ($penyewa->foto_ktp) {
                Storage::disk('public')->delete($penyewa->foto_ktp);
            }
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp-images', 'public');
        }

        // Update status kamar jika kamar diubah
        if ($penyewa->kamar_id != $validated['kamar_id']) {
            Kamar::where('id', $penyewa->kamar_id)->update(['status' => 'tersedia']);
            Kamar::where('id', $validated['kamar_id'])->update(['status' => 'terisi']);
        }

        $penyewa->update($validated);

        return redirect()->route('penyewa.index')
            ->with('success', 'Data penyewa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penyewa $penyewa)
    {
        // Kembalikan status kamar ke tersedia
        Kamar::where('id', $penyewa->kamar_id)->update(['status' => 'tersedia']);
        
        // Hapus foto KTP jika ada
        if ($penyewa->foto_ktp) {
            Storage::disk('public')->delete($penyewa->foto_ktp);
        }
        
        $penyewa->delete();

        return redirect()->route('penyewa.index')
            ->with('success', 'Data penyewa berhasil dihapus');
    }

    /**
     * Cetak data penyewa
     */
    public function cetak()
    {
        $penyewa = Penyewa::with('kamar')->latest()->get();
        return view('penyewa.cetak', compact('penyewa'));
    }
}