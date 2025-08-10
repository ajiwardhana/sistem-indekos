@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dashboard Admin</h1>
        <p>Halo, {{ Auth::user()->name }} (Admin)</p>
        <a href="{{ route('admin.kamar.index') }}" class="btn btn-primary">Kelola Kamar</a>
    </div>
@endsection