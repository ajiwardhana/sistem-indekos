<!-- Ganti loop dengan pagination -->
@if($penyewaanTerbaru->isNotEmpty())
    @foreach($penyewaanTerbaru as $sewa)
        <!-- Gunakan property langsung, hindari accessor berulang -->
        <td>{{ $sewa->kamar->nomor_kamar }}</td>
    @endforeach
@endif