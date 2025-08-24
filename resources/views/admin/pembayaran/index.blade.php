@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Pembayaran</h1>

    @if (session('success'))
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
                            <th>#</th>
                            <th>Penyewa</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pembayarans as $pembayaran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pembayaran->penyewa->user->name ?? '-' }}</td>
                            <td>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $pembayaran->tanggal_pembayaran->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $pembayaran->metode_pembayaran === 'transfer' ? 'info' : 'success' }}">
                                    {{ Str::ucfirst($pembayaran->metode_pembayaran) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ 
                                    $pembayaran->status === 'lunas' ? 'success' : 
                                    ($pembayaran->status === 'pending' ? 'warning' : 'danger') 
                                }}">
                                    {{ Str::ucfirst($pembayaran->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('pembayaran.show', $pembayaran->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('update', $pembayaran)
                                <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pembayaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(auth()->user()->isAdmin())
                <div class="mt-3">
                    <h4>Statistik Pembayaran</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5>Total Bulan Ini</h5>
                                    <h3>Rp {{ number_format(
                                        App\Models\Pembayaran::whereMonth('tanggal_pembayaran', now()->month)
                                            ->whereYear('tanggal_pembayaran', now()->year)
                                            ->sum('jumlah'), 0, ',', '.') 
                                    }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection