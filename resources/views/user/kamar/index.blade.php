@extends('layouts.app')

@section('title', 'Kamar Tersedia - Sistem Indekos')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-door-open text-primary"></i> Kamar Tersedia
        </h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        @if($kamars->count() > 0)
            @foreach($kamars as $kamar)
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-4">
                                <img src="{{ $kamar->foto ? asset('storage/' . $kamar->foto) : asset('img/default-kamar.jpg') }}" 
                                     class="img-fluid rounded" alt="{{ $kamar->nama_kamar }}" 
                                     style="width: 100%; height: 120px; object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    {{ $kamar->nama_kamar }}
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($kamar->harga, 0, ',', '.') }}/bln
                                </div>
                                <div class="mt-2">
                                    <span class="badge badge-info">
                                        <i class="fas fa-expand-arrows-alt"></i> {{ $kamar->luas }} m²
                                    </span>
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-user"></i> {{ $kamar->kapasitas }} orang
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <p class="text-muted small mb-2">
                                <i class="fas fa-info-circle"></i> {{ Str::limit($kamar->deskripsi, 100) }}
                            </p>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-6">
                                <a href="{{ route('user.kamar.show', $kamar->id) }}" 
                                   class="btn btn-sm btn-outline-primary btn-block">
                                    <i class="fas fa-info-circle"></i> Detail
                                </a>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-sm btn-primary btn-block" 
                                        data-toggle="modal" data-target="#sewaModal{{ $kamar->id }}">
                                    <i class="fas fa-check"></i> Sewa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Sewa -->
            <div class="modal fade" id="sewaModal{{ $kamar->id }}" tabindex="-1" role="dialog" 
                 aria-labelledby="sewaModalLabel{{ $kamar->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="sewaModalLabel{{ $kamar->id }}">
                                Sewa Kamar - {{ $kamar->nama_kamar }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('user.kamar.sewa', $kamar->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="tanggal_mulai{{ $kamar->id }}">Tanggal Mulai Sewa</label>
                                    <input type="date" class="form-control" 
                                           id="tanggal_mulai{{ $kamar->id }}" 
                                           name="tanggal_mulai" 
                                           min="{{ date('Y-m-d') }}" 
                                           required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="durasi{{ $kamar->id }}">Durasi Sewa (bulan)</label>
                                    <select class="form-control" 
                                            id="durasi{{ $kamar->id }}" 
                                            name="durasi" required>
                                        <option value="1">1 Bulan</option>
                                        <option value="3">3 Bulan</option>
                                        <option value="6">6 Bulan</option>
                                        <option value="12">12 Bulan</option>
                                    </select>
                                </div>
                                
                                <div class="alert alert-info">
                                    <strong>Total Pembayaran:</strong>
                                    <span id="total-pembayaran{{ $kamar->id }}">
                                        Rp {{ number_format($kamar->harga, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Konfirmasi Sewa
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-door-closed fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada kamar tersedia</h5>
                    <p class="text-muted">Semua kamar sedang disewa. Silakan coba lagi nanti.</p>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Fungsi untuk menghitung total pembayaran
    function hitungTotal(harga, durasiId, outputId) {
        document.getElementById(durasiId).addEventListener('change', function() {
            const durasi = parseInt(this.value);
            const total = harga * durasi;
            document.getElementById(outputId).textContent = 'Rp ' + total.toLocaleString('id-ID');
        });
    }

    // Inisialisasi untuk setiap modal
    @foreach($kamars as $kamar)
    hitungTotal({{ $kamar->harga }}, 'durasi{{ $kamar->id }}', 'total-pembayaran{{ $kamar->id }}');
    @endforeach
</script>

<!-- Bootstrap Modal JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
@endsection

@section('styles')
<style>
    .card {
        transition: transform 0.2s ease-in-out;
        border-radius: 10px;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .badge {
        font-size: 0.7rem;
        padding: 0.3em 0.6em;
    }
</style>
@endsection