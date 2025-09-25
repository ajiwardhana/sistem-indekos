{{-- resources/views/admin/kamars/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4">Tambah Kamar</h1>
    <hr>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.kamars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nomor Kamar --}}
                <div class="mb-3">
                    <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
                    <input type="text" name="nomor_kamar" id="nomor_kamar" 
                           value="{{ old('nomor_kamar') }}" 
                           class="form-control @error('nomor_kamar') is-invalid @enderror" required>
                    @error('nomor_kamar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" name="harga" id="harga" 
                           value="{{ old('harga') }}" 
                           class="form-control @error('harga') is-invalid @enderror" required>
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="terisi" {{ old('status') == 'terisi' ? 'selected' : '' }}>Terisi</option>
                        <option value="perbaikan" {{ old('status') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                    </select>
                </div>

                {{-- Fasilitas --}}
                <div class="mb-3">
                    <label for="fasilitas" class="form-label">Fasilitas</label>
                    <input type="text" name="fasilitas" id="fasilitas" 
                           value="{{ old('fasilitas') }}" class="form-control">
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control">{{ old('deskripsi') }}</textarea>
                </div>

                {{-- Upload Foto --}}
                <div class="mb-3">
                    <label>Foto Kamar (bisa lebih dari 1)</label>
                    <input type="file" name="fotos[]" class="form-control" multiple id="fotoInput">

                    {{-- Preview carousel --}}
                    <div id="previewCarousel" class="carousel slide mt-3" data-bs-ride="carousel" style="display:none;">
                        <div class="carousel-inner" id="carouselInner"></div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#previewCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#previewCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('admin.kamars.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Batal</a>

                @error('nomor_kamar')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

            </form>
        </div>
    </div>
</div>

{{-- Script preview --}}
<script>
document.getElementById('fotoInput').addEventListener('change', function(event){
    const files = event.target.files;
    const carouselInner = document.getElementById('carouselInner');
    carouselInner.innerHTML = ''; // reset
    if(files.length === 0){
        document.getElementById('previewCarousel').style.display = 'none';
        return;
    }

    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e){
            const div = document.createElement('div');
            div.classList.add('carousel-item');
            if(index === 0) div.classList.add('active');
            div.innerHTML = `<img src="${e.target.result}" class="d-block w-100" style="height:200px; object-fit:cover;">`;
            carouselInner.appendChild(div);
        }
        reader.readAsDataURL(file);
    });

    document.getElementById('previewCarousel').style.display = 'block';
});
</script>
@endsection
