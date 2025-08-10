<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Indekos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.navbar')
    
    <div class="container mt-4">
        @include('partials.alerts')
        @yield('content')
    </div>

    <nav>
    @auth
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
            <a href="{{ route('admin.kamar.index') }}">Kelola Kamar</a>
        @else
            <a href="{{ route('kamar.index') }}">Daftar Kamar</a>
            <a href="{{ route('penyewaan.index') }}">Penyewaan Saya</a>
        @endif
    @endauth
</nav>
    
    @include('partials.footer')
</body>
</html>