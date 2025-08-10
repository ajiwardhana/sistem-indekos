@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Pembayaran</h1>
        <a href="{{ route('pembayaran.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pembayaran
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Penyewa</th>
                            <th>Bulan</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Metode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayarans as $pembayaran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pembayaran->penyewa->nama }}</td>
                            <td>{{ \Carbon\Carbon::parse($pembayaran->bulan)->translatedFormat('F Y') }}</td>
                            <td>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $pembayaran->tanggal->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($pembayaran->metode_pembayaran) }}</td>
                            <td>
                                <a href="{{ route('pembayaran.show', $pembayaran->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('pembayaran.cetak', $pembayaran->id) }}" class="btn btn-sm btn-success" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pembayaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $pembayarans->links() }}
        </div>
    </div>
</div>
@endsection