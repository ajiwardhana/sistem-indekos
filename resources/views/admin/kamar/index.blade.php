@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Kamar</h1>
        <a href="{{ route('kamar.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Kamar
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
                            <th>Nomor Kamar</th>
                            <th>Harga</th>
                            <th>Fasilitas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kamars as $kamar)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kamar->nomor_kamar }}</td>
                            <td>Rp {{ number_format($kamar->harga, 0, ',', '.') }}</td>
                            <td>{{ $kamar->fasilitas ?? '-' }}</td>
                            <td>
                                @if($kamar->status == 'tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @elseif($kamar->status == 'terisi')
                                    <span class="badge bg-primary">Terisi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Perbaikan</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('kamar.edit', $kamar->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data kamar</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $kamars->links() }}
        </div>
    </div>
</div>
@endsection