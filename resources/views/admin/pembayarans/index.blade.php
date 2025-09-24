@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Pembayaran</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Penyewa</th>
                <th>Kamar</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Bukti</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayarans as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->penyewa->name ?? '-' }}</td>
                    <td>{{ $p->kamar->nomor_kamar ?? '-' }}</td>
                    <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                    <td>
                        @if($p->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($p->status == 'lunas')
                            <span class="badge bg-success">Lunas</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        @if($p->bukti)
                            <a href="{{ asset('storage/' . $p->bukti) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                        @else
                            <span class="text-muted">Belum Upload</span>
                        @endif
                    </td>
                    <td>
                        @if($p->status == 'pending')
                            <form action="{{ route('admin.pembayarans.konfirmasi', $p->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Konfirmasi</button>
                            </form>
                            <form action="{{ route('admin.pembayarans.tolak', $p->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                            </form>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
