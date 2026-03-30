<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekap Bulanan Pendaki</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 10px; text-align: center; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #eee; }
        .footer { margin-top: 30px; text-align: right; font-size: 12px; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>LAPORAN REKAPITULASI BULANAN</h2>
        <h3>Sistem Manajemen Tiket Pendakian</h3>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Periode Bulan</th>
                <th>Total Pendaki</th>
                <th>Domestik</th>
                <th>Mancanegara</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::createFromDate($row->tahun, $row->bulan, 1)->translatedFormat('F Y') }}</td>
                <td>{{ $row->total_pendaki }}</td>
                <td>{{ $row->total_domestik }}</td>
                <td>{{ $row->total_mancanegara }}</td>
                <td>Rp {{ number_format($row->total_pendapatan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5">GRAND TOTAL PENDAPATAN</td>
                <td>Rp {{ number_format($totalIncomeAll, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>Admin Sistem</strong></p>
    </div>
</body>
</html>