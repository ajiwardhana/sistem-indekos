@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Penyewaan</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Kamar</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penyewaan as $index => $penyewaan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $penyewaan->kamar->nomor_kamar }} ({{ $penyewaan->kamar->tipe }})</td>
                            <td>{{ $penyewaan->tanggal_mulai->format('d M Y') }}</td>
                            <td>{{ $penyewaan->tanggal_selesai ? $penyewaan->tanggal_selesai->format('d M Y') : '-' }}</td>
                            <td>Rp {{ number_format($penyewaan->total_pembayaran, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge 
                                    @if($penyewaan->status == 'aktif') badge-success
                                    @elseif($penyewaan->status == 'selesai') badge-secondary
                                    @else badge-danger
                                    @endif">
                                    {{ ucfirst($penyewaan->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('user.penyewaan.show', $penyewaan->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($penyewaan->status == 'aktif')
                                    <a href="{{ route('penyewaan.edit', $penyewaan->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(auth()->user()->ispenghuni())
        <div class="mt-3">
            <a href="{{ route('user.penyewaan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Buat Penyewaan Baru
            </a>
        </div>
    @endif
</div>
@endsection