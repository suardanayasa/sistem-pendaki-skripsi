@extends('admin.dashboardAdmin')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
    :root {
        --bg-base:        #0d1117;
        --bg-surface:     #161b22;
        --bg-elevated:    #1c2330;
        --bg-card:        #21262d;
        --border:         #30363d;
        --border-light:   #3d444d;
        --accent-teal:    #39d0c8;
        --accent-blue:    #58a6ff;
        --accent-green:   #3fb950;
        --accent-amber:   #e3b341;
        --accent-purple:  #bc8cff;
        --text-primary:   #e6edf3;
        --text-secondary: #8b949e;
        --text-muted:     #6e7681;
    }

    /* ── STAT CARDS ── */
    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
        position: relative; overflow: hidden;
        transition: border-color .2s, transform .2s;
    }
    .stat-card:hover { border-color: var(--border-light); transform: translateY(-3px); }

    /* top accent line */
    .stat-card::before {
        content: ''; position: absolute;
        top: 0; left: 0; right: 0; height: 2px;
    }
    .stat-teal::before   { background: var(--accent-teal); }
    .stat-blue::before   { background: var(--accent-blue); }
    .stat-green::before  { background: var(--accent-green); }
    .stat-amber::before  { background: var(--accent-amber); }
    .stat-purple::before { background: var(--accent-purple); }

    /* glow blob */
    .stat-card::after {
        content: ''; position: absolute;
        bottom: -25px; right: -25px;
        width: 100px; height: 100px; border-radius: 50%;
        opacity: .06;
    }
    .stat-teal::after   { background: var(--accent-teal); }
    .stat-blue::after   { background: var(--accent-blue); }
    .stat-green::after  { background: var(--accent-green); }
    .stat-amber::after  { background: var(--accent-amber); }
    .stat-purple::after { background: var(--accent-purple); }

    .stat-icon {
        width: 40px; height: 40px; border-radius: 11px;
        display: grid; place-items: center;
        font-size: 18px; margin-bottom: 14px;
    }
    .stat-teal   .stat-icon { background: rgba(57,208,200,.12);  color: var(--accent-teal); }
    .stat-blue   .stat-icon { background: rgba(88,166,255,.12);  color: var(--accent-blue); }
    .stat-green  .stat-icon { background: rgba(63,185,80,.12);   color: var(--accent-green); }
    .stat-amber  .stat-icon { background: rgba(227,179,65,.12);  color: var(--accent-amber); }
    .stat-purple .stat-icon { background: rgba(188,140,255,.12); color: var(--accent-purple); }

    .stat-label {
        font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .8px;
        color: var(--text-muted);
    }
    .stat-value {
        font-family: 'Sora', sans-serif;
        font-size: 30px; font-weight: 800;
        color: var(--text-primary);
        line-height: 1.1; margin: 6px 0 4px;
    }
    .stat-desc { font-size: 11.5px; color: var(--text-muted); }

    /* ── CHART CARDS ── */
    .chart-card {
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        transition: border-color .2s;
    }
    .chart-card:hover { border-color: var(--border-light); }

    .chart-card-header {
        display: flex; align-items: flex-start;
        justify-content: space-between; gap: 12px;
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        background: var(--bg-elevated);
    }
    .chart-title-text {
        font-size: 14px; font-weight: 700;
        color: var(--text-primary);
    }
    .chart-sub-text {
        font-size: 11.5px; color: var(--text-muted);
        margin-top: 3px;
    }

    .chart-badge {
        font-size: 11px; font-weight: 600;
        padding: 3px 10px; border-radius: 20px;
        white-space: nowrap; flex-shrink: 0;
    }
    .badge-teal   { background: rgba(57,208,200,.12); color: var(--accent-teal); }
    .badge-blue   { background: rgba(88,166,255,.12); color: var(--accent-blue); }
    .badge-purple { background: rgba(188,140,255,.12); color: var(--accent-purple); }

    .chart-body { padding: 24px; }

    /* Chart wrap — scrollable on small screens */
    .chart-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; padding-bottom: 8px; }
    .chart-wrap { position: relative; height: 300px; min-width: 520px; width: 100%; }

    /* ── INSIGHT PILLS ── */
    .insight-pill {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--bg-elevated);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 5px 13px;
        font-size: 12px; color: var(--text-secondary);
    }
    .insight-dot {
        width: 7px; height: 7px; border-radius: 50%;
    }
</style>

{{-- ── PAGE HEADER ── --}}
<div class="pt-1 mb-4">
    <h1 style="font-family:'Sora',sans-serif; font-size:24px; font-weight:700; color:var(--text-primary); margin:0;">
        Statistik & Analisis Pendakian
    </h1>
    <p style="color:var(--text-muted); font-size:13px; margin-top:4px; margin-bottom:0;">
        Visualisasi data pendaftaran pendaki secara real-time.
    </p>
</div>

{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card stat-teal">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="stat-label">Total Pendaki</div>
            <div class="stat-value">{{ $totalPendaki }}</div>
            <div class="stat-desc">Akumulasi semua waktu</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card stat-blue">
            <div class="stat-icon"><i class="bi bi-calendar-month-fill"></i></div>
            <div class="stat-label">Bulan Ini</div>
            <div class="stat-value">{{ $totalBulanIni }}</div>
            <div class="stat-desc">{{ date('F Y') }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card stat-green">
            <div class="stat-icon"><i class="bi bi-calendar-week-fill"></i></div>
            <div class="stat-label">14 Hari Terakhir</div>
            <div class="stat-value">
                @php
                    $last14 = isset($dailyData) ? $dailyData->sum('count') : 0;
                @endphp
                {{ $last14 }}
            </div>
            <div class="stat-desc">Data tren harian</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card stat-amber">
            <div class="stat-icon"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="stat-label">Rata-rata / Bulan</div>
            <div class="stat-value">
                @php
                    $avgPerBulan = isset($monthlyData) && $monthlyData->count() > 0
                        ? round($monthlyData->avg('total_pendaki'))
                        : 0;
                @endphp
                {{ $avgPerBulan }}
            </div>
            <div class="stat-desc">Tahun {{ date('Y') }}</div>
        </div>
    </div>
</div>

{{-- ── CHARTS ── --}}
<div class="d-flex flex-column gap-4">

    {{-- Daily Chart --}}
    <div class="chart-card">
        <div class="chart-card-header">
            <div>
                <div class="chart-title-text">Tren Pendakian 14 Hari Terakhir</div>
                <div class="chart-sub-text">Data harian berdasarkan tanggal pendaftaran</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="insight-pill">
                    <span class="insight-dot" style="background:var(--accent-teal);"></span>
                    Pendaki per hari
                </div>
                <span class="chart-badge badge-teal">Harian</span>
            </div>
        </div>
        <div class="chart-body">
            <div class="chart-responsive">
                <div class="chart-wrap">
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Monthly Chart --}}
    <div class="chart-card">
        <div class="chart-card-header">
            <div>
                <div class="chart-title-text">Pertumbuhan Pendaki Per Bulan</div>
                <div class="chart-sub-text">Januari – Desember {{ date('Y') }}</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="insight-pill">
                    <span class="insight-dot" style="background:var(--accent-blue);"></span>
                    Total per bulan
                </div>
                <span class="chart-badge badge-blue">Bulanan</span>
            </div>
        </div>
        <div class="chart-body">
            <div class="chart-responsive">
                <div class="chart-wrap">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    Chart.defaults.color       = '#8b949e';
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

    const gridColor = 'rgba(48,54,61,0.8)';

    // ── Daily Chart ──
    @if(isset($dailyData) && $dailyData->count() > 0)
    const dailyCtx = document.getElementById('dailyChart');
    if (dailyCtx) {
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($dailyData->pluck('date')) !!},
                datasets: [{
                    label: 'Jumlah Pendaki',
                    data: {!! json_encode($dailyData->pluck('count')) !!},
                    borderColor: '#39d0c8',
                    backgroundColor: (ctx) => {
                        const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(57,208,200,0.2)');
                        gradient.addColorStop(1, 'rgba(57,208,200,0)');
                        return gradient;
                    },
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#39d0c8',
                    pointBorderColor: '#0d1117',
                    pointBorderWidth: 2,
                    tension: 0.45,
                    fill: true,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#21262d',
                        borderColor: '#30363d', borderWidth: 1,
                        titleColor: '#e6edf3', bodyColor: '#8b949e',
                        padding: 12, cornerRadius: 10,
                        callbacks: {
                            label: ctx => '  Pendaki: ' + ctx.raw + ' orang'
                        }
                    }
                },
                scales: {
                    x: { grid: { color: gridColor }, ticks: { font: { size: 11 } } },
                    y: { grid: { color: gridColor }, beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } } }
                }
            }
        });
    }
    @endif

    // ── Monthly Chart ──
    @if(isset($monthlyData) && $monthlyData->count() > 0)
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlyData->pluck('month')) !!},
                datasets: [{
                    label: 'Jumlah Pendaki',
                    data: {!! json_encode($monthlyData->pluck('total_pendaki')) !!},
                    backgroundColor: (ctx) => {
                        const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(88,166,255,0.85)');
                        gradient.addColorStop(1, 'rgba(88,166,255,0.2)');
                        return gradient;
                    },
                    borderColor: 'rgba(88,166,255,0.9)',
                    borderWidth: 1,
                    borderRadius: 7,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#21262d',
                        borderColor: '#30363d', borderWidth: 1,
                        titleColor: '#e6edf3', bodyColor: '#8b949e',
                        padding: 12, cornerRadius: 10,
                        callbacks: {
                            label: ctx => '  Pendaki: ' + ctx.raw + ' orang'
                        }
                    }
                },
                scales: {
                    x: { grid: { color: gridColor }, ticks: { font: { size: 11 } } },
                    y: { grid: { color: gridColor }, beginAtZero: true, ticks: { font: { size: 11 } } }
                }
            }
        });
    }
    @endif
});
</script>

@endsection