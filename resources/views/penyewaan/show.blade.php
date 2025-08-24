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
                    <p><strong>Nomor Kamar:</strong> {{ $penyewaan->kamar->nomor_kamar }}</p>
                    <p><strong>Tipe Kamar:</strong> {{ $penyewaan->kamar->tipe }}</p>
                    <p><strong>Harga per Bulan:</strong> Rp {{ number_format($penyewaan->kamar->harga, 0, ',', '.') }}</p>
                    <p><strong>Fasilitas:</strong> {{ $penyewaan->kamar->fasilitas }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Detail Penyewaan</h5>
                    <hr>
                    <p><strong>penyewaan:</strong> {{ $penyewaan->user->name }}</p>
                    <p><strong>Tanggal Mulai:</strong> {{ $penyewaan->tanggal_mulai->format('d M Y') }}</p>
                    <p><strong>Tanggal Selesai:</strong> {{ $penyewaan->tanggal_selesai ? $penyewaan->tanggal_selesai->format('d M Y') : '-' }}</p>
                    <p><strong>Durasi:</strong> {{ $penyewaan->tanggal_mulai->diffInMonths($penyewaan->tanggal_selesai) }} bulan</p>
                    <p><strong>Total Pembayaran:</strong> Rp {{ number_format($penyewaan->total_pembayaran, 0, ',', '.') }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge 
                            @if($penyewaan->status == 'aktif') badge-success
                            @elseif($penyewaan->status == 'selesai') badge-secondary
                            @else badge-danger
                            @endif">
                            {{ ucfirst($penyewaan->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('penyewaan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        
        @if($penyewaan->status == 'aktif')
            <div>
                <a href="{{ route('penyewaan.edit', $penyewaan->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('pembayaran.create') }}?penyewaan_id={{ $penyewaan->id }}" class="btn btn-success">
                    <i class="fas fa-money-bill-wave"></i> Buat Pembayaran
                </a>
            </div>
        @endif
    </div>

    @if($penyewaan->pembayaran->count() > 0)
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
                            @foreach($penyewaan->pembayaran as $pembayaran)
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