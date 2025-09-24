@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Pembayaran Saya</h2>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Kamar</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Bukti</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayarans as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
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
                            <a href="{{ asset('storage/' . $p->bukti) }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($p->status == 'pending')
                            <form action="{{ route('penyewa.pembayarans.uploadBukti', $p->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-2">
                                    <input type="file" name="bukti" class="form-control form-control-sm" required>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Upload Bukti</button>
                            </form>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada pembayaran</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
