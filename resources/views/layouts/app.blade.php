
@extends('layouts.app')
@section('title', 'Dashboard Penghuni')
@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Informasi Penyewaan Anda</h2>
    @if($penyewaanAktif)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <h3 class="font-semibold">Kamar</h3>
            <p>{{ $penyewaanAktif->kamar->nomor_kamar
            }}</p>
        </div>
        <div>
            <h3 class="font-semibold">Tanggal Mulai</h3>
            <p>{{ $penyewaanAktif->tanggal_mulai->format('d F Y') }}</p>
        </div>
        <div>
            <h3 class="font-semibold">Status Pembayaran</h3>
            <p class="{{ $penyewaanAktif->status_pembayaran == '    lunas' ? 'text-green-600' : 'text-red-600' }}">
                {{ ucfirst($penyewaanAktif->status_pembayaran) }}
            </p>
        </div>
    </div>
    @else
    <p class="text-gray-600">Anda belum memiliki kamar yang disewa</p>
    @endif
        </div>
@auth
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
    @else
        <a href="{{ route('dashboard') }}">Dashboard Saya</a>
    @endif
@endauth
