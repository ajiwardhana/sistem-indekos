<div>
    @if($kamar->fotos->count() > 0)
    <div id="carousel{{ $kamar->id }}" class="carousel slide mb-3" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($kamar->fotos as $i => $foto)
                <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $foto->foto) }}" 
                         class="d-block w-100" style="height:300px; object-fit:cover;">
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $kamar->id }}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $kamar->id }}" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
    @endif

    <p><strong>Harga:</strong> Rp {{ number_format($kamar->harga, 0, ',', '.') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($kamar->status) }}</p>
    <p><strong>Fasilitas:</strong> {{ $kamar->fasilitas }}</p>
    <p><strong>Deskripsi:</strong></p>
    <p>{{ $kamar->deskripsi }}</p>

    <hr>
    <h5>Penyewa</h5>
    @if($kamar->penyewa && $kamar->penyewa->user)
        <p><strong>Nama:</strong> {{ $kamar->penyewa->user->name }}</p>
        <p><strong>Email:</strong> {{ $kamar->penyewa->user->email }}</p>

        <form action="{{ route('admin.kamars.batalkan', $kamar->id) }}" method="POST" onsubmit="return confirm('Yakin batalkan penyewaan kamar ini?')">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-danger mt-2">
                <i class="fas fa-ban"></i> Batalkan Penyewaan
            </button>
        </form>
    @else
        <p class="text-muted">Belum ada penyewa.</p>
    @endif
</div>
