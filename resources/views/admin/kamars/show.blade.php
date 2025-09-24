@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Detail Kamar {{ $kamar->nomor_kamar }}</h3>
                    <a href="{{ route('admin.kamars.index') }}" class="btn btn-secondary">Kembali ke Daftar Kamar</a>
                </div>
                <div class="card-body">
                    <!-- Debug Info -->
                    <!-- Status: {{ $kamar->status }} -->
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Informasi Kamar</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <th width="40%">Nomor Kamar</th>
                                            <td>{{ $kamar->nomor_kamar }}</td>
                                        </tr>
                                        <tr>
                                            <th>Harga per Bulan</th>
                                            <td>Rp {{ number_format($kamar->harga, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @php
                                                    $statusClass = [
                                                        'tersedia' => 'success',
                                                        'terisi' => 'warning', 
                                                        'perbaikan' => 'danger'
                                                    ][$kamar->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}">
                                                    {{ ucfirst($kamar->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Fasilitas</th>
                                            <td>{{ $kamar->fasilitas ?? 'Standard' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            @if($kamar->penyewa)
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Informasi Penyewa</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <th width="40%">Nama Penyewa</th>
                                            <td>{{ $kamar->penyewa->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $kamar->penyewa->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Masuk</th>
                                            <td>
                                                @if($kamar->penyewa->tanggal_masuk)
                                                    {{ \Carbon\Carbon::parse($kamar->penyewa->tanggal_masuk)->format('d M Y') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Keluar</th>
                                            <td>
                                                @if($kamar->penyewa->tanggal_keluar)
                                                    {{ \Carbon\Carbon::parse($kamar->penyewa->tanggal_keluar)->format('d M Y') }}
                                                @else
                                                    <span class="text-muted">Masih Menyewa</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Durasi Sewa</th>
                                            <td>
                                                @if($kamar->penyewa->tanggal_masuk)
                                                    @php
                                                        $tanggalMasuk = \Carbon\Carbon::parse($kamar->penyewa->tanggal_masuk);
                                                        $tanggalKeluar = $kamar->penyewa->tanggal_keluar 
                                                            ? \Carbon\Carbon::parse($kamar->penyewa->tanggal_keluar) 
                                                            : now();
                                                        $durasiBulan = $tanggalMasuk->diffInMonths($tanggalKeluar);
                                                    @endphp
                                                    
                                                    <strong>{{ $durasiBulan }} bulan</strong>
                                                    @if(!$kamar->penyewa->tanggal_keluar)
                                                        <span class="text-success">(sedang berjalan)</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            @else
                            <div class="card">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0">Status Penyewa</h5>
                                </div>
                                <div class="card-body text-center">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle fa-2x mb-3"></i>
                                        <h6>Kamar Tersedia</h6>
                                        <p>Kamar ini belum memiliki penyewa.</p>
                                        <a href="{{ route('admin.penyewa.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Tambah Penyewa
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection