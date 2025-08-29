@extends('layouts.app')

@section('title', 'Manajemen Penghuni')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Admin -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manajemen Penghuni</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nama Penghuni</th>
                            <th>Kamar</th>
                            <th>Telepon</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penghuni as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div>{{ $p->name }}</div>
                                    <small class="text-muted">{{ $p->email }}</small>
                                </td>
                                <td>
                                    <div>{{ $p->nama_kamar }}</div>
                                    <small class="text-muted">No: {{ $p->nomor_kamar }}</small>
                                </td>
                                <td>{{ $p->telepon ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-success">Aktif</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                                data-bs-target="#detailPenghuni{{ $p->user_id }}">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                        <a href="#" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-2x mb-3"></i>
                                        <h5>Belum ada penghuni yang terdaftar</h5>
                                        <p>Tidak ada penyewaan aktif saat ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
@endsection