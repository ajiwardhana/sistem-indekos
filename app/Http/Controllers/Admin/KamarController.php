<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\KamarFoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index(Request $request)
{
    $query = Kamar::with('penyewa.user');

    // 🔍 Pencarian
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('nomor_kamar', 'like', "%$search%")
              ->orWhereHas('penyewa.user', function($q) use ($search) {
                  $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
              });
    }

    // ↕️ Sortir
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'nama_asc':
                $query->orderBy('nomor_kamar', 'asc');
                break;
            case 'nama_desc':
                $query->orderBy('nomor_kamar', 'desc');
                break;
            case 'harga_asc':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_desc':
                $query->orderBy('harga', 'desc');
                break;
            case 'status':
                $query->orderBy('status', 'asc');
                break;
            default:
                $query->orderBy('nomor_kamar', 'asc'); // default
        }
    } else {
        $query->orderBy('nomor_kamar', 'asc');
    }

    $kamars = $query->get();

    return view('admin.kamars.index', compact('kamars'));
}


    public function create()
    {
        return view('admin.kamars.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nomor_kamar' => 'required|string|max:50|unique:kamars,nomor_kamar',
        'harga' => 'required|numeric|min:0',
        'status' => 'required|string',
        'fasilitas' => 'nullable|string',
        'deskripsi' => 'nullable|string',
    ], [
        'nomor_kamar.unique' => 'Nomor kamar ini sudah digunakan, silakan pilih nomor lain.',
    ]);

    $kamar = Kamar::create($request->only('nomor_kamar','harga','status','fasilitas','deskripsi'));

    // Upload foto
    if($request->hasFile('fotos')) {
        foreach($request->file('fotos') as $file){
            $path = $file->store('kamar_fotos','public');
            \App\Models\KamarFoto::create(['kamar_id'=>$kamar->id,'foto'=>$path]);
        }
    }

    return redirect()->route('admin.kamars.index')->with('success','Kamar berhasil ditambahkan');
}

    public function show($id)
    {
        $kamar = Kamar::with(['penyewa.user'])->findOrFail($id);
        return view('admin.kamars.show', compact('kamar'));
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);
        return view('admin.kamars.edit', compact('kamar'));
    }

    // Update Kamar
public function update(Request $request, Kamar $kamar)
{
    $request->validate([
        'nomor_kamar' => 'required|string|max:50|unique:kamars,nomor_kamar,' . $kamar->id,
        'harga' => 'required|numeric|min:0',
        'status' => 'required|string',
        'fasilitas' => 'nullable|string',
        'deskripsi' => 'nullable|string',
    ], [
        'nomor_kamar.unique' => 'Nomor kamar ini sudah digunakan oleh kamar lain.',
    ]);

    $kamar->update($request->only('nomor_kamar','harga','status','fasilitas','deskripsi'));

    if($request->hasFile('fotos')) {
        foreach($request->file('fotos') as $file){
            $path = $file->store('kamar_fotos','public');
            \App\Models\KamarFoto::create(['kamar_id'=>$kamar->id,'foto'=>$path]);
        }
    }

    return redirect()->route('admin.kamars.index')->with('success','Kamar berhasil diupdate');
}


public function batalkan($id)
{
    $kamar = Kamar::with('penyewa')->findOrFail($id);

    if ($kamar->penyewa) {
        $penyewa = $kamar->penyewa;

        // Hapus relasi kamar dari penyewa
        $penyewa->update([
            'kamar_id' => null,
            'tanggal_keluar' => now(),
        ]);

        $kamar->update(['status' => 'tersedia']);

        return redirect()->route('admin.kamars.index')->with('success', 'Penyewaan dibatalkan!');
    }

    return redirect()->route('admin.kamars.index')->with('error', 'Kamar ini tidak sedang disewa.');
}
    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();

        return redirect()->route('admin.kamars.index')
                         ->with('success', 'Kamar berhasil dihapus!');
    }

    // Hapus foto
public function destroyFoto($kamarId, $fotoId)
{
    $kamar = Kamar::findOrFail($kamarId);
    $foto = $kamar->fotos()->findOrFail($fotoId);

    // Hapus file fisik
    if (Storage::disk('public')->exists($foto->foto)) {
        Storage::disk('public')->delete($foto->foto);
    }

    // Hapus record di database
    $foto->delete();

    return redirect()->back()->with('success', 'Foto kamar berhasil dihapus.');
}


}
