@extends('layouts.app')

@section('title', 'Tambah Kamar Baru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Kamar Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kamar.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nomor_kamar" class="form-label">Nomor Kamar *</label>
                            <input type="text" class="form-control @error('nomor_kamar') is-invalid @enderror" 
                                   id="nomor_kamar" name="nomor_kamar" value="{{ old('nomor_kamar') }}" required>
                            @error('nomor_kamar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipe" class="form-label">Tipe Kamar *</label>
                            <select class="form-select @error('tipe') is-invalid @enderror" id="tipe" name="tipe" required>
                                <option value="">Pilih Tipe</option>
                                <option value="standar" {{ old('tipe') == 'standar' ? 'selected' : '' }}>Standar</option>
                                <option value="vip" {{ old('tipe') == 'vip' ? 'selected' : '' }}>VIP</option>
                                <option value="vvip" {{ old('tipe') == 'vvip' ? 'selected' : '' }}>VVIP</option>
                            </select>
                            @error('tipe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga per Bulan (Rp) *</label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                   id="harga" name="harga" value="{{ old('harga') }}" min="0" required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="terisi" {{ old('status') == 'terisi' ? 'selected' : '' }}>Terisi</option>
                                <option value="perbaikan" {{ old('status') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fasilitas" class="form-label">Fasilitas</label>
                            <textarea class="form-control @error('fasilitas') is-invalid @enderror" 
                                      id="fasilitas" name="fasilitas" rows="3">{{ old('fasilitas') }}</textarea>
                            @error('fasilitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Kamar</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                                   id="foto" name="foto" accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.kamars.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Kamar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection