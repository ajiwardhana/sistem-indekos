@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kelola Kamar</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Kamar</th>
                <th>Fasilitas</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Penyewa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kamars as $kamar)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ route('admin.kamars.show', $kamar->id) }}" class="font-weight-bold">
                        {{ $kamar->nomor_kamar }}
                    </a>
                </td>
                <td>{{ ucfirst($kamar->fasilitas) }}</td>
                <td>Rp {{ number_format($kamar->harga, 0, ',', '.') }}</td>
                <td>
                    <span class="badge bg-{{ $kamar->status == 'tersedia' ? 'success' : ($kamar->status == 'terisi' ? 'warning' : 'danger') }}">
                        {{ ucfirst($kamar->status) }}
                    </span>
                </td>
                <td>
                    @if($kamar->penyewa && $kamar->penyewa->user)
                        {{ $kamar->penyewa->user->name }} <br>
                        <small>{{ $kamar->penyewa->user->email }}</small>
                    @else
                        <span class="text-muted">Belum ada penyewa</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.kamars.show', $kamar->id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection