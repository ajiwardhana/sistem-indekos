@extends('layouts.app')

@section('title','Kelola Admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kelola Admin</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('pemilik.admin.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-lg"></i> Tambah Admin
    </a>

    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <a href="{{ route('pemilik.admin.edit', $admin->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('pemilik.admin.destroy', $admin->id) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus admin ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada admin</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
