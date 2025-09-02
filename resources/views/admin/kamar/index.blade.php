@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Kamar</span>
                    <a href="{{ route('admin.kamar.create') }}" class="btn btn-primary">Tambah Kamar</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kos</th>
                                    <th>Nomor Kamar</th>
                                    <th>Ukuran</th>
                                    <th>Harga/Bulan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kamars as $kamar)
                                    <tr>
                                        <td>{{ $kamar->kos->nama }}</td>
                                        <td>{{ $kamar->nomor_kamar }}</td>
                                        <td>{{ $kamar->ukuran }}</td>
                                        <td>Rp {{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge {{ $kamar->status == 'tersedia' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $kamar->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.kamar.edit', $kamar->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('admin.kamar.destroy', $kamar->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kamar ini?')">Hapus</button>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection