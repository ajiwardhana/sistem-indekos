@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Dashboard -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Penyewa</h1>
        <div class="d-flex">
            <span class="badge bg-primary p-2 me-2">
                <i class="fas fa-calendar me-1"></i> {{ now()->format('d F Y') }}
            </span>
            @if($penyewaanAktif)
            <span class="badge bg-success p-2">
                <i class="fas fa-check-circle me-1"></i> Aktif
            </span>
            @endif
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mb-4">
        <!-- Kamar Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Kamar Anda</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $penyewaanAktif->kamar->nomor_kamar ?? '-' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-door-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pembayaran Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pembayaran Terakhir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($penyewaanAktif && $penyewaanAktif->pembayaran->count() > 0)
                                    Rp {{ number_format($penyewaanAktif->pembayaran->first()->jumlah, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tanggal Mulai Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tanggal Mulai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($penyewaanAktif)
                                    {{ \Carbon\Carbon::parse($penyewaanAktif->tanggal_mulai)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Durasi Sewa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($penyewaanAktif)
                                    {{ \Carbon\Carbon::parse($penyewaanAktif->tanggal_mulai)->diffInMonths(now()) }} Bulan
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Penyewaan Aktif Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-home me-1"></i> Informasi Kamar
                    </h6>
                </div>
                <div class="card-body">
                    @include('partials.penyewaan-aktif', ['penyewaan' => $penyewaanAktif])
                </div>
            </div>
        </div>

        <!-- Riwayat Pembayaran Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-info">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-history me-1"></i> Riwayat Pembayaran
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatPembayaran as $pembayaran)
                                <tr>
                                    <td>{{ $pembayaran->tanggal->format('d M Y') }}</td>
                                    <td class="text-end">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                                    <td><span class="badge bg-success">Lunas</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada riwayat pembayaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body text-center py-5">
                    <h3 class="text-primary mb-3">Selamat datang di Sistem Indekos!</h3>
                    <p class="lead">
                        @if($penyewaanAktif)
                            Anda menyewa kamar {{ $penyewaanAktif->kamar->nomor_kamar }} sejak 
                            {{ \Carbon\Carbon::parse($penyewaanAktif->tanggal_mulai)->format('d F Y') }}
                        @else
                            Anda belum memiliki kamar yang disewa
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 0.5rem;
    }
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
    .table th {
        white-space: nowrap;
    }
</style>

<script>
    // Animasi saat load
    document.addEventListener('DOMContentLoaded', function() {
        $('.card').hide().fadeIn(500);
    });
</script>
@endpush