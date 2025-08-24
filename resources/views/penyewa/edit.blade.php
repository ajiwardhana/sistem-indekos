@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Penyewaan</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('penyewa.update', $penyewa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="kamar_id">Kamar</label>
                    <select name="kamar_id" id="kamar_id" class="form-control @error('kamar_id') is-invalid @enderror" required>
                        @foreach($kamar as $kamar)
                            <option value="{{ $kamar->id }}" 
                                @if($penyewa->kamar_id == $kamar->id || old('kamar_id') == $kamar->id) selected @endif>
                                {{ $kamar->nomor_kamar }} - {{ $kamar->tipe }}
                            </option>
                        @endforeach
                    </select>
                    @error('kamar_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                           class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                           value="{{ old('tanggal_mulai', $penyewa->tanggal_mulai->format('Y-m-d')) }}" required>
                    @error('tanggal_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_selesai">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" 
                           class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                           value="{{ old('tanggal_selesai', $penyewa->tanggal_selesai ? $penyewa->tanggal_selesai->format('Y-m-d') : '') }}" required>
                    @error('tanggal_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="aktif" @if($penyewa->status == 'aktif' || old('status') == 'aktif') selected @endif>Aktif</option>
                        <option value="selesai" @if($penyewa->status == 'selesai' || old('status') == 'selesai') selected @endif>Selesai</option>
                        <option value="dibatalkan" @if($penyewa->status == 'dibatalkan' || old('status') == 'dibatalkan') selected @endif>Dibatalkan</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="total_pembayaran">Total Pembayaran</label>
                    <input type="number" name="total_pembayaran" id="total_pembayaran" 
                           class="form-control @error('total_pembayaran') is-invalid @enderror" 
                           value="{{ old('total_pembayaran', $penyewa->total_pembayaran) }}" required>
                    @error('total_pembayaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('penyewa.show', $penyewa->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection