<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sikosan - Admin Kamar</title>
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
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
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
                            <a href="{{ url('/dashboard') }}" class="nav-link">
                                <i class="bi bi-speedometer2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="/admin/kamar" class="nav-link active">
                                <i class="bi bi-door-closed"></i>
                                Manajemen Kamar
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link">
                                <i class="bi bi-people"></i>
                                Manajemen Penghuni
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link">
                                <i class="bi bi-cash-coin"></i>
                                Manajemen Pembayaran
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link">
                                <i class="bi bi-chat-left-text"></i>
                                Keluhan
                            </a>
                        </li>
                    </ul>
                    <hr class="text-light">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="" width="32" height="32" class="rounded-circle me-2">
                            <strong>Administrator</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 ms-sm-auto px-4 py-4">
                <div class="main-content">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="page-title"><i class="bi bi-door-closed me-2"></i>Manajemen Kamar</h2>
                        <!-- PERBAIKAN: Menggunakan route yang benar -->
                        <a href="{{ route('admin.kamar.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Kamar Baru
                        </a>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="stats-card primary">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5>Total Kamar</h5>
                                        <h2>15</h2>
                                    </div>
                                    <i class="bi bi-door-closed fs-1 opacity-50"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stats-card success">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5>Tersedia</h5>
                                        <h2>8</h2>
                                    </div>
                                    <i class="bi bi-check-circle fs-1 opacity-50"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stats-card danger">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5>Terisi</h5>
                                        <h2>5</h2>
                                    </div>
                                    <i class="bi bi-x-circle fs-1 opacity-50"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stats-card warning">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5>Maintenance</h5>
                                        <h2>2</h2>
                                    </div>
                                    <i class="bi bi-tools fs-1 opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alert Message -->
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> <strong>Berhasil!</strong> Data kamar berhasil diperbarui.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nomor Kamar</th>
                                    <th scope="col">Tipe</th>
                                    <th scope="col">Fasilitas</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>101</td>
                                    <td>Standard</td>
                                    <td>Kamar mandi dalam, AC</td>
                                    <td>Rp 1.200.000</td>
                                    <td><span class="badge bg-success">Tersedia</span></td>
                                    <td class="action-buttons">
                                        <!-- PERBAIKAN: Menggunakan route yang benar -->
                                        <a href="{{ route('admin.kamar.edit', 1) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.kamar.destroy', 1) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>102</td>
                                    <td>Deluxe</td>
                                    <td>Kamar mandi dalam, AC, WiFi</td>
                                    <td>Rp 1.500.000</td>
                                    <td><span class="badge bg-danger">Terisi</span></td>
                                    <td class="action-buttons">
                                        <a href="{{ route('admin.kamar.edit', 2) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.kamar.destroy', 2) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>201</td>
                                    <td>VIP</td>
                                    <td>Kamar mandi dalam, AC, WiFi, TV, Lemari es</td>
                                    <td>Rp 2.000.000</td>
                                    <td><span class="badge bg-success">Tersedia</span></td>
                                    <td class="action-buttons">
                                        <a href="{{ route('admin.kamar.edit', 3) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.kamar.destroy', 3) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>202</td>
                                    <td>Deluxe</td>
                                    <td>Kamar mandi dalam, AC, WiFi</td>
                                    <td>Rp 1.500.000</td>
                                    <td><span class="badge bg-warning text-dark">Maintenance</span></td>
                                    <td class="action-buttons">
                                        <a href="{{ route('admin.kamar.edit', 4) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.kamar.destroy', 4) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-4">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Sebelumnya</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Selanjutnya</a>
                            </li>
                        </ul>
                    </nav>
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
                    // alert.style.display = 'none';
                }
            }, 5000);
        });
    </script>
</body>
</html>