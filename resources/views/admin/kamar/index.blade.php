@extends('layouts.app')

@section('title', 'Manajemen Kamar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title"><i class="bi bi-door-closed me-2"></i>Manajemen Kamar</h2>
    <a href="{{ route('admin.kamar.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Kamar Baru
    </a>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stats-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Total Kamar</h5>
                    <h2>{{ $totalKamar }}</h2>
                </div>
                <i class="bi bi-door-closed fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stats-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Tersedia</h5>
                    <h2>{{ $tersedia }}</h2>
                </div>
                <i class="bi bi-check-circle fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stats-card danger">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Terisi</h5>
                    <h2>{{ $terisi }}</h2>
                </div>
                <i class="bi bi-x-circle fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stats-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Maintenance</h5>
                    <h2>{{ $maintenance }}</h2>
                </div>
                <i class="bi bi-tools fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<!-- Alert Message -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i> <strong>Berhasil!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Table -->
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nomor Kamar</th>
                <th scope="col">Harga</th>
                <th scope="col">Fasilitas</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kamar as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->nomor_kamar }}</td>
                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td>{{ $item->fasilitas ?? '-' }}</td>
                <td>
                    @if($item->status == 'tersedia')
                        <span class="badge bg-success">Tersedia</span>
                    @elseif($item->status == 'terisi')
                        <span class="badge bg-danger">Terisi</span>
                    @else
                        <span class="badge bg-warning text-dark">Maintenance</span>
                    @endif
                </td>
                <td class="action-buttons">
                    <a href="{{ route('admin.kamar.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('admin.kamar.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                            <i class="bi bi-trash"></i> Hapus
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

<!-- Pagination -->
@if($kamar->hasPages())
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-4">
        {{-- Previous Page Link --}}
        @if($kamar->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Sebelumnya</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $kamar->previousPageUrl() }}">Sebelumnya</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach($kamar->getUrlRange(1, $kamar->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $kamar->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        {{-- Next Page Link --}}
        @if($kamar->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $kamar->nextPageUrl() }}">Selanjutnya</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Selanjutnya</span>
            </li>
        @endif
    </ul>
</nav>
@endif
@endsection