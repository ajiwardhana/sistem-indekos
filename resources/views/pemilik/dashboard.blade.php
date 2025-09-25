@extends('layouts.app')

@section('title', 'Dashboard Pemilik')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Pemilik</h1>
    </div>

    <!-- Row Cards -->
    <div class="row">

        <!-- Total Penyewa Aktif -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Penyewa Aktif
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPenyewa }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendapatan Bulan Ini -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pendapatan Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($pendapatanBulanIni,0,',','.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-currency-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kelola Admin -->
        <div class="col-xl-4 col-md-12 mb-4">
            <a href="{{ route('pemilik.admin.index') }}" class="text-decoration-none">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Kelola Admin
                                </div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    Klik untuk menambah atau mengelola admin
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-person-plus-fill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- Daftar Penyewa Aktif -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Penyewa Aktif</h6>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nama Penyewa</th>
                        <th>Email</th>
                        <th>Kamar</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penyewaAktif as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->user->name ?? '-' }}</td>
                            <td>{{ $p->user->email ?? '-' }}</td>
                            <td>{{ $p->kamar->nomor_kamar ?? '-' }}</td>
                            <td>{{ $p->tanggal_masuk->format('d M Y') }}</td>
                            <td>{{ $p->tanggal_keluar->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada penyewa aktif</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
