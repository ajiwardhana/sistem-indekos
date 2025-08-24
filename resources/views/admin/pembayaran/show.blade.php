@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Pembayaran</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">ID Penyewaan</dt>
                        <dd class="col-sm-8">{{ $pembayaran->penyewa_id }}</dd>

                        <dt class="col-sm-4">Penyewa</dt>
                        <dd class="col-sm-8">{{ $pembayaran->penyewa->user->name ?? '-' }}</dd>

                        <dt class="col-sm-4">Jumlah</dt>
                        <dd class="col-sm-8">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</dd>

                        <dt class="col-sm-4">Tanggal Pembayaran</dt>
                        <dd class="col-sm-8">{{ $pembayaran->tanggal_pembayaran->format('d F Y') }}</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Metode Pembayaran</dt>
                        <dd class="col-sm-8">
                            <span class="badge badge-{{ $pembayaran->metode_pembayaran === 'transfer' ? 'info' : 'success' }}">
                                {{ Str::ucfirst($pembayaran->metode_pembayaran) }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge badge-{{ 
                                $pembayaran->status === 'lunas' ? 'success' : 
                                ($pembayaran->status === 'pending' ? 'warning' : 'danger') 
                            }}">
                                {{ Str::ucfirst($pembayaran->status) }}
                            </span>
                        </dd>

                        @if($pembayaran->metode_pembayaran === 'transfer')
                        <dt class="col-sm-4">Bukti Transfer</dt>
                        <dd class="col-sm-8">
                            @if($pembayaran->bukti_pembayaran)
                                <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank">
                                    <img src="{{ Storage::url($pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-thumbnail" style="max-height: 150px">
                                </a>
                            @else
                                <span class="text-muted">Tidak ada bukti</span>
                            @endif
                        </dd>
                        @endif
                    </dl>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

                @can('update', $pembayaran)
                <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="btn btn-primary ml-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @endcan

                @if(auth()->user()->isAdmin() && $pembayaran->status === 'pending')
                <form action="{{ route('pembayaran.verify', $pembayaran->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success ml-2">
                        <i class="fas fa-check"></i> Verifikasi
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection