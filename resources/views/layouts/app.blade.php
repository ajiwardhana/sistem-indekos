<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Indekos')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            min-height: 100vh;
            background-color: var(--secondary-color);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar .nav-link {
            color: var(--light-color);
            border-radius: 5px;
            margin: 5px 0;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        
        .main-content {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin: 20px 0;
        }
        
        .page-title {
            color: var(--secondary-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        
        .table th {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .badge-available {
            background-color: #2ecc71;
        }
        
        .badge-occupied {
            background-color: #e74c3c;
        }
        
        .badge-maintenance {
            background-color: #f39c12;
        }
        
        .action-buttons .btn {
            margin-right: 5px;
        }
        
        .stats-card {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stats-card.primary {
            background: linear-gradient(45deg, #3498db, #2980b9);
        }
        
        .stats-card.success {
            background: linear-gradient(45deg, #2ecc71, #27ae60);
        }
        
        .stats-card.warning {
            background: linear-gradient(45deg, #f39c12, #e67e22);
        }
        
        .stats-card.danger {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
            
            .stats-card {
                margin-bottom: 15px;
            }
            
            .action-buttons {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }
            
            .action-buttons .btn {
                margin-right: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 sidebar p-0">
                <div class="d-flex flex-column p-3">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <i class="bi bi-house-door fs-3 me-2"></i>
                        <span class="fs-4">Sistem Indekos</span>
                    </a>
                    <hr class="text-light">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
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
                            <a href="{{ route('admin.penghuni.index') }}" class="nav-link {{ request()->is('admin/penghuni*') ? 'active' : '' }}">
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
                            <a href="{{ route('admin.keluhan.index') }}" class="nav-link {{ request()->is('admin/keluhan*') ? 'active' : '' }}">
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
                            <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
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

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 ms-sm-auto px-4 py-4">
                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script untuk menangani interaksi halaman
        document.addEventListener('DOMContentLoaded', function() {
            // Menampilkan alert sukses (bisa dihilangkan setelah beberapa detik)
            setTimeout(function() {
                const alert = document.querySelector('.alert');
                if (alert) {
                    alert.style.display = 'none';
                }
            }, 5000);
        });
    </script>
    @stack('scripts')
</body>
</html>