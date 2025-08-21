@php
    // Default values untuk semua variable
    $lastPayment = $lastPayment ?? null;
    $userKamarStatus = $userKamarStatus ?? 'Tidak aktif';
    $currentBill = $currentBill ?? 0;
    $recentPayments = $recentPayments ?? collect();
    $rentalHistory = $rentalHistory ?? collect();
@endphp

@extends('layouts.app')

@section('title', 'Dashboard User - Sistem Indekos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title"><i class="bi bi-speedometer2 me-2"></i>Dashboard User</h2>
    </div>

    <!-- Stats Cards untuk User -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="stats-card primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Status Kamar</h5>
                        <h4>{{ $userKamarStatus }}</h4>
                    </div>
                    <i class="bi bi-door-closed fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Tagihan Bulan Ini</h5>
                        <h4>Rp {{ number_format($currentBill, 0, ',', '.') }}</h4>
                    </div>
                    <i class="bi bi-currency-dollar fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="stats-card info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Pembayaran Terakhir</h5>
                        <h4>
                            @if($lastPayment)
                                Rp {{ number_format($lastPayment->jumlah, 0, ',', '.') }}
                            @else
                                Belum ada
                            @endif
                        </h4>
                    </div>
                    <i class="bi bi-clock-history fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat dan Pembayaran -->
    <div class="row">
        <div class="col-lg-6">
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
                                        <h6 class="mb-1">Pembayaran #{{ $payment->id }}</h6>
                                        <span class="badge bg-{{ $payment->status == 'lunas' ? 'success' : 'warning' }}">
                                            {{ $payment->status }}
                                        </span>
                                    </div>
                                    <p class="mb-1">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</p>
                                    <small class="text-muted">{{ $payment->created_at->format('d M Y H:i') }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Belum ada riwayat pembayaran</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Riwayat Penyewaan</h5>
                </div>
                <div class="card-body">
                    @if($rentalHistory->count() > 0)
                        <div class="list-group">
                            @foreach($rentalHistory as $rental)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">Kamar {{ $rental->kamar->nomor_kamar }}</h6>
                                        <span class="badge bg-{{ $rental->status == 'aktif' ? 'success' : 'secondary' }}">
                                            {{ $rental->status }}
                                        </span>
                                    </div>
                                    <p class="mb-1">{{ $rental->kamar->kost->nama_kost }}</p>
                                    <small class="text-muted">
                                        {{ $rental->tanggal_mulai->format('d M Y') }} - 
                                        {{ $rental->tanggal_selesai ? $rental->tanggal_selesai->format('d M Y') : 'Sekarang' }}
                                    </small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Belum ada riwayat penyewaan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection