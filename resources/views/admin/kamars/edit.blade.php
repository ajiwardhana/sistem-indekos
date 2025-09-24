@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Kamar</h1>

    <form action="{{ route('admin.kamars.update', $kamar->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Nomor Kamar</label>
            <input type="text" 
                   name="nomor_kamar" 
                   value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}" 
                   class="form-control" 
                   required>
        </div>

        <div class="form-group mb-3">
            <label>Harga</label>
            <input type="number" 
                   name="harga" 
                   value="{{ old('harga', $kamar->harga) }}" 
                   class="form-control" 
                   required>
        </div>

        <div class="form-group mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="tersedia" {{ $kamar->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="terisi" {{ $kamar->status == 'terisi' ? 'selected' : '' }}>Terisi</option>
                <option value="perbaikan" {{ $kamar->status == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Fasilitas</label>
            <input type="text" 
                   name="fasilitas" 
                   value="{{ old('fasilitas', $kamar->fasilitas) }}" 
                   class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.kamars.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
