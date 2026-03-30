<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan Pendaki - {{ date('M Y') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: sans-serif; padding: 20px; color: #333; background: #fff; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .chart-container { display: flex; gap: 20px; margin-bottom: 30px; justify-content: space-between; }
        .chart-box { width: 48%; border: 1px solid #ddd; padding: 10px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .footer { margin-top: 20px; text-align: right; font-weight: bold; }
        
        @media print {
            .no-print { display: none; }
            canvas { max-width: 100% !important; }
        }
    </style>
</head>
<body onload="initCharts()">
    <div class="header">
        <h1>LAPORAN BULANAN & MONITORING PENDAKI</h1>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->timezone('Asia/Makassar')->format('d F Y, H:i') }} WITA</p>
    </div>

    <div class="chart-container">
        <div class="chart-box">
            <h4 style="text-align:center; margin-top:0;">Grafik Pendaki Harian</h4>
            <canvas id="dailyChart"></canvas>
        </div>
        <div class="chart-box">
            <h4 style="text-align:center; margin-top:0;">Grafik Pendaki Bulanan</h4>
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pendaki</th>
                <th>Kategori</th>
                <th>Waktu Naik</th>
                <th>Biaya Tiket</th>
            </tr>
        </thead>
        <tbody>
            @foreach($climbings as $key => $c)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $c->name }}</td>
                <td>{{ $c->ticket->name ?? '-' }}</td>
                <td>{{ $c->created_at->timezone('Asia/Makassar')->format('d/m/Y H:i') }}</td>
                <td>Rp {{ number_format($c->ticket->price ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total Pendapatan: Rp {{ number_format($totalIncome, 0, ',', '.') }}
    </div>

    <script>
        function initCharts() {
            // Data Harian dari Controller
            const dailyCtx = document.getElementById('dailyChart').getContext('2d');
            new Chart(dailyCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($dailyData->pluck('date')) !!},
                    datasets: [{
                        label: 'Jumlah Pendaki',
                        data: {!! json_encode($dailyData->pluck('count')) !!},
                        borderColor: '#58a6ff',
                        backgroundColor: 'rgba(88, 166, 255, 0.1)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: { animation: false, responsive: true }
            });

            // Data Bulanan dari Controller
            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthlyData->pluck('month')) !!},
                    datasets: [{
                        label: 'Total Per Bulan',
                        data: {!! json_encode($monthlyData->pluck('total_pendaki')) !!},
                        backgroundColor: '#3fb950'
                    }]
                },
                options: { animation: false, responsive: true }
            });

            // Otomatis buka print setelah grafik selesai dimuat (delay 1 detik)
            setTimeout(() => { window.print(); }, 1000);
        }
    </script>
</body>
</html>