@extends('layouts.app')

@section('title','Edit Admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Admin</h1>

    <form action="{{ route('pemilik.admin.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password <small>(kosongkan jika tidak ingin diubah)</small></label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('pemilik.admin.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
