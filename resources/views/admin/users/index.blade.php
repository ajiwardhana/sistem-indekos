@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola User</h1>
    </div>

    <!-- Filter Role -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="role" class="col-form-label">Filter Role:</label>
                </div>
                <div class="col-auto">
                    <select name="role" id="role" class="form-select">
                        <option value="">Semua</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="pemilik" {{ request('role') == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                        <option value="penyewa" {{ request('role') == 'penyewa' ? 'selected' : '' }}>Penyewa</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No Telepon</th>
                        <th>Alamat</th>
                        <th>Role</th>
                        <th>Kamar yang Disewa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->no_telepon ?? '-' }}</td>
                        <td>{{ $user->alamat ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $user->role == 'admin' ? 'primary' : ($user->role == 'pemilik' ? 'success' : 'secondary') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->penyewa && $user->penyewa->kamar)
                                {{ $user->penyewa->kamar->nomor_kamar }} ({{ $user->penyewa->kamar->tipe }})
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada user</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination (opsional) -->
            <div class="mt-3">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
