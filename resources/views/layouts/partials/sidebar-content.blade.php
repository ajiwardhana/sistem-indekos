<!-- Logo Sidebar -->
<div class="text-center mb-4">
    <img src="{{ asset('images/logo.png') }}" alt="Logo Sikosan"
         style="width: 100%; max-width: 180px; height: auto;">
</div>

<ul class="nav flex-column">
    {{-- Admin --}}
    @if(Auth::check() && Auth::user()->role === 'admin')
        @php
            $pending = \App\Models\Pembayaran::where('status','pending')->count();
        @endphp
        <li class="nav-item mb-2 fw-bold text-muted small">Menu Admin</li>
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('admin.kamars.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('admin.kamars.index') }}">
                <i class="bi bi-door-closed me-2"></i> Kelola Kamar
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('admin.users.index') }}">
                <i class="bi bi-people me-2"></i> Kelola Pengguna
            </a>
        </li>
        <li class="nav-item mb-1 d-flex justify-content-between align-items-center">
            <a class="nav-link {{ request()->routeIs('admin.pembayarans.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('admin.pembayarans.index') }}">
                <i class="bi bi-wallet2 me-2"></i> Pembayaran
            </a>
            @if($pending > 0)
                <span class="badge bg-warning text-dark">{{ $pending }}</span>
            @endif
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('admin.keluhan.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('admin.keluhan.index') }}">
                <i class="bi bi-chat-left-dots me-2"></i> Keluhan
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('profile.edit') }}">
                <i class="bi bi-person-gear me-2"></i> Profil
            </a>
        </li>
    @endif

    {{-- Penyewa --}}
    @if(Auth::check() && Auth::user()->role === 'penyewa')
        @php
            $penyewa = \App\Models\Penyewa::where('user_id', Auth::id())->first();
            $pending = $penyewa ? $penyewa->pembayarans()->where('status','pending')->count() : 0;
        @endphp
        <li class="nav-item mb-2 fw-bold text-muted small">Menu Penyewa</li>
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('penyewa.dashboard') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('penyewa.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('penyewa.kamars.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('penyewa.kamars.index') }}">
                <i class="bi bi-door-open me-2"></i> Daftar Kamar
            </a>
        </li>
        <li class="nav-item mb-1 d-flex justify-content-between align-items-center">
            <a class="nav-link {{ request()->routeIs('penyewa.pembayarans.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('penyewa.pembayarans.index') }}">
                <i class="bi bi-wallet2 me-2"></i> Pembayaran
            </a>
            @if($pending > 0)
                <span class="badge bg-warning text-dark">{{ $pending }}</span>
            @endif
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('profile.edit') }}">
                <i class="bi bi-person-gear me-2"></i> Profil
            </a>
        </li>
    @endif

    {{-- Pemilik --}}
    @if(Auth::check() && Auth::user()->role === 'pemilik')
        <li class="nav-item mb-2 fw-bold text-muted small">Menu Pemilik</li>
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('pemilik.dashboard') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('pemilik.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        @if(Route::has('pemilik.penyewa.index'))
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('pemilik.penyewa.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('pemilik.penyewa.index') }}">
                <i class="bi bi-people-fill me-2"></i> Daftar Penyewa
            </a>
        </li>
        @endif
        @if(Route::has('pemilik.pembayaran.index'))
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('pemilik.pembayaran.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('pemilik.pembayaran.index') }}">
                <i class="bi bi-currency-dollar me-2"></i> Pendapatan Bulanan
            </a>
        </li>
        @endif
        @if(Route::has('pemilik.admin.index'))
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('pemilik.admin.*') ? 'active bg-primary text-white' : 'text-dark' }}" 
               href="{{ route('pemilik.admin.index') }}">
                <i class="bi bi-person-plus-fill me-2"></i> Kelola Admin
            </a>
        </li>
        @endif
    @endif
</ul>

{{-- Logout --}}
@if(Auth::check())
    <hr>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger w-100">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </button>
    </form>
@endif
