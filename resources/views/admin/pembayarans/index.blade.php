@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h2 class="mb-4">Daftar Pembayaran</h2>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Penyewa</th>
                        <th>Kamar</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembayarans as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $p->penyewa->user->name ?? '-' }}</strong><br>
                            <small class="text-muted">{{ $p->penyewa->user->email ?? '' }}</small>
                        </td>
                        <td>{{ $p->kamar->nomor_kamar ?? '-' }}</td>
                        <td>Rp {{ number_format($p->jumlah,0,',','.') }}</td>
                        <td>
                            <span class="badge 
                                @if($p->status=='pending') bg-warning text-dark 
                                @elseif($p->status=='ditolak') bg-danger 
                                @else bg-success @endif">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            @if($p->bukti_pembayaran)
                                <!-- Tombol untuk modal bukti -->
                                <button class="btn btn-link text-decoration-none p-0" data-bs-toggle="modal" data-bs-target="#buktiModal{{ $p->id }}">
                                    <i class="bi bi-image"></i> Lihat
                                </button>

                                <!-- Modal bukti -->
                                <div class="modal fade" id="buktiModal{{ $p->id }}" tabindex="-1" aria-labelledby="buktiLabel{{ $p->id }}" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="buktiLabel{{ $p->id }}">Bukti Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                      </div>
                                      <div class="modal-body text-center">
                                        <img src="{{ asset('storage/'.$p->bukti_pembayaran) }}" class="img-fluid rounded shadow-sm" alt="Bukti Pembayaran">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($p->status=='pending')
                                <div class="d-flex gap-1">
                                    <form action="{{ route('admin.pembayarans.konfirmasi', $p->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle"></i> Konfirmasi
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.pembayarans.tolak', $p->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-x-circle"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
