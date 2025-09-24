@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Kamar</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @foreach($kamars as $kamar)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Kamar {{ $kamar->nama }}</h5>
                        <p>Harga: Rp {{ number_format($kamar->harga,0,',','.') }}/bulan</p>
                        <p>Status: 
                            @if($kamar->penyewa)
                                <span class="badge bg-danger">Sudah disewa</span>
                            @else
                                <span class="badge bg-success">Tersedia</span>
                            @endif
                        </p>
                        @if(!$kamar->penyewa)
                            <a href="{{ route('penyewa.kamar.sewa', $kamar->id) }}" class="btn btn-primary">
                                Sewa Kamar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
