@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Pembayaran</h2>

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
            @foreach(\App\Models\Pembayaran::orderBy('created_at','desc')->get() as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->penyewa->user->name ?? '-' }}</td>
                    <td>{{ $p->kamar->nomor_kamar ?? '-' }}</td>
                    <td>Rp {{ number_format($p->jumlah,0,',','.') }}</td>
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
                            <form action="{{ route('admin.pembayaran.konfirmasi', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Konfirmasi</button>
                            </form>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
