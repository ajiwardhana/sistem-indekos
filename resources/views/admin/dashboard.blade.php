@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Jumlah Kamar</h5>
                                    <p class="card-text display-4">{{ \App\Models\Kamar::count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Jumlah Penyewa</h5>
                                    <p class="card-text display-4">{{ \App\Models\Penyewa::count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-info mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Jumlah Kos</h5>
                                    <p class="card-text display-4">{{ \App\Models\Kos::count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4>Menu Admin</h4>
                        <div class="list-group">
                            <a href="{{ route('admin.kamar.index') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-bed me-2"></i> Kelola Kamar
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-users me-2"></i> Kelola User
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