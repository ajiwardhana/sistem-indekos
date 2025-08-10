<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sistem Indekos | @yield('title')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --sidebar-width: 250px;
            --topbar-height: 60px;
        }
        
        body {
            padding-top: var(--topbar-height);
        }
        
        #sidebar {
            width: var(--sidebar-width);
            height: calc(100vh - var(--topbar-height));
            position: fixed;
            transition: all 0.3s;
        }
        
        #main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
        }
        
        .sidebar-collapsed {
            --sidebar-width: 80px;
        }
        
        .sidebar-collapsed .sidebar-text {
            display: none;
        }
        
        .topbar {
            height: var(--topbar-height);
        }
    </style>
</head>
<body class="bg-light">
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand navbar-dark bg-primary topbar fixed-top shadow">
        <div class="container-fluid">
            <button class="btn btn-link text-white" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="ms-auto d-flex align-items-center">
                <div class="dropdown">
                    <a class="text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i>
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div id="sidebar" class="bg-white shadow">
        <div class="sidebar-logo text-center py-3">
            <i class="fas fa-home fa-2x text-primary"></i>
            <span class="sidebar-text fw-bold ms-2">Sistem Indekos</span>
        </div>
        
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.kamar.index') }}">
                    <i class="fas fa-door-open me-2"></i>
                    <span class="sidebar-text">Manajemen Kamar</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.penyewa.index') }}">
                    <i class="fas fa-users me-2"></i>
                    <span class="sidebar-text">Data Penyewa</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.pembayaran.index') }}">
                    <i class="fas fa-money-bill-wave me-2"></i>
                    <span class="sidebar-text">Pembayaran</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                    <i class="fas fa-file-alt me-2"></i>
                    <span class="sidebar-text">Laporan</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <main id="main-content" class="p-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-collapsed');
        });
        
        // Active Nav Item
        document.querySelectorAll('.nav-link').forEach(link => {
            if(link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>