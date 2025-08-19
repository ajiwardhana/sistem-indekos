@extends('layouts.app')

@section('title', 'Kelola Kamar')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800">Kelola Kamar</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.kamar.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kamar
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kamar</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nomor Kamar</th>
                            <th>Tipe</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Fasilitas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kamar as $kamar)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($kamar->foto)
                                    <img src="{{ asset('storage/' . $kamar->foto) }}" alt="Kamar {{ $kamar->nomor_kamar }}" 
                                         class="img-thumbnail" width="80" height="80">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                         style="width: 80px; height: 80px;">
                                        <i class="fas fa-bed fa-2x"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $kamar->nomor_kamar }}</td>
                            <td>
                                <span class="badge 
                                    @if($kamar->tipe === 'vvip') bg-danger
                                    @elseif($kamar->tipe === 'vip') bg-warning
                                    @else bg-info @endif">
                                    {{ strtoupper($kamar->tipe) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($kamar->harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge 
                                    @if($kamar->status === 'tersedia') bg-success
                                    @elseif($kamar->status === 'terisi') bg-primary
                                    @else bg-warning @endif">
                                    {{ ucfirst($kamar->status) }}
                                </span>
                            </td>
                            <td>{{ Str::limit($kamar->fasilitas, 50) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.kamar.edit', $kamar->id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.kamar.destroy', $kamar->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Hapus kamar ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush