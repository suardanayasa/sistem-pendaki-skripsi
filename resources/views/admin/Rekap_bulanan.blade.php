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
        --accent-red:     #f85149;
        --accent-purple:  #bc8cff;
        --text-primary:   #e6edf3;
        --text-secondary: #8b949e;
        --text-muted:     #6e7681;
    }

    /* ── MINI STATS ── */
    .mini-stat {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px 20px;
        transition: border-color .2s, transform .2s;
        position: relative; overflow: hidden;
    }
    .mini-stat:hover { border-color: var(--border-light); transform: translateY(-2px); }
    .mini-stat::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    }
    .mini-stat.s-teal::before   { background: var(--accent-teal); }
    .mini-stat.s-blue::before   { background: var(--accent-blue); }
    .mini-stat.s-green::before  { background: var(--accent-green); }
    .mini-stat.s-purple::before { background: var(--accent-purple); }

    .mini-stat-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .8px; color: var(--text-muted); }
    .mini-stat-value { font-family: 'Sora', sans-serif; font-size: 26px; font-weight: 700; color: var(--text-primary); line-height: 1.1; margin-top: 4px; }

    /* ── TABLE CARD ── */
    .table-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
    }
    .table-card-header {
        background: var(--bg-surface);
        border-bottom: 1px solid var(--border);
        padding: 18px 24px;
    }

    /* Search & Filter */
    .search-wrap {
        display: flex; align-items: center; gap: 8px;
        background: var(--bg-elevated);
        border: 1px solid var(--border);
        border-radius: 8px; padding: 7px 13px;
        transition: border-color .2s;
    }
    .search-wrap:focus-within { border-color: var(--accent-teal); }
    .search-wrap input {
        background: none; border: none; outline: none;
        font-family: inherit; font-size: 13px;
        color: var(--text-primary); width: 160px;
    }
    .search-wrap input::placeholder { color: var(--text-muted); }

    .filter-select {
        background: var(--bg-elevated); 
        border: 1px solid var(--border); 
        border-radius: 8px; 
        color: var(--text-primary); 
        padding: 7px 32px 7px 12px; 
        font-size: 12px; 
        font-family: inherit; 
        outline: none; 
        appearance: none; 
        cursor: pointer;
    }

    /* Dark Table */
    .dark-table { width: 100%; border-collapse: collapse; min-width: 700px; }
    .dark-table thead th {
        background: var(--bg-elevated);
        padding: 12px 22px;
        font-size: 11px; font-weight: 600;
        text-transform: uppercase; letter-spacing: 1px;
        color: var(--text-muted); border: none;
        white-space: nowrap;
    }
    .dark-table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
    .dark-table tbody tr:hover { background: var(--bg-elevated); }
    .dark-table tbody tr.row-current { background: rgba(57,208,200,.04); }
    .dark-table tbody tr.row-current:hover { background: rgba(57,208,200,.08); }
    .dark-table tbody td { padding: 15px 22px; font-size: 13.5px; color: var(--text-secondary); border: none; vertical-align: middle; }

    /* Month badge */
    .month-badge {
        display: inline-flex; align-items: center; gap: 7px;
        font-weight: 700; color: var(--text-primary); font-size: 14px;
    }
    .month-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: var(--accent-teal); flex-shrink: 0;
    }
    .current-badge {
        display: inline-flex; align-items: center; gap: 4px;
        background: rgba(57,208,200,.1);
        border: 1px solid rgba(57,208,200,.25);
        color: var(--accent-teal);
        font-size: 10px; font-weight: 700;
        padding: 2px 8px; border-radius: 20px;
        margin-left: 8px; text-transform: uppercase;
        animation: pulse 2s infinite;
    }
    @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:.5;} }

    /* Stat chips */
    .chip-pendaki {
        display: inline-flex; align-items: center; gap: 4px;
        background: rgba(88,166,255,.08);
        border: 1px solid rgba(88,166,255,.2);
        color: var(--accent-blue);
        font-size: 13px; font-weight: 700;
        padding: 3px 10px; border-radius: 6px;
    }
    .chip-domestik {
        display: inline-flex; align-items: center; gap: 4px;
        background: rgba(57,208,200,.08);
        border: 1px solid rgba(57,208,200,.2);
        color: var(--accent-teal);
        font-size: 12px; font-weight: 600;
        padding: 3px 9px; border-radius: 6px;
    }
    .chip-mancanegara {
        display: inline-flex; align-items: center; gap: 4px;
        background: rgba(249,130,108,.08);
        border: 1px solid rgba(249,130,108,.2);
        color: #f9826c;
        font-size: 12px; font-weight: 600;
        padding: 3px 9px; border-radius: 6px;
    }
    .chip-income {
        font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 13.5px;
        color: var(--accent-green);
    }

    .table-footer-bar {
        padding: 14px 22px;
        border-top: 1px solid var(--border);
        background: var(--bg-surface);
        font-size: 12.5px; color: var(--text-muted);
    }

    .empty-icon {
        width: 64px; height: 64px;
        background: var(--bg-elevated);
        border: 1px solid var(--border);
        border-radius: 16px;
        display: grid; place-items: center;
        font-size: 28px; margin: 0 auto 16px;
    }
</style>

{{-- ── PAGE HEADER ── --}}
<div class="pt-1 mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h1 style="font-family:'Sora',sans-serif; font-size:24px; font-weight:700; color:var(--text-primary); margin:0;">
            Rekap Bulanan
        </h1>
        <p style="color:var(--text-muted); font-size:13px; margin-top:4px; margin-bottom:0;">
            Ringkasan data pendakian, tiket, dan pendapatan per bulan.
        </p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.rekap.excel') }}" class="btn" style="background: var(--bg-card); border: 1px solid var(--border); color: var(--accent-green); font-size: 12px; font-weight: 600; padding: 8px 16px; border-radius: 8px; text-decoration: none; display: flex; align-items: center; gap: 6px;">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </a>
        <a href="{{ route('admin.rekap.pdf') }}" target="_blank" class="btn" style="background: var(--bg-card); border: 1px solid var(--border); color: #ff5f57; font-size: 12px; font-weight: 600; padding: 8px 16px; border-radius: 8px; text-decoration: none; display: flex; align-items: center; gap: 6px;">
            <i class="bi bi-file-earmark-pdf"></i> PDF
        </a>
    </div>
</div>

{{-- ── SUMMARY STATS ── --}}
@php
    $tahunSekarang = date('Y');
    $rekapTahunIni = $rekap->where('tahun', $tahunSekarang);
    $totalSemua    = $rekapTahunIni->sum('total_pendaki');
    $incSemua      = $rekapTahunIni->sum('total_pendapatan');
    $domSemua      = $rekapTahunIni->sum('total_domestik');
    $mancaSemua    = $rekapTahunIni->sum('total_mancanegara');
@endphp

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="mini-stat s-blue">
            <div class="mini-stat-label">Total Pendaki {{ $tahunSekarang }}</div>
            <div class="mini-stat-value">{{ $totalSemua }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mini-stat s-teal">
            <div class="mini-stat-label">Domestik {{ $tahunSekarang }}</div>
            <div class="mini-stat-value">{{ $domSemua }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mini-stat s-purple">
            <div class="mini-stat-label">Mancanegara {{ $tahunSekarang }}</div>
            <div class="mini-stat-value">{{ $mancaSemua }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mini-stat s-green">
            <div class="mini-stat-label">Pendapatan {{ $tahunSekarang }}</div>
            <div class="mini-stat-value" style="font-size:18px; padding-top:4px;">
                Rp {{ number_format($incSemua, 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>

{{-- ── TABLE CARD ── --}}
<div class="table-card">
    <div class="table-card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <div style="font-size:14px; font-weight:700; color:var(--text-primary);">Ringkasan Per Bulan</div>
            <div style="font-size:11.5px; color:var(--text-muted); margin-top:2px;">Semua tahun — diurutkan terbaru</div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div style="position:relative;">
                <select id="filterTahun" class="filter-select">
                    <option value="all">Semua Tahun</option>
                    @foreach($rekap->pluck('tahun')->unique()->sortDesc() as $thn)
                        <option value="{{ $thn }}" {{ $thn == $tahunSekarang ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>
                <i class="bi bi-chevron-down" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); color:var(--text-muted); pointer-events:none; font-size:12px;"></i>
            </div>
            <div class="search-wrap">
                <i class="bi bi-search" style="color:var(--text-muted); font-size:13px;"></i>
                <input type="text" id="searchInput" placeholder="Cari bulan...">
            </div>
        </div>
    </div>

    <div style="overflow-x:auto;">
        <table class="dark-table" id="rekapTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Periode</th>
                    <th>Total Pendaki</th>
                    <th>Domestik</th>
                    <th>Mancanegara</th>
                    <th>Total Pendapatan</th>
                    <th>Rata-rata/Hari</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekap as $i => $row)
                @php
                    $isCurrent = ($row->bulan == date('n') && $row->tahun == date('Y'));
                    $namabulan = \Carbon\Carbon::createFromDate($row->tahun, $row->bulan, 1)->translatedFormat('F');
                    $hariDalamBulan = \Carbon\Carbon::createFromDate($row->tahun, $row->bulan, 1)->daysInMonth;
                    $rataHari = $hariDalamBulan > 0 ? round($row->total_pendaki / $hariDalamBulan, 1) : 0;
                @endphp
                <tr class="{{ $isCurrent ? 'row-current' : '' }}" data-tahun="{{ $row->tahun }}">
                    <td style="color:var(--text-muted); font-size:12px; font-weight:600;">
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </td>
                    <td>
                        <div class="month-badge">
                            <span class="month-dot" style="{{ $isCurrent ? '' : 'background:var(--text-muted);' }}"></span>
                            {{ $namabulan }} {{ $row->tahun }}
                        </div>
                        @if($isCurrent)
                            <span class="current-badge"><i class="bi bi-circle-fill" style="font-size:6px;"></i> Berjalan</span>
                        @endif
                    </td>
                    <td>
                        <span class="chip-pendaki">
                            <i class="bi bi-people-fill" style="font-size:11px;"></i>
                            {{ $row->total_pendaki }}
                        </span>
                    </td>
                    <td>
                        <span class="chip-domestik">
                            🇮🇩 {{ $row->total_domestik }}
                        </span>
                    </td>
                    <td>
                        <span class="chip-mancanegara">
                            🌍 {{ $row->total_mancanegara }}
                        </span>
                    </td>
                    <td>
                        <span class="chip-income">
                            Rp {{ number_format($row->total_pendapatan, 0, ',', '.') }}
                        </span>
                    </td>
                    <td>
                        <span style="font-size:13px; color:var(--text-secondary);">
                            {{ $rataHari }} <span style="font-size:11px; color:var(--text-muted);">pendaki/hari</span>
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="text-center py-5">
                            <div class="empty-icon">📅</div>
                            <div style="font-size:15px; font-weight:600; color:var(--text-primary); margin-bottom:6px;">Belum ada data rekap</div>
                            <div style="font-size:13px; color:var(--text-muted);">Data akan muncul setelah ada pendaki yang mendaftar.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer-bar d-flex flex-wrap align-items-center justify-content-between gap-2">
        <span>
            Menampilkan <strong style="color:var(--text-primary);" id="rowCount">{{ $rekap->count() }}</strong> bulan
        </span>
        <div class="d-flex align-items-center gap-2" style="font-size:11.5px;">
            <span style="display:inline-block; width:8px; height:8px; background:var(--accent-teal); border-radius:50%; margin-right:4px;"></span>
            Bulan berjalan
        </div>
    </div>
</div>

<script>
    const filterTahun = document.getElementById('filterTahun');
    const searchInput = document.getElementById('searchInput');

    function filterTable() {
        const tahun = filterTahun.value;
        const query = searchInput.value.toLowerCase();
        let visible = 0;

        document.querySelectorAll('#rekapTable tbody tr[data-tahun]').forEach(row => {
            const matchTahun = tahun === 'all' || row.dataset.tahun === tahun;
            const matchQuery = row.textContent.toLowerCase().includes(query);
            const show = matchTahun && matchQuery;
            
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        document.getElementById('rowCount').textContent = visible;
    }

    filterTahun.addEventListener('change', filterTable);
    searchInput.addEventListener('input', filterTable);

    // Jalankan filter awal sesuai default select
    filterTable();
</script>

@endsection