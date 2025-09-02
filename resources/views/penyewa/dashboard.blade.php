@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard Penyewa</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <h5>Selamat datang, {{ auth()->user()->name }}!</h5>
                        <p class="mb-0">Ini adalah dashboard untuk penyewa kos.</p>
                    </div>

                    <div class="mt-4">
                        <h4>Menu Penyewa</h4>
                        <div class="list-group">
                            <a href="{{ route('penyewa.kamar.index') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-bed me-2"></i> Lihat Kamar Tersedia
                            </a>
                            <!-- Tambahkan menu lainnya di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection