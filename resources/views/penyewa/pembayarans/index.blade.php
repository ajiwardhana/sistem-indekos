@extends('layouts.app')

@section('title', 'Riwayat Pembayaran - Sikosan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title"><i class="bi bi-credit-card me-2"></i>Riwayat Pembayaran</h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kamar</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                Kamar {{ $p->kamar->nomor_kamar ?? '-' }}
                            </td>
                            <td>
                                <span class="fw-bold">Rp {{ number_format($p->jumlah,0,',','.') }}</span>
                            </td>
                            <td>
                                @if($p->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($p->status == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if($p->bukti_pembayaran)
                                    <a href="{{ asset('storage/'.$p->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($p->status == 'pending' && !$p->bukti_pembayaran)
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $p->id }}">
                                        <i class="bi bi-upload"></i> Upload Bukti
                                    </button>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Upload -->
                        <div class="modal fade" id="uploadModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('penyewa.pembayarans.uploadBukti', $p->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="file" name="bukti" class="form-control" required>
                                            <small class="text-muted">Format: jpg, jpeg, png, pdf | Max: 2MB</small>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
