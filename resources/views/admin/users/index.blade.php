@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kelola User</h1>
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
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
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->no_telepon ?? '-' }}</td>
                <td>{{ $user->alamat ?? '-' }}</td>
                <td>
                    <span class="badge bg-{{ $user->role == 'admin' ? 'primary' : 'secondary' }}">
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
            @endforeach
        </tbody>
    </table>
</div>
@endsection
