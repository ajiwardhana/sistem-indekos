<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
 * Display a listing of the resource.
 */
public function index()
{
    // Ganti all() dengan paginate()
    $kamar = Kamar::paginate(10); // 10 item per halaman
    
    $totalKamar = Kamar::count();
    $tersedia = Kamar::where('status', 'tersedia')->count();
    $terisi = Kamar::where('status', 'terisi')->count();
    $maintenance = Kamar::where('status', 'perbaikan')->count();

    return view('admin.kamar.index', compact(
        'kamar', 
        'totalKamar', 
        'tersedia', 
        'terisi', 
        'maintenance'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kamar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'nomor_kamar' => 'required|unique:kamar|max:10',
        'tipe' => 'required|in:standar,vip,vvip', // ✅ Tambahkan validasi tipe
        'harga' => 'required|numeric',
        'fasilitas' => 'nullable|string',
        'status' => 'required|in:tersedia,terisi,perbaikan',
        'foto' => 'nullable|image|max:2048', // ✅ Tambahkan validasi foto
    ]);

    // Handle file upload
    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('kamar', 'public');
    }

    Kamar::create($validated);

    return redirect()->route('admin.kamar.index')
        ->with('success', 'Kamar berhasil ditambahkan');
}

    /**
     * Display the specified resource.
     */
    public function show(Kamar $kamar)
    {
        return view('admin.kamar.show', compact('kamar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kamar $kamar)
    {
        return view('admin.kamar.edit', compact('kamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kamar $kamar)
    {
        $validated = $request->validate([
            'nomor_kamar' => 'required|unique:kamar|max:10',
            'tipe' => 'required|in:standar,vip,vvip', // ✅ Tambahkan validasi tipe
            'harga' => 'required|numeric',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:tersedia,terisi,perbaikan',
            'foto' => 'nullable|image|max:2048', // ✅ Tambahkan validasi foto
        ]);

        $kamar->update($validated);

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Data kamar berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kamar $kamar)
    {
        $kamar->delete();

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil dihapus');
    }
}