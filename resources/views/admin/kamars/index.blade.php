@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-bed"></i> Kelola Kamar</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kamar</h6>
            <a href="{{ route('admin.kamars.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah Kamar
            </a>
        </div>
        <div class="card-body">

            <!-- Search & Filter -->
            <form method="GET" action="{{ route('admin.kamars.index') }}" class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="form-control" placeholder="Cari kamar / penyewa...">
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="">Urutkan...</option>
                        <option value="nama_asc" {{ request('sort')=='nama_asc' ? 'selected' : '' }}>Nomor Kamar A-Z</option>
                        <option value="nama_desc" {{ request('sort')=='nama_desc' ? 'selected' : '' }}>Nomor Kamar Z-A</option>
                        <option value="harga_asc" {{ request('sort')=='harga_asc' ? 'selected' : '' }}>Harga Termurah</option>
                        <option value="harga_desc" {{ request('sort')=='harga_desc' ? 'selected' : '' }}>Harga Termahal</option>
                        <option value="status" {{ request('sort')=='status' ? 'selected' : '' }}>Status</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nomor Kamar</th>
                            <th>Fasilitas</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Penyewa</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kamars as $kamar)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $kamar->nomor_kamar }}</strong></td>
                            <td>{{ ucfirst($kamar->fasilitas) }}</td>
                            <td>Rp {{ number_format($kamar->harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $kamar->status == 'tersedia' ? 'success' : ($kamar->status == 'terisi' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($kamar->status) }}
                                </span>
                            </td>
                            <td>
                                @if($kamar->penyewa && $kamar->penyewa->user && $kamar->status != 'tersedia')
                                    {{ $kamar->penyewa->user->name }} <br>
                                    <small class="text-muted">{{ $kamar->penyewa->user->email }}</small>
                                @else
                                    <span class="text-muted">Belum ada penyewa</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" 
                                        data-bs-toggle="modal" data-bs-target="#detailModal{{ $kamar->id }}">
                                    <i class="fas fa-eye"></i> Detail
                                </button>

                                <a href="{{ route('admin.kamars.edit', $kamar->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('admin.kamars.destroy', $kamar->id) }}" 
                                    method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Detail Kamar -->
                        <div class="modal fade" id="detailModal{{ $kamar->id }}" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Detail Kamar {{ $kamar->nomor_kamar }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body">
                                @if($kamar->fotos->count() > 0)
                                <div id="carousel{{ $kamar->id }}" class="carousel slide mb-3" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($kamar->fotos as $i => $foto)
                                            <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $foto->foto) }}" 
                                                     class="d-block w-100" style="height:300px; object-fit:cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $kamar->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $kamar->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>
                                @endif
                                <p><strong>Harga:</strong> Rp {{ number_format($kamar->harga, 0, ',', '.') }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($kamar->status) }}</p>
                                <p><strong>Fasilitas:</strong> {{ $kamar->fasilitas }}</p>
                                <p><strong>Deskripsi:</strong></p>
                                <p>{{ $kamar->deskripsi }}</p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            let form = this.closest('form');
            Swal.fire({
                title: 'Yakin?',
                text: "Kamar ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
