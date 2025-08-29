@extends('layouts.app')

@section('title', 'Kamar Tersedia - Sikosan')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-door-open text-primary"></i> Kamar Tersedia
        </h1>
    </div>

    <!-- Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Content Row -->
    <div class="row">
        @isset($kamar)
            @if($kamar->count() > 0)
                @foreach($kamar as $item)
                    @if($item && isset($item->id))
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <img src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('img/default-room.jpg') }}" 
                                         class="img-fluid rounded" alt="Kamar {{ $item->nomor_kamar }}" 
                                         style="height: 200px; width: 100%; object-fit: cover;">
                                </div>
                                
                                <h5 class="card-title text-primary">Kamar {{ $item->nomor_kamar }}</h5>
                                
                                <div class="mb-2">
                                    <span class="text-gray-800 font-weight-bold">Rp {{ number_format($item->harga, 0, ',', '.') }}/bulan</span>
                                </div>
                                
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-door-open"></i> Tipe: {{ ucfirst($item->tipe) }}
                                    </small>
                                </div>
                                
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-bed"></i> Fasilitas: {{ $item->fasilitas ?? 'Kasur, Lemari' }}
                                    </small>
                                </div>
                                
                                <div class="mb-2">
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> {{ ucfirst($item->status) }}
                                    </span>
                                </div>
                                
                                <div class="mt-3">
                                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" 
                                            data-target="#sewaModal{{ $item->id }}">
                                        <i class="fas fa-check me-1"></i> Pesan Kamar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Pesan Kamar -->
                    <div class="modal fade" id="sewaModal{{ $item->id }}" tabindex="-1" role="dialog" 
                         aria-labelledby="sewaModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="sewaModalLabel{{ $item->id }}">
                                        <i class="fas fa-home me-1"></i> Pesan Kamar - {{ $item->nomor_kamar }}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('user.kamar.sewa', $item->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="alert alert-info">
                                            <h6 class="alert-heading">Detail Kamar</h6>
                                            <hr>
                                            <p class="mb-1"><strong>Nomor Kamar:</strong> {{ $item->nomor_kamar }}</p>
                                            <p class="mb-1"><strong>Tipe:</strong> {{ ucfirst($item->tipe) }}</p>
                                            <p class="mb-1"><strong>Harga per Bulan:</strong> Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                            <p class="mb-1"><strong>Fasilitas:</strong> {{ $item->fasilitas ?? 'Kasur, Lemari' }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label for="tanggal_mulai"><i class="fas fa-calendar me-1"></i> Tanggal Mulai Sewa</label>
                                            <input type="date" class="form-control" name="tanggal_mulai" 
                                                   min="{{ date('Y-m-d') }}" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="durasi"><i class="fas fa-clock me-1"></i> Durasi Sewa</label>
                                            <select class="form-control" name="durasi" id="durasi{{ $item->id }}" required>
                                                <option value="1">1 Bulan</option>
                                                <option value="3">3 Bulan</option>
                                                <option value="6">6 Bulan</option>
                                                <option value="12">12 Bulan</option>
                                            </select>
                                        </div>
                                        
                                        <div class="alert alert-warning">
                                            <strong><i class="fas fa-money-bill-wave me-1"></i> Total Pembayaran: </strong>
                                            <span id="total-pembayaran{{ $item->id }}">
                                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                                            </span>
                                            <br>
                                            <small>*Harga sudah termasuk semua fasilitas</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            <i class="fas fa-times me-1"></i> Batal
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check me-1"></i> Konfirmasi Pemesanan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-door-closed fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada kamar tersedia</h5>
                        <p class="text-muted">Semua kamar sedang disewa. Silakan coba lagi nanti.</p>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            @endif
        @else
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                    <h5 class="text-warning">Terjadi Kesalahan</h5>
                    <p class="text-muted">Tidak dapat memuat data kamar. Silakan coba lagi nanti.</p>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        @endisset
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Fungsi untuk menghitung total pembayaran
    @isset($kamar)
        @foreach($kamar as $item)
            @if($item && isset($item->id))
            document.getElementById('durasi{{ $item->id }}').addEventListener('change', function() {
                const harga = {{ $item->harga }};
                const durasi = parseInt(this.value);
                const total = harga * durasi;
                document.getElementById('total-pembayaran{{ $item->id }}').textContent = 
                    'Rp ' + total.toLocaleString('id-ID');
            });
            @endif
        @endforeach
    @endisset
</script>
@endsection