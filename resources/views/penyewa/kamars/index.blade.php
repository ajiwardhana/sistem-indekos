@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Kamar</h1>

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    {{-- 🔎 Filter & Search --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('penyewa.kamars.index') }}" class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="q" value="{{ request('q') }}" 
                           class="form-control" placeholder="Cari kamar...">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">-- Semua Status --</option>
                        <option value="tersedia" {{ request('status')=='tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="disewa" {{ request('status')=='disewa' ? 'selected' : '' }}>Sudah Disewa</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-control">
                        <option value="">-- Urutkan --</option>
                        <option value="harga_asc" {{ request('sort')=='harga_asc' ? 'selected' : '' }}>Harga Termurah</option>
                        <option value="harga_desc" {{ request('sort')=='harga_desc' ? 'selected' : '' }}>Harga Termahal</option>
                        <option value="baru" {{ request('sort')=='baru' ? 'selected' : '' }}>Terbaru</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
                </div>
            </form>
        </div>
    </div>

    {{-- 🔲 Grid Daftar Kamar --}}
    <div class="row">
        @forelse($kamars as $kamar)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-left-primary h-100">
                    @if($kamar->fotos->first())
                        <img src="{{ asset('storage/' . $kamar->fotos->first()->foto) }}" 
                             class="card-img-top" style="height:200px; object-fit:cover; cursor:pointer"
                             data-bs-toggle="modal" data-bs-target="#detailKamarModal{{ $kamar->id }}">
                    @else
                        <img src="https://via.placeholder.com/400x200?text=No+Image" 
                             class="card-img-top" style="height:200px; object-fit:cover;">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Kamar {{ $kamar->nomor_kamar }}</h5>
                        <p class="mb-1"><strong>Harga:</strong> Rp {{ number_format($kamar->harga,0,',','.') }}/bulan</p>
                        <p class="mb-2">
                            <strong>Status:</strong>
                            @if($kamar->penyewa)
                                <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Sudah disewa</span>
                            @else
                                <span class="badge bg-success"><i class="fas fa-check-circle"></i> Tersedia</span>
                            @endif
                        </p>

                        <div class="mt-auto d-flex justify-content-between">
                            @if(!$kamar->penyewa)
                                <a href="{{ route('penyewa.kamars.sewa', $kamar->id) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-hand-pointer"></i> Sewa
                                </a>
                            @endif
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                    data-bs-target="#detailKamarModal{{ $kamar->id }}">
                                <i class="fas fa-eye"></i> Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Detail Kamar --}}
            <div class="modal fade" id="detailKamarModal{{ $kamar->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content shadow-lg">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Detail Kamar {{ $kamar->nomor_kamar }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            @if($kamar->fotos->count())
                                <div id="carouselKamar{{ $kamar->id }}" class="carousel slide mb-3" data-bs-ride="carousel">
                                    <div class="carousel-inner rounded">
                                        @foreach($kamar->fotos as $i => $foto)
                                            <div class="carousel-item {{ $i==0?'active':'' }}">
                                                <img src="{{ asset('storage/' . $foto->foto) }}" 
                                                     class="d-block w-100 rounded" 
                                                     style="height:300px; object-fit:cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselKamar{{ $kamar->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselKamar{{ $kamar->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>
                            @endif
                            <h6><i class="fas fa-cogs"></i> Fasilitas:</h6>
                            <p>{{ $kamar->fasilitas ?? '-' }}</p>
                            <h6><i class="fas fa-align-left"></i> Deskripsi:</h6>
                            <p>{{ $kamar->deskripsi ?? '-' }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Tutup
                            </button>
                            @if(!$kamar->penyewa)
                                <a href="{{ route('penyewa.kamars.sewa', $kamar->id) }}" class="btn btn-primary">
                                    <i class="fas fa-handshake"></i> Sewa Kamar
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">Tidak ada kamar ditemukan.</div>
            </div>
        @endforelse
    </div>

    {{-- 📄 Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $kamars->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
