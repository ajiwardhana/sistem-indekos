@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="fw-bold">Manajemen Pembayaran</h1>
            <p class="text-muted">Daftar semua pembayaran</p>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Penyewa</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayaran as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->penyewa->user->name ?? 'N/A' }}</td>
                            <td>Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $payment->tanggal_pembayaran->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $payment->status === 'lunas' ? 'success' : 
                                    ($payment->status === 'pending' ? 'warning' : 'danger') 
                                }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>
                                @if(Auth::user()->isAdmin() && $payment->status === 'pending')
                                <div class="btn-group">
                                    <form action="{{ route('admin.pembayaran.approve', $payment->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.pembayaran.reject', $payment->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data pembayaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection