{{-- resources/views/admin/kamars/create.blade.php --}}
@extends('layouts.app')

@section('content')


        {{-- Konten utama --}}

            <h1 class="mt-4">Tambah Kamar</h1>
            <hr>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.kamars.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
                            <input type="text" name="nomor_kamar" id="nomor_kamar" 
                                   value="{{ old('nomor_kamar') }}" 
                                   class="form-control @error('nomor_kamar') is-invalid @enderror" required>
                            @error('nomor_kamar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" name="harga" id="harga" 
                                   value="{{ old('harga') }}" 
                                   class="form-control @error('harga') is-invalid @enderror" required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" 
                                    class="form-select @error('status') is-invalid @enderror" required>
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
                            <input type="text" name="fasilitas" id="fasilitas" 
                                   value="{{ old('fasilitas') }}" 
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control">{{ old('deskripsi') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.kamars.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
