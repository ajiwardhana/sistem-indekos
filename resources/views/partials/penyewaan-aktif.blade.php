<div class="penyewaan-info">
    @if($penyewaan)
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Nomor Kamar:</span>
                    <strong>{{ $penyewaan->kamar->nomor_kamar }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Tanggal Mulai:</span>
                    <strong>{{ \Carbon\Carbon::parse($penyewaan->tanggal_mulai)->format('d F Y') }}</strong>
                </li>
            </ul>
        </div>
        <div class="col-md-6">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Status:</span>
                    <span class="badge bg-success">Aktif</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Durasi:</span>
                    <strong>{{ \Carbon\Carbon::parse($penyewaan->tanggal_mulai)->diffForHumans(now(), true) }}</strong>
                </li>
            </ul>
        </div>
    </div>
    @else
    <div class="alert alert-warning">
        Anda tidak memiliki penyewaan aktif saat ini.
    </div>
    @endif
</div>