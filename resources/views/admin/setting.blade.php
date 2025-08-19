@extends('layouts.app')

@section('title', 'Pengaturan - Sistem Indekos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title"><i class="bi bi-gear me-2"></i>Pengaturan</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Pengaturan Sistem</h5>
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="app_name" class="form-label">Nama Aplikasi</label>
                    <input type="text" class="form-control" id="app_name" name="app_name" value="{{ old('app_name', config('app.name')) }}">
                </div>
                
                <div class="mb-3">
                    <label for="currency" class="form-label">Mata Uang</label>
                    <select class="form-select" id="currency" name="currency">
                        <option value="IDR" selected>Rupiah (IDR)</option>
                        <option value="USD">Dollar (USD)</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Notifikasi</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="notif_email" name="notif_email" checked>
                        <label class="form-check-label" for="notif_email">Email Notifikasi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="notif_sms" name="notif_sms">
                        <label class="form-check-label" for="notif_sms">SMS Notifikasi</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </form>
        </div>
    </div>
@endsection