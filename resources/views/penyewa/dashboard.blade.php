@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard Penyewa</h2>

    {{-- Info Kamar --}}
    @if($penyewa && $penyewa->kamar)
        <div class="alert alert-info">
            <h5>Kamar yang Anda sewa:</h5>
            <p><strong>Nomor:</strong> {{ $penyewa->kamar->nomor_kamar }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($penyewa->kamar->harga, 0, ',', '.') }}</p>
        </div>
    @else
        <div class="alert alert-warning">
            Anda belum menyewa kamar. <a href="{{ route('penyewa.kamar.index') }}">Cari kamar sekarang</a>.
        </div>
    @endif

    {{-- 🔔 Tagihan Pending --}}
    @php
        $pending = $penyewa ? $penyewa->pembayarans()->where('status','pending')->count() : 0;
    @endphp
    @if($pending > 0)
        <div class="alert alert-warning">
            Anda memiliki <strong>{{ $pending }}</strong> pembayaran pending. <a href="{{ route('penyewa.pembayaran.index') }}">Lihat Pembayaran</a>.
        </div>
    @endif

    {{-- 🔔 Status Pembayaran Terakhir --}}
    @if($pembayaranTerakhir)
        <div class="mt-3">
            <h5>Status Pembayaran Terakhir:</h5>
            @if($pembayaranTerakhir->status == 'pending')
                <div class="alert alert-warning">Menunggu konfirmasi admin.</div>
            @elseif($pembayaranTerakhir->status == 'lunas')
                <div class="alert alert-success">Pembayaran Anda sudah LUNAS ✅</div>
            @else
                <div class="alert alert-danger">Pembayaran Anda DITOLAK ❌</div>
            @endif
        </div>
    @endif

    {{-- Menu --}}
    <div class="mt-4">
        <h4>Menu</h4>
        <div class="list-group">
            <a href="{{ route('penyewa.kamar.index') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-bed me-2"></i> Cari & Sewa Kamar
            </a>
            <a href="{{ route('penyewa.pembayaran.index') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-money-bill me-2"></i> Riwayat Pembayaran
            </a>
        </div>
    </div>
</div>
@endsection
