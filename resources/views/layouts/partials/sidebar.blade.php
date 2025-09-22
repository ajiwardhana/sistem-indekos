<div class="col-lg-2 col-md-3 bg-dark text-white sidebar p-3 min-vh-100">
    <h4 class="text-center mb-4">Sikosan</h4>
    <ul class="nav flex-column">

        {{-- Menu untuk Admin --}}
        @if(Auth::check() && Auth::user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('admin.kamar.index') }}">
                    <i class="bi bi-door-closed"></i> Kelola Kamar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i> Kelola Pengguna
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('admin.keluhan.index') }}">
                    <i class="bi bi-chat-left-dots"></i> Keluhan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('admin.settings') }}">
                    <i class="bi bi-gear"></i> Pengaturan
                </a>
            </li>
        @endif

        {{-- Menu untuk Pemilik --}}
        @if(Auth::check() && Auth::user()->role === 'pemilik')
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('pemilik.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <i class="bi bi-house-door"></i> Data Kos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <i class="bi bi-cash"></i> Laporan Keuangan
                </a>
            </li>
        @endif

        {{-- Menu untuk Penyewa --}}
        @if(Auth::check() && Auth::user()->role === 'penyewa')
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('penyewa.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('penyewa.kamar.index') }}">
                    <i class="bi bi-door-open"></i> Daftar Kamar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <i class="bi bi-wallet2"></i> Pembayaran
                </a>
            </li>
        @endif

    </ul>

    {{-- Tombol Logout --}}
    @if(Auth::check())
        <hr class="text-white">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    @endif
</div>
