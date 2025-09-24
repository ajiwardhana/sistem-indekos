@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pembayaran</h1>
        <a href="{{ route('pembayaran.cetak', $pembayaran->id) }}" class="btn btn-success shadow-sm" target="_blank">
            <i class="fas fa-print"></i> Cetak Bukti
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Nama penyewaan</th>
                            <td>{{ $pembayaran->penyewaan->nama }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Kamar</th>
                            <td>{{ $pembayaran->penyewaan->kamar->nomor_kamar }}</td>
                        </tr>
                        <tr>
                            <th>Bulan Pembayaran</th>
                            <td>{{ \Carbon\Carbon::parse($pembayaran->bulan)->translatedFormat('F Y') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Jumlah</th>
                            <td>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Bayar</th>
                            <td>{{ $pembayaran->tanggal->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Metode Pembayaran</th>
                            <td>{{ ucfirst($pembayaran->metode_pembayaran) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mb-4">
                <h5>Keterangan:</h5>
                <p>{{ $pembayaran->keterangan ?? '-' }}</p>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('pembayaran.destroy', $pembayaran->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection