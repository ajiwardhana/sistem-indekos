@extends('layouts.app') {{-- PERBAIKI: Ganti admin menjadi app --}}

@section('title', isset($kamar) ? 'Edit Kamar' : 'Tambah Kamar Baru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            @isset($kamar)
                Edit Kamar
            @else
                Tambah Kamar Baru
            @endisset
        </h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            {{-- PERBAIKI: Ganti kamar. menjadi admin.kamar. --}}
            <form action="{{ isset($kamar) ? route('admin.kamar.update', $kamar->id) : route('admin.kamar.store') }}" method="POST">
                @csrf
                @isset($kamar)
                    @method('PUT')
                @endisset

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
                            <input type="text" class="form-control @error('nomor_kamar') is-invalid @enderror" 
                                   id="nomor_kamar" name="nomor_kamar" 
                                   value="{{ old('nomor_kamar', $kamar->nomor_kamar ?? '') }}" required>
                            @error('nomor_kamar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga per Bulan</label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                   id="harga" name="harga" 
                                   value="{{ old('harga', $kamar->harga ?? '') }}" required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="fasilitas" class="form-label">Fasilitas Kamar</label>
                    <textarea class="form-control @error('fasilitas') is-invalid @enderror" 
                              id="fasilitas" name="fasilitas" rows="3">{{ old('fasilitas', $kamar->fasilitas ?? '') }}</textarea>
                    @error('fasilitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Kamar</label>
                    <select class="form-control @error('status') is-invalid @enderror" 
                            id="status" name="status" required>
                        <option value="">Pilih Status</option>
                        <option value="tersedia" @selected(old('status', $kamar->status ?? '') == 'tersedia')>Tersedia</option>
                        <option value="terisi" @selected(old('status', $kamar->status ?? '') == 'terisi')>Terisi</option>
                        <option value="perbaikan" @selected(old('status', $kamar->status ?? '') == 'perbaikan')>Perbaikan</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    @isset($kamar)
                        Update Data
                    @else
                        Tambah Kamar
                    @endisset
                </button>
                {{-- PERBAIKI: Ganti kamar.index menjadi admin.kamar.index --}}
                <a href="{{ route('admin.kamar.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection