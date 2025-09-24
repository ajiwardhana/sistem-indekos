@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kelola Kamar</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- 🔥 Tambah Kamar -->
    <div class="mb-3 text-end">
        <a href="{{ route('admin.kamars.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kamar
        </a>
    </div>

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
                    @elseif($kamar->status == 'tersedia')
                        <span class="text-muted">Belum ada penyewa</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.kamars.show', $kamar->id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    <a href="{{ route('admin.kamars.edit', $kamar->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.kamars.destroy', $kamar->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus kamar ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
