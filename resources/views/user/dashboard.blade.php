@extends('layouts.app')

@section('title', 'Dashboard Penghuni')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Informasi Penyewaan Anda</h2>
    
    @if($penyewaanAktif)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <h3 class="font-semibold">Kamar</h3>
            <p>{{ $penyewaanAktif->kamar->nomor_kamar }}</p>
        </div>
        <div>
            <h3 class="font-semibold">Tanggal Mulai</h3>
            <p>{{ $penyewaanAktif->tanggal_mulai->format('d F Y') }}</p>
        </div>
        <div>
            <h3 class="font-semibold">Status Pembayaran</h3>
            <p class="{{ $penyewaanAktif->status_pembayaran == 'lunas' ? 'text-green-600' : 'text-red-600' }}">
                {{ ucfirst($penyewaanAktif->status_pembayaran) }}
            </p>
        </div>
    </div>
    @else
    <p class="text-gray-600">Anda belum memiliki kamar yang disewa</p>
    @endif
</div>

<div class="mt-6 bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Riwayat Pembayaran</h2>
    <table class="min-w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Bulan</th>
                <th class="px-4 py-2">Tanggal Bayar</th>
                <th class="px-4 py-2">Jumlah</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayatPembayaran as $pembayaran)
            <tr>
                <td class="border px-4 py-2">{{ $pembayaran->bulan_dibayar }}</td>
                <td class="border px-4 py-2">{{ $pembayaran->tanggal_bayar->format('d/m/Y') }}</td>
                <td class="border px-4 py-2">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                <td class="border px-4 py-2">
                    <span class="px-2 py-1 rounded-full text-xs 
                        {{ $pembayaran->status == 'lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($pembayaran->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="border px-4 py-2 text-center text-gray-500">Belum ada riwayat pembayaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection