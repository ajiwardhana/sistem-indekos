@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Pembayaran Baru</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('pembayaran.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="penyewa_id" class="form-label">Penyewa</label>
                            <select class="form-control @error('penyewa_id') is-invalid @enderror" 
                                    id="penyewa_id" name="penyewa_id" required>
                                <option value="">Pilih Penyewa</option>
                                @foreach($penyewas as $penyewa)
                                <option value="{{ $penyewa->id }}" @selected(old('penyewa_id') == $penyewa->id)>
                                    {{ $penyewa->nama }} - Kamar {{ $penyewa->kamar->nomor_kamar }}
                                </option>
                                @endforeach
                            </select>
                            @error('penyewa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="bulan" class="form-label">Bulan Pembayaran</label>
                            <input type="month" class="form-control @error('bulan') is-invalid @enderror" 
                                   id="bulan" name="bulan" value="{{ old('bulan') }}" required>
                            @error('bulan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Pembayaran</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                   id="jumlah" name="jumlah" value="{{ old('jumlah') }}" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Pembayaran</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                   id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select class="form-control @error('metode_pembayaran') is-invalid @enderror" 
                                    id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="">Pilih Metode</option>
                                <option value="transfer" @selected(old('metode_pembayaran') == 'transfer')>Transfer</option>
                                <option value="tunai" @selected(old('metode_pembayaran') == 'tunai')>Tunai</option>
                            </select>
                            @error('metode_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                              id="keterangan" name="keterangan" rows="2">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
                <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection