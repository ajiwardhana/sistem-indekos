@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Buat Penyewaan Baru</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('penyewaan.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="kamar_id">Pilih Kamar</label>
                    <select name="kamar_id" id="kamar_id" class="form-control @error('kamar_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($kamar as $kamar)
                            <option value="{{ $kamar->id }}" 
                                data-harga="{{ $kamar->harga }}"
                                @if(old('kamar_id') == $kamar->id) selected @endif>
                                {{ $kamar->nomor_kamar }} - {{ $kamar->tipe }} (Rp {{ number_format($kamar->harga, 0, ',', '.') }}/bulan)
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
                           value="{{ old('tanggal_mulai') }}" 
                           min="{{ date('Y-m-d') }}" required>
                    @error('tanggal_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="durasi">Durasi (bulan)</label>
                    <input type="number" name="durasi" id="durasi" 
                           class="form-control @error('durasi') is-invalid @enderror" 
                           value="{{ old('durasi', 1) }}" min="1" required>
                    @error('durasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Total Pembayaran</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" id="total_pembayaran" class="form-control" readonly>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('penyewaan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        function calculateTotal() {
            const harga = $('#kamar_id option:selected').data('harga') || 0;
            const durasi = $('#durasi').val() || 0;
            const total = harga * durasi;
            $('#total_pembayaran').val(total.toLocaleString('id-ID'));
        }

        $('#kamar_id, #durasi').change(calculateTotal);
        calculateTotal();
    });
</script>
@endsection
@endsection