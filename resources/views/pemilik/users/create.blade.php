@extends('layouts.app')

@section('title','Tambah Admin')

@section('content')
<div class="container">
    <h1>Tambah Admin</h1>

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <form action="{{ route('pemilik.users.admin.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('pemilik.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
