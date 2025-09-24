@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pembayaran Baru</h2>

    <form action="{{ route('penyewa.pembayaran.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Jumlah Bayar</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <select name="metode" class="form-control">
                <option value="transfer">Transfer Bank</option>
                <option value="cash">Cash</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Bayar</button>
    </form>
</div>
@endsection
