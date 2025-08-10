@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <!-- Card Statistik -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Total Kamar</h3>
        <p class="text-2xl mt-2">{{ $totalKamar }}</p>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Kamar Tersedia</h3>
        <p class="text-2xl mt-2">{{ $kamarTersedia }}</p>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Total Penghuni</h3>
        <p class="text-2xl mt-2">{{ $totalPenghuni }}</p>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Pendapatan Bulan Ini</h3>
        <p class="text-2xl mt-2">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
    </div>
</div>

<!-- Daftar Penyewaan Terbaru -->
<div class="mt-8 bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Penyewaan Terbaru</h2>
    <table class="min-w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">No Kamar</th>
                <th class="px-4 py-2">Nama Penghuni</th>
                <th class="px-4 py-2">Tanggal Mulai</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penyewaanTerbaru as $sewa)
            <tr>
                <td class="border px-4 py-2">{{ $sewa->kamar->nomor_kamar }}</td>
                <td class="border px-4 py-2">{{ $sewa->user->name }}</td>
                <td class="border px-4 py-2">{{ $sewa->tanggal_mulai->format('d/m/Y') }}</td>
                <td class="border px-4 py-2">
                    <span class="px-2 py-1 rounded-full text-xs 
                        {{ $sewa->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($sewa->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection