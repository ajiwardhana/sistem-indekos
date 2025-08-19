@php
    // Set default values untuk menghindari error
    $lastPayment = $lastPayment ?? null;
    $userKamarStatus = $userKamarStatus ?? 'Tidak aktif';
    $currentBill = $currentBill ?? 0;
    $recentPayments = $recentPayments ?? collect([]);
    $rentalHistory = $rentalHistory ?? collect([]);
    
    // Untuk admin
    $totalPendapatanBulanIni = $totalPendapatanBulanIni ?? 0;
    $pembayaranLunasCount = $pembayaranLunasCount ?? 0;
    $pembayaranPendingCount = $pembayaranPendingCount ?? 0;
    $kamarTerisiCount = $kamarTerisiCount ?? 0;
    $totalKamarCount = $totalKamarCount ?? 0;
    $monthlyStats = $monthlyStats ?? collect([]);
@endphp

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="fw-bold">Dashboard</h1>
            <p class="text-muted">Selamat datang kembali, {{ auth()->user()->name }}!</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        @if(auth()->user()->isAdmin())
        <!-- Admin Cards -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pendapatan (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pembayaran Lunas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $pembayaranLunasCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pembayaran Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $pembayaranPendingCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Kamar Terisi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $kamarTerisiCount }}/{{ $totalKamarCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bed fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- User Cards -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pembayaran Terakhir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($lastPayment)
                                    Rp {{ number_format($lastPayment->jumlah, 0, ',', '.') }}
                                @else
                                    Belum ada
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Status Kamar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $userKamarStatus ?? '-' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-door-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tagihan Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($currentBill)
                                    Rp {{ number_format($currentBill, 0, ',', '.') }}
                                @else
                                    Tidak ada tagihan
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Recent Activity Section -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Pembayaran Terakhir</h6>
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPayments as $payment)
                                <tr>
                                    <td>{{ $payment->tanggal_pembayaran->format('d M Y') }}</td>
                                    <td>Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge badge-{{ 
                                            $payment->status === 'lunas' ? 'success' : 
                                            ($payment->status === 'pending' ? 'warning' : 'danger') 
                                        }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada pembayaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Tahunan</h6>
                </div>
                <div class="card-body">
                    <canvas id="yearlyStatsChart" height="200"></canvas>
                </div>
            </div>
        </div>
        @else
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Penyewaan</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($rentalHistory as $history)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Kamar {{ $history->kamar_id }}</strong>
                                <div class="text-muted small">
                                    {{ $history->tanggal_mulai->format('M Y') }} - 
                                    {{ $history->tanggal_selesai ? $history->tanggal_selesai->format('M Y') : 'Sekarang' }}
                                </div>
                            </div>
                            <span class="badge badge-{{ $history->status === 'aktif' ? 'success' : 'secondary' }}">
                                {{ ucfirst($history->status) }}
                            </span>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted">Belum ada riwayat</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
@if(auth()->user()->isAdmin())
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('yearlyStatsChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($monthlyStats->pluck('month')),
                datasets: [{
                    label: 'Pendapatan',
                    data: @json($monthlyStats->pluck('total')),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endif
@endpush