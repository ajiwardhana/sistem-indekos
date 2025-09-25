@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Kamar</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-header">
            <strong>Kamar No. {{ $kamar->nomor_kamar }}</strong>
        </div>
        <div class="card-body">
            <p><strong>Fasilitas:</strong> {{ ucfirst($kamar->fasilitas) }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($kamar->harga, 0, ',', '.') }}</p>
            <p>
                <strong>Status:</strong>
                <span class="badge bg-{{ $kamar->status == 'tersedia' ? 'success' : ($kamar->status == 'terisi' ? 'warning' : 'danger') }}">
                    {{ ucfirst($kamar->status) }}
                </span>
            </p>

            <hr>
            <h5>Penyewa</h5>
            @if($kamar->penyewa && $kamar->penyewa->user)
                <p><strong>Nama:</strong> {{ $kamar->penyewa->user->name }}</p>
                <p><strong>Email:</strong> {{ $kamar->penyewa->user->email }}</p>

                <!-- 🔥 Tombol Batalkan Penyewaan -->
                <form action="{{ route('admin.kamars.batalkan', $kamar->id) }}" method="POST" onsubmit="return confirm('Yakin batalkan penyewaan kamar ini?')">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger mt-2">
                        <i class="fas fa-ban"></i> Batalkan Penyewaan
                    </button>
                </form>
            @else
                <p class="text-muted">Belum ada penyewa.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.kamars.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>
@endsection
