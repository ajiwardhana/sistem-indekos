<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran Indekos</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .content {
            margin: 30px 0;
        }
        .table-detail {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table-detail th, .table-detail td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .table-detail th {
            background-color: #f5f5f5;
            width: 30%;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
            width: 200px;
            margin-left: auto;
            text-align: center;
        }
        @media print {
            body {
                padding: 0;
                font-size: 12pt;
            }
            .no-print {
                display: none;
            }
            .container {
                padding: 0;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>BUKTI PEMBAYARAN INDEKOS</h1>
            <p>Jl. Contoh Indekos No. 123, Kota Anda</p>
            <p>Telp: 0812-3456-7890</p>
        </div>

        <div class="content">
            <table class="table-detail">
                <tr>
                    <th>Nomor Transaksi</th>
                    <td>TRX-{{ str_pad($pembayaran->id, 5, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pembayaran</th>
                    <td>{{ $pembayaran->tanggal->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Nama penyewaan</th>
                    <td>{{ $pembayaran->penyewaan->nama }}</td>
                </tr>
                <tr>
                    <th>Nomor Kamar</th>
                    <td>{{ $pembayaran->penyewaan->kamar->nomor_kamar }}</td>
                </tr>
                <tr>
                    <th>Bulan Pembayaran</th>
                    <td>{{ \Carbon\Carbon::parse($pembayaran->bulan)->translatedFormat('F Y') }}</td>
                </tr>
                <tr>
                    <th>Jumlah Pembayaran</th>
                    <td>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Metode Pembayaran</th>
                    <td>{{ ucfirst($pembayaran->metode_pembayaran) }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $pembayaran->keterangan ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <div class="signature">
                <p>Hormat kami,</p>
                <br><br><br>
                <p>_________________________</p>
                <p>Admin Indekos</p>
            </div>
        </div>

        <div class="no-print" style="text-align: center; margin-top: 20px;">
            <button onclick="window.print()" class="btn btn-primary">Cetak Bukti</button>
        </div>
    </div>
</body>
</html>