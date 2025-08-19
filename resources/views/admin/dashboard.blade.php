@extends('layouts.app')

@section('title', 'Dashboard - Sistem Indekos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Total Kamar</h5>
                        <h2>{{ $totalKamar }}</h2>
                    </div>
                    <i class="bi bi-door-closed fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Tersedia</h5>
                        <h2>{{ $kamarTersedia }}</h2>
                    </div>
                    <i class="bi bi-check-circle fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Terisi</h5>
                        <h2>{{ $kamarTerisi }}</h2>
                    </div>
                    <i class="bi bi-x-circle fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Maintenance</h5>
                        <h2>{{ $kamarMaintenance }}</h2>
                    </div>
                    <i class="bi bi-tools fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten dashboard lainnya -->
@endsection