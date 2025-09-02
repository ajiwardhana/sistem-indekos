@extends('layouts.app')

@section('title', 'Pembayaran - Sikosan')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-money-bill-wave text-primary"></i> Pembayaran
        </h1>
    </div>

    <!-- Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-1"></i> Tagihan Pembayaran
                    </h6>
                </div>
                <div class="card-body">
                    @if($penyewaan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Kamar</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Durasi</th>
                                    <th>Total Tagihan</th>
                                    <th>Status</th>
                                    <th>Batas Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penyewaan as $penyewaan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>Kamar {{ $penyewaan->kamar->nomor_kamar }}</strong>
                                        <br>
                                        <small class="text-muted">Tipe: {{ ucfirst($penyewaan->kamar->tipe) }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($penyewaan->tanggal_mulai)->format('d M Y') }}</td>
                                    <td>{{ $penyewaan->durasi }} Bulan</td>
                                    <td class="font-weight-bold text-primary">
                                        Rp {{ number_format($penyewaan->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock me-1"></i> Menunggu Pembayaran
                                        </span>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($penyewaan->created_at)->addDays(2)->format('d M Y H:i') }}
                                        <br>
                                        <small class="text-muted">(2 hari setelah pemesanan)</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" 
                                                    data-target="#detailModal{{ $penyewaan->id }}">
                                                <i class="fas fa-eye"></i> Detail
                                            </button>
                                            
                                            <a href="{{ route('user.pembayaran.create', $penyewaan->id) }}" 
                                        class="btn btn-success btn-sm">
                                            <i class="fas fa-money-bill-wave"></i> Bayar
                                        </a>
                                                                                </div>
                                    </td>
                                </tr>

                                <!-- Modal Detail -->
                                <div class="modal fade" id="detailModal{{ $penyewaan->id }}" tabindex="-1" role="dialog" 
                                     aria-labelledby="detailModalLabel{{ $penyewaan->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $penyewaan->id }}">
                                                    <i class="fas fa-info-circle me-1"></i> Detail Tagihan
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="card mb-3">
                                                            <div class="card-header bg-light">
                                                                <h6 class="m-0 font-weight-bold">Informasi Kamar</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <p><strong>Nomor Kamar:</strong> {{ $penyewaan->kamar->nomor_kamar }}</p>
                                                                <p><strong>Tipe:</strong> {{ ucfirst($penyewaan->kamar->tipe) }}</p>
                                                                <p><strong>Harga per Bulan:</strong> Rp {{ number_format($penyewaan->kamar->harga, 0, ',', '.') }}</p>
                                                                <p><strong>Fasilitas:</strong> {{ $penyewaan->kamar->fasilitas ?? 'Standard' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card mb-3">
                                                            <div class="card-header bg-light">
                                                                <h6 class="m-0 font-weight-bold">Detail Tagihan</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <p><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($penyewaan->tanggal_mulai)->format('d M Y') }}</p>
                                                                <p><strong>Durasi:</strong> {{ $penyewaan->durasi }} Bulan</p>
                                                                <p><strong>Total Tagihan:</strong> Rp {{ number_format($penyewaan->total_harga, 0, ',', '.') }}</p>
                                                                <p><strong>Status:</strong> 
                                                                    <span class="badge badge-warning">Menunggu Pembayaran</span>
                                                                </p>
                                                                <p><strong>Batas Pembayaran:</strong> 
                                                                    {{ \Carbon\Carbon::parse($penyewaan->created_at)->addDays(2)->format('d M Y H:i') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i> Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-money-bill-wave fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak Ada Tagihan</h5>
                        <p class="text-muted">Anda tidak memiliki tagihan pembayaran yang tertunda.</p>
                        <a href="{{ route('user.kamar.index') }}" class="btn btn-primary">
                            <i class="fas fa-door-open me-1"></i> Pesan Kamar
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .badge {
        font-size: 0.85em;
        padding: 0.5em 0.8em;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .btn-group .btn {
        margin-right: 5px;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endsection