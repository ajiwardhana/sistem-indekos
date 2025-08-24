@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Detail Penyewaan</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Informasi Kamar</h5>
                    <hr>
                    <p><strong>Nomor Kamar:</strong> {{ $penyewa->kamar->nomor_kamar }}</p>
                    <p><strong>Tipe Kamar:</strong> {{ $penyewa->kamar->tipe }}</p>
                    <p><strong>Harga per Bulan:</strong> Rp {{ number_format($penyewa->kamar->harga, 0, ',', '.') }}</p>
                    <p><strong>Fasilitas:</strong> {{ $penyewa->kamar->fasilitas }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Detail Penyewaan</h5>
                    <hr>
                    <p><strong>Penyewa:</strong> {{ $penyewa->user->name }}</p>
                    <p><strong>Tanggal Mulai:</strong> {{ $penyewa->tanggal_mulai->format('d M Y') }}</p>
                    <p><strong>Tanggal Selesai:</strong> {{ $penyewa->tanggal_selesai ? $penyewa->tanggal_selesai->format('d M Y') : '-' }}</p>
                    <p><strong>Durasi:</strong> {{ $penyewa->tanggal_mulai->diffInMonths($penyewa->tanggal_selesai) }} bulan</p>
                    <p><strong>Total Pembayaran:</strong> Rp {{ number_format($penyewa->total_pembayaran, 0, ',', '.') }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge 
                            @if($penyewa->status == 'aktif') badge-success
                            @elseif($penyewa->status == 'selesai') badge-secondary
                            @else badge-danger
                            @endif">
                            {{ ucfirst($penyewa->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('penyewa.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        
        @if($penyewa->status == 'aktif')
            <div>
                <a href="{{ route('penyewa.edit', $penyewa->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('pembayaran.create') }}?penyewa_id={{ $penyewa->id }}" class="btn btn-success">
                    <i class="fas fa-money-bill-wave"></i> Buat Pembayaran
                </a>
            </div>
        @endif
    </div>

    @if($penyewa->pembayarans->count() > 0)
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penyewa->pembayarans as $pembayaran)
                            <tr>
                                <td>{{ $pembayaran->tanggal_pembayaran->format('d M Y') }}</td>
                                <td>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($pembayaran->metode_pembayaran) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($pembayaran->status == 'lunas') badge-success
                                        @elseif($pembayaran->status == 'pending') badge-warning
                                        @else badge-danger
                                        @endif">
                                        {{ ucfirst($pembayaran->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('pembayaran.show', $pembayaran->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection