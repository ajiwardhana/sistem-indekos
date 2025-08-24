<!-- @php
    // Default values untuk semua variable yang mungkin digunakan
    $totalPendapatanBulanIni = $totalPendapatanBulanIni ?? 0;
    $pembayaranLunasCount = $pembayaranLunasCount ?? 0;
    $pembayaranPendingCount = $pembayaranPendingCount ?? 0;
    $totalKamarCount = $totalKamarCount ?? 0;
    $kamarTersedia = $kamarTersedia ?? 0;           // TAMBAHKAN INI
    $kamarTerisi = $kamarTerisi ?? 0;               // TAMBAHKAN INI
    $kamarMaintenance = $kamarMaintenance ?? 0;     // TAMBAHKAN INI
    $totalKostCount = $totalKostCount ?? 0;
    $monthlyStats = $monthlyStats ?? collect();
    $recentPayments = $recentPayments ?? collect();
@endphp -->

@extends('layouts.app')

@section('title', 'Dashboard - Sikosan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Total Kamar</h5>
                        <h2>{{ $totalKamarCount }}</h2>
                    </div>
                    <i class="bi bi-door-closed fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Tersedia</h5>
                        <h2>{{ $kamarTersedia }}</h2>
                    </div>
                    <i class="bi bi-check-circle fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Terisi</h5>
                        <h2>{{ $kamarTerisi }}</h2>
                    </div>
                    <i class="bi bi-x-circle fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Maintenance</h5>
                        <h2>{{ $kamarMaintenance }}</h2>
                    </div>
                    <i class="bi bi-tools fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Additional Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Total Kost</h5>
                        <h2>{{ $totalKostCount }}</h2>
                    </div>
                    <i class="bi bi-building fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card secondary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Pendapatan Bulan Ini</h5>
                        <h2>Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}</h2>
                    </div>
                    <i class="bi bi-currency-dollar fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Pembayaran Lunas</h5>
                        <h2>{{ $pembayaranLunasCount }}</h2>
                    </div>
                    <i class="bi bi-check-circle fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Pembayaran Pending</h5>
                        <h2>{{ $pembayaranPendingCount }}</h2>
                    </div>
                    <i class="bi bi-clock fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Payments -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Statistik Pendapatan Bulanan</h5>
                </div>
                <div class="card-body">
                    @if($monthlyStats->count() > 0)
                        <canvas id="revenueChart" height="300"></canvas>
                    @else
                        <p class="text-muted text-center py-4">Tidak ada data pendapatan</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Pembayaran Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($recentPayments->count() > 0)
                        <div class="list-group">
                            @foreach($recentPayments as $payment)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">{{ $payment->penyewaan->user->name ?? 'N/A' }}</h6>
                                        <small class="text-success">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</small>
                                    </div>
                                    <small class="text-muted">{{ $payment->created_at->format('d M Y') }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Tidak ada data pembayaran</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if($monthlyStats->count() > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('revenueChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthlyStats->pluck('month')) !!},
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: {!! json_encode($monthlyStats->pluck('total')) !!},
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
                                    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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