@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dashboard Pengguna</h1>
        <p>Anda login sebagai: {{ Auth::user()->name }} ({{ Auth::user()->role }})</p>
    </div>
@endsection