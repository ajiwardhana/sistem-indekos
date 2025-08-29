@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
<div class="container-fluid">
    
 <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-door-open text-primary"></i> Dashboard User
        </h1>
    </div>
            <!-- Status Kamar -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Status Kamar</h5>
                        </div>
                        <div class="card-body">
                            @if($penyewaan_aktif)
                                <p class="card-text">
                                    <strong>Kamar:</strong> No. {{ $penyewaan_aktif->nomor_kamar }}<br>
                                    <strong>Status:</strong> 
                                    <span class="badge bg-success">Aktif</span><br>
                                    <strong>Tanggal Mulai:</strong> 
                                    {{ \Carbon\Carbon::parse($penyewaan_aktif->tanggal_mulai)->format('d M Y') }}<br>
                                    <strong>Tanggal Selesai:</strong> 
                                    {{ \Carbon\Carbon::parse($penyewaan_aktif->tanggal_selesai)->format('d M Y') }}
                                </p>
                            @else
                                <p class="card-text">
                                    <strong>Status Kamar:</strong> 
                                    <span class="badge bg-secondary">Tidak aktif</span>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Tagihan Bulan Ini</h5>
                        </div>
                        <div class="card-body">
                            @if($penyewaan_aktif)
                                <h3>Rp {{ number_format($penyewaan_aktif->harga, 0, ',', '.') }}</h3>
                                <p class="text-muted">Jatuh tempo: 
                                    {{ \Carbon\Carbon::parse($penyewaan_aktif->tanggal_mulai)->addMonth()->format('d M Y') }}
                                </p>
                            @else
                                <h3>Rp 0</h3>
                                <p class="text-muted">Belum ada tagihan</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pembayaran Terbaru -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Pembayaran Terbaru</h5>
                        </div>
                        <div class="card-body">
                            @if($pembayaran_terbaru->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Jumlah</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pembayaran_terbaru as $pembayaran)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') }}</td>
                                                    <td>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $pembayaran->status == 'lunas' ? 'success' : 'warning' }}">
                                                            {{ ucfirst($pembayaran->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $pembayaran->keterangan ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Belum ada riwayat pembayaran</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Penyewaan -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Riwayat Penyewaan</h5>
                        </div>
                        <div class="card-body">
                            @if($riwayat_penyewaan->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No. Kamar</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($riwayat_penyewaan as $penyewaan)
                                                <tr>
                                                    <td>{{ $penyewaan->nomor_kamar }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($penyewaan->tanggal_mulai)->format('d M Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($penyewaan->tanggal_selesai)->format('d M Y') }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $penyewaan->status == 'aktif' ? 'success' : 'secondary' }}">
                                                            {{ ucfirst($penyewaan->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Belum ada riwayat penyewaan</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection