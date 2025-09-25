@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-bed"></i> Edit Kamar</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.kamars.update', $kamar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nomor Kamar, Harga, Status -->
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">Nomor Kamar</label>
                <input type="text" name="nomor_kamar" value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" value="{{ old('harga', $kamar->harga) }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="tersedia" {{ $kamar->status=='tersedia'?'selected':'' }}>Tersedia</option>
                    <option value="terisi" {{ $kamar->status=='terisi'?'selected':'' }}>Terisi</option>
                    <option value="perbaikan" {{ $kamar->status=='perbaikan'?'selected':'' }}>Perbaikan</option>
                    <option value="pending" {{ $kamar->status=='pending'?'selected':'' }}>Pending</option>
                </select>
            </div>
        </div>

        <!-- Fasilitas & Deskripsi -->
        <div class="mb-3">
            <label class="form-label">Fasilitas</label>
            <input type="text" name="fasilitas" value="{{ old('fasilitas', $kamar->fasilitas) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
        </div>

        <!-- Upload Foto Baru -->
        <div class="mb-4">
            <label class="form-label">Upload Foto Baru (bisa lebih dari 1)</label>
            <input type="file" name="fotos[]" class="form-control" multiple id="fotoInput">

            <!-- Preview Carousel -->
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

        <!-- Foto Lama -->
        <div class="mb-4">
            <label class="form-label">Foto Kamar Saat Ini</label>
            <div class="d-flex flex-wrap">
                @foreach($kamar->fotos as $foto)
                    <div class="position-relative m-2" style="width:120px;">
                        <img src="{{ asset('storage/' . $foto->foto) }}" 
                             class="img-thumbnail w-100" style="height:80px; object-fit:cover; cursor:pointer"
                             data-bs-toggle="modal" data-bs-target="#modalFoto{{ $foto->id }}">

                        <form action="{{ route('admin.kamars.foto.destroy', [$kamar->id, $foto->id]) }}" method="POST"
                              style="position:absolute; top:0; right:0;" 
                              onsubmit="return confirm('Yakin ingin menghapus foto ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">&times;</button>
                        </form>
                    </div>

                    <!-- Modal Preview Foto -->
                    <div class="modal fade" id="modalFoto{{ $foto->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <img src="{{ asset('storage/' . $foto->foto) }}" class="d-block w-100" style="height:400px; object-fit:cover;">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Submit -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success flex-grow-1">Update</button>
            <a href="{{ route('admin.kamars.index') }}" class="btn btn-secondary flex-grow-1">Batal</a>
        </div>

        @error('nomor_kamar')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </form>
</div>

@push('scripts')
<script>
document.getElementById('fotoInput').addEventListener('change', function(event){
    const files = event.target.files;
    const carouselInner = document.getElementById('carouselInner');
    carouselInner.innerHTML = '';
    if(files.length === 0){
        document.getElementById('previewCarousel').style.display = 'none';
        return;
    }
    Array.from(files).forEach((file, index)=>{
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
@endpush
@endsection
