@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detail Penyewaan</div>

                <div class="card-body">
                    <div class="mb-3">
                        <strong>ID:</strong> {{ $penyewaan->id }}
                    </div>
                    <div class="mb-3">
                        <strong>User:</strong> {{ $penyewaan->user->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Kamar:</strong> {{ $penyewaan->kamar->nama_kamar }}
                    </div>
                    <div class="mb-3">
                        <strong>Tanggal Mulai:</strong> {{ $penyewaan->tanggal_mulai }}
                    </div>
                    <div class="mb-3">
                        <strong>Durasi:</strong> {{ $penyewaan->durasi }} bulan
                    </div>
                    <div class="mb-3">
                        <strong>Total Harga:</strong> Rp {{ number_format($penyewaan->total_harga, 0, ',', '.') }}
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong> 
                        <span class="badge bg-{{ $penyewaan->status == 'aktif' ? 'success' : ($penyewaan->status == 'selesai' ? 'secondary' : 'danger') }}">
                            {{ $penyewaan->status }}
                        </span>
                    </div>
                    <a href="{{ route('penyewaan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection