{{-- resources/views/admin/penyewaan/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Manajemen Penghuni</h2>
        {{-- Sementara nonaktifkan link yang error --}}
        <a href="#" class="btn btn-primary" onclick="alert('Fitur tambah penghuni akan segera tersedia')">
            <i class="fas fa-plus me-2"></i>Tambah Penghuni
        </a>
        {{-- Atau gunakan URL langsung --}}
        {{-- <a href="{{ url('/admin/penyewaan/create') }}" class="btn btn-primary"> --}}
        {{--     <i class="fas fa-plus me-2"></i>Tambah Penghuni --}}
        {{-- </a> --}}
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card card-stat border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Total Penghuni</h6>
                            <h4 class="mb-0">{{ $penyewaan->total() }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card card-stat border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Aktif</h6>
                            <h4 class="mb-0">{{ $penyewaan->where('status', 'aktif')->count() }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-check fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card card-stat border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Non-Aktif</h6>
                            <h4 class="mb-0">{{ $penyewaan->where('status', 'nonaktif')->count() }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-times fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card card-stat border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Kamar Terisi</h6>
                            <h4 class="mb-0">{{ $penyewaan->where('status', 'aktif')->count() }}/{{ App\Models\Kamar::count() }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-bed fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="search-form">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" placeholder="Cari nama, email, atau nomor telepon...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-Aktif</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kamar</th>
                            <th>Telepon</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penyewaan as $penyewaan)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($penyewaan->nama) }}&background=random" class="rounded-circle me-2" width="35" height="35">
                                    <div>
                                        <div>{{ $penyewaan->nama }}</div>
                                        <small class="text-muted">{{ $penyewaan->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $penyewaan->kamar->nama_kamar ?? 'Tidak ada kamar' }}</td>
                            <td>{{ $penyewaan->no_telepon }}</td>
                            <td>{{ \Carbon\Carbon::parse($penyewaan->tanggal_masuk)->format('d M Y') }}</td>
                            <td>
                                <span class="status-badge badge-{{ $penyewaan->status }}">{{ $penyewaan->status }}</span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    {{-- Nonaktifkan dulu link yang error --}}
                                    <button class="btn btn-sm btn-info" onclick="alert('Fitur detail akan segera tersedia')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="alert('Fitur edit akan segera tersedia')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="alert('Fitur hapus akan segera tersedia')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    
                                    {{-- Atau gunakan URL langsung --}}
                                    {{-- <a href="{{ url('/penyewaan/' . $penyewaan->id) }}" class="btn btn-sm btn-info"> --}}
                                    {{--     <i class="fas fa-eye"></i> --}}
                                    {{-- </a> --}}
                                    {{-- <a href="{{ url('/penyewaan/' . $penyewaan->id . '/edit') }}" class="btn btn-sm btn-warning"> --}}
                                    {{--     <i class="fas fa-edit"></i> --}}
                                    {{-- </a> --}}
                                    {{-- <form action="{{ url('/penyewaan/' . $penyewaan->id) }}" method="POST" class="d-inline"> --}}
                                    {{--     @csrf --}}
                                    {{--     @method('DELETE') --}}
                                    {{--     <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus penghuni ini?')"> --}}
                                    {{--         <i class="fas fa-trash"></i> --}}
                                    {{--     </button> --}}
                                    {{-- </form> --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $penyewaan->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .badge-aktif {
        background-color: rgba(20, 164, 77, 0.2);
        color: #14A44D;
    }
    
    .badge-nonaktif {
        background-color: rgba(220, 76, 100, 0.2);
        color: #DC4C64;
    }
    
    .card-stat {
        border-left: 4px solid #3B71CA;
    }
    
    .search-form {
        position: relative;
    }
    
    .search-form .form-control {
        border-radius: 20px;
        padding-left: 40px;
    }
    
    .search-form i {
        position: absolute;
        left: 15px;
        top: 12px;
        color: #9FA6B2;
    }
    
    .page-title {
        position: relative;
        padding-bottom: 10px;
    }
    
    .page-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: #3B71CA;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('.search-form input');
        const statusFilter = document.querySelector('.form-select');
        const tableRows = document.querySelectorAll('tbody tr');
        
        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            
            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                const statusCell = row.querySelector('.status-badge').textContent.toLowerCase();
                
                const matchesSearch = searchText === '' || rowText.indexOf(searchText) > -1;
                const matchesStatus = statusValue === '' || statusCell === statusValue;
                
                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        searchInput.addEventListener('keyup', filterTable);
        statusFilter.addEventListener('change', filterTable);
    });
</script>
@endpush