@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Admin</h1>
    <div class="card">
        <div class="card-body">
            <p>Selamat datang, {{ auth()->user()->name }}</p>
            <a href="{{ route('admin.kamar.index') }}" class="btn btn-primary">
                Kelola Kamar
            </a>
        </div>
    </div>
</div>
@endsection