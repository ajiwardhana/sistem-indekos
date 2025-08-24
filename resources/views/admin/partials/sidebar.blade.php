<!-- Sidebar -->
<div class="col-lg-2 col-md-3 sidebar p-0">
    <div class="d-flex flex-column p-3">
        <a href="{{ url('/') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <i class="bi bi-house-door fs-3 me-2"></i>
            <span class="fs-4">Sikosan</span>
        </a>
        <hr class="text-light">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.kamar.index') }}" class="nav-link {{ request()->is('admin/kamar*') ? 'active' : '' }}">
                    <i class="bi bi-door-closed"></i>
                    Manajemen Kamar
                </a>
            </li>
            <li>
                <a href="{{ route('admin.penyewaan.index') }}" class="nav-link {{ request()->is('admin/penyewaan*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    Manajemen Penghuni
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pembayaran.index') }}" class="nav-link {{ request()->is('admin/pembayaran*') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i>
                    Manajemen Pembayaran
                </a>
            </li>
            <li>
                <a href="#" class="nav-link {{ request()->is('admin/keluhan*') ? 'active' : '' }}">
                    <i class="bi bi-chat-left-text"></i>
                    Keluhan
                </a>
            </li>
        </ul>
        <hr class="text-light">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>{{ Auth::user()->name }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i>Sign out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>