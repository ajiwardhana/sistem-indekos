@extends('layouts.app')

@section('title', 'Detail Kamar - Sistem Indekos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-door-open me-2"></i>Detail Kamar
                    </h6>
                    <a href="{{ route('user.kamar.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ $kamar->foto ? asset('storage/' . $kamar->foto) : asset('images/default-kamar.jpg') }}" 
                                 class="img-fluid rounded" alt="{{ $kamar->nama_kamar }}">
                        </div>
                        <div class="col-md-6">
                            <h3>{{ $kamar->nama_kamar }}</h3>
                            <p class="text-muted">{{ $kamar->deskripsi }}</p>
                            
                            <div class="mb-3">
                                <h4 class="text-primary">Rp {{ number_format($kamar->harga, 0, ',', '.') }}/bulan</h4>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <p><i class="fas fa-expand me-2"></i> Luas: {{ $kamar->luas }} m²</p>
                                </div>
                                <div class="col-6">
                                    <p><i class="fas fa-users me-2"></i> Kapasitas: {{ $kamar->kapasitas }} orang</p>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-calendar me-2"></i>Sewa Kamar</h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('user.kamar.sewa', $kamar->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai Sewa</label>
                                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                                   min="{{ date('Y-m-d') }}" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="durasi">Durasi Sewa (bulan)</label>
                                            <select class="form-control" id="durasi" name="durasi" required>
                                                <option value="1">1 Bulan</option>
                                                <option value="3">3 Bulan</option>
                                                <option value="6">6 Bulan</option>
                                                <option value="12">12 Bulan</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Total Pembayaran</label>
                                            <div class="alert alert-info">
                                                <span id="total-pembayaran">Rp {{ number_format($kamar->harga, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-check me-1"></i> Sewa Sekarang
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Hitung total pembayaran berdasarkan durasi
    document.getElementById('durasi').addEventListener('change', function() {
        const hargaPerBulan = {{ $kamar->harga }};
        const durasi = parseInt(this.value);
        const total = hargaPerBulan * durasi;
        
        document.getElementById('total-pembayaran').textContent = 'Rp ' + total.toLocaleString('id-ID');
    });
</script>
@endsection