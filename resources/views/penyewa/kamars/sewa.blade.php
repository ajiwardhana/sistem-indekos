@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Sewa Kamar {{ $kamar->nama }}</h3>
    <p>Harga: Rp {{ number_format($kamar->harga,0,',','.') }}/bulan</p>

    <form action="{{ route('penyewa.kamar.store-sewa', $kamar->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="durasi" class="form-label">Durasi Sewa (bulan)</label>
            <input type="number" name="durasi" id="durasi" class="form-control" required min="1">
        </div>
        <button type="submit" class="btn btn-success">Konfirmasi Sewa</button>
        <a href="{{ route('penyewa.kamars.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
