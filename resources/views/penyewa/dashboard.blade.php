@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard Penyewa</h1>

    {{-- Sambutan --}}
    <div class="alert alert-primary shadow-sm">
        Halo, <strong>{{ Auth::user()->name }}</strong> 👋 <br>
        Anda login sebagai <strong>Penyewa</strong>.
    </div>

    <div class="row">
        {{-- Info Kamar --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-left-info">
                <div class="card-body">
                    @if($penyewa && $penyewa->status == 'aktif' && $penyewa->kamar)
                        <h5 class="card-title text-info"><i class="fas fa-door-open"></i> Kamar Anda</h5>
                        <p><strong>Nomor:</strong> {{ $penyewa->kamar->nomor_kamar }}</p>
                        <p><strong>Harga:</strong> Rp {{ number_format($penyewa->kamar->harga, 0, ',', '.') }}</p>
                    @else
                        <h5 class="card-title text-warning"><i class="fas fa-exclamation-circle"></i> Belum Ada Kamar</h5>
                        <p>Anda belum menyewa kamar.</p>
                        <a href="{{ route('penyewa.kamars.index') }}" class="btn btn-sm btn-warning">Cari kamar sekarang</a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tagihan Pending --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-left-warning">
                <div class="card-body">
                    @php
                        $pending = ($penyewa && $penyewa->status == 'aktif') ? $penyewa->pembayarans()->where('status','pending')->count() : 0;
                    @endphp
                    <h5 class="card-title text-warning"><i class="fas fa-bell"></i> Tagihan Pending</h5>
                    @if($pending > 0)
                        <p>Anda memiliki <strong>{{ $pending }}</strong> pembayaran pending.</p>
                        <a href="{{ route('penyewa.pembayarans.index') }}" class="btn btn-sm btn-warning">Lihat Pembayaran</a>
                    @else
                        <p class="text-muted">Tidak ada pembayaran pending.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Status Pembayaran Terakhir --}}
    @if($pembayaranTerakhir && $penyewa && $penyewa->status == 'aktif')
        <div class="card shadow-sm border-left-primary mb-4">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-money-check-alt"></i> Status Pembayaran Terakhir</h5>
                @if($pembayaranTerakhir->status == 'pending')
                    <span class="badge bg-warning text-dark">Menunggu konfirmasi admin</span>
                @elseif($pembayaranTerakhir->status == 'lunas')
                    <span class="badge bg-success">LUNAS ✅</span>
                @else
                    <span class="badge bg-danger">DITOLAK ❌</span>
                @endif
            </div>
        </div>
    @endif

    {{-- Menu --}}
    <div class="row">
        <div class="col-md-6 mb-3">
            <a href="{{ route('penyewa.kamars.index') }}" class="card shadow-sm text-decoration-none text-dark h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-bed fa-2x text-primary me-3"></i>
                    <div>
                        <h6 class="mb-0">Cari & Sewa Kamar</h6>
                        <small class="text-muted">Lihat daftar kamar kos</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="{{ route('penyewa.pembayarans.index') }}" class="card shadow-sm text-decoration-none text-dark h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-money-bill fa-2x text-success me-3"></i>
                    <div>
                        <h6 class="mb-0">Riwayat Pembayaran</h6>
                        <small class="text-muted">Cek semua pembayaran Anda</small>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
