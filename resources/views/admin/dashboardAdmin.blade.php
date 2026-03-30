<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Pendakian</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Chart.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* ── ROOT VARIABLES ── */
        :root {
            --bg-base:      #0d1117;
            --bg-surface:   #161b22;
            --bg-elevated:  #1c2330;
            --bg-card:      #21262d;
            --border:       #30363d;
            --border-light: #3d444d;
            --accent-green:  #3fb950;
            --accent-teal:   #39d0c8;
            --accent-blue:   #58a6ff;
            --accent-amber:  #e3b341;
            --accent-red:    #f85149;
            --accent-purple: #bc8cff;
            --text-primary:   #e6edf3;
            --text-secondary: #8b949e;
            --text-muted:     #6e7681;
            --sidebar-w:    240px;
        }

        /* ── BASE ── */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-base);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        #sidebar {
            width: var(--sidebar-w);
            background: var(--bg-surface);
            border-right: 1px solid var(--border);
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
        }

        #sidebarOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.6);
            backdrop-filter: blur(2px);
            z-index: 1030;
            opacity: 0;
            transition: opacity .3s ease;
        }
        #sidebarOverlay.active { display: block; opacity: 1; }

        .sidebar-logo {
            padding: 24px 20px 20px;
            border-bottom: 1px solid var(--border);
        }
        .logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-blue));
            border-radius: 10px;
            display: grid; place-items: center;
            font-size: 18px;
        }
        .logo-text {
            font-family: 'Sora', sans-serif;
            font-size: 15px; font-weight: 700;
            color: var(--text-primary);
        }
        .logo-sub {
            font-size: 10px; color: var(--text-muted);
            letter-spacing: 1.5px; text-transform: uppercase;
        }

        /* Sidebar nav items */
        .sidebar-nav { padding: 20px 12px; flex: 1; overflow-y: auto; }
        .nav-section-label {
            font-size: 10px; font-weight: 600;
            letter-spacing: 1.8px; text-transform: uppercase;
            color: var(--text-muted);
            padding: 0 8px; margin: 16px 0 8px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px;
            font-size: 13.5px; font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all .18s ease;
            margin-bottom: 2px;
        }
        .sidebar-link:hover { background: var(--bg-elevated); color: var(--text-primary); }
        .sidebar-link.active { background: rgba(57,208,200,.12); color: var(--accent-teal); }
        .sidebar-link .nav-icon { font-size: 16px; width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border);
        }
        .logout-btn {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px;
            font-size: 13px; font-weight: 500;
            color: var(--accent-red);
            background: none; border: none; width: 100%;
            font-family: inherit; cursor: pointer;
            transition: background .18s;
        }
        .logout-btn:hover { background: rgba(248,81,73,.1); }

        /* ── MAIN WRAPPER ── */
        #mainWrapper {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: var(--bg-surface);
            border-bottom: 1px solid var(--border);
            height: 64px;
            position: sticky; top: 0; z-index: 1020;
            padding: 0 28px;
        }
        .user-chip {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 6px 12px 6px 6px;
            cursor: pointer;
            transition: border-color .18s;
        }
        .user-chip:hover { border-color: var(--border-light); }
        .user-avatar {
            width: 30px; height: 30px; border-radius: 8px;
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-blue));
            display: grid; place-items: center;
            font-size: 12px; font-weight: 700; color: #fff;
        }
        .user-name  { font-size: 13px; font-weight: 600; color: var(--text-primary); line-height: 1; }
        .user-role  { font-size: 10.5px; color: var(--text-muted); margin-top: 2px; }

        .notif-wrap { position: relative; cursor: pointer; }
        .notif-icon-btn {
            width: 36px; height: 36px; border-radius: 8px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            display: grid; place-items: center;
            color: var(--text-secondary); font-size: 18px;
            transition: all .18s;
        }
        .notif-icon-btn:hover { border-color: var(--accent-teal); color: var(--accent-teal); }
        .notif-badge {
            position: absolute; top: -5px; right: -5px;
            background: var(--accent-red); color: #fff;
            border-radius: 50%; padding: 2px 5px;
            font-size: 10px; font-weight: 700;
            border: 2px solid var(--bg-base);
        }
        .notif-dropdown {
            display: none;
            position: absolute; top: 45px; right: 0;
            width: 300px;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 12px; z-index: 2000;
            box-shadow: 0 10px 30px rgba(0,0,0,.6);
            overflow: hidden;
        }
        .notif-dropdown-header {
            padding: 14px;
            background: rgba(248,81,73,.1);
            border-bottom: 1px solid var(--border);
            font-weight: 700; color: var(--accent-red);
        }
        .notif-dropdown-body { max-height: 350px; overflow-y: auto; }
        .notif-item { padding: 12px; border-bottom: 1px solid var(--bg-card); }
        .notif-item-name { color: #fff; font-weight: 600; font-size: 14px; }
        .notif-item-sub  { color: var(--text-muted); font-size: 11px; margin-top: 2px; }

        /* ── CONTENT AREA ── */
        .content-area { padding: 28px; flex: 1; }
        .page-title {
            font-family: 'Sora', sans-serif;
            font-size: 22px; font-weight: 700; color: var(--text-primary);
        }
        .page-subtitle { font-size: 13px; color: var(--text-muted); }

        /* ── STAT CARDS ── */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            position: relative; overflow: hidden;
            transition: border-color .2s, transform .2s;
            cursor: default;
        }
        .stat-card:hover { border-color: var(--border-light); transform: translateY(-2px); }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
        }
        .stat-card.green::before { background: var(--accent-green); }
        .stat-card.teal::before  { background: var(--accent-teal); }
        .stat-card.blue::before  { background: var(--accent-blue); }
        .stat-card.amber::before { background: var(--accent-amber); }

        .stat-label {
            font-size: 11.5px; font-weight: 600;
            letter-spacing: .6px; text-transform: uppercase;
            color: var(--text-muted);
        }
        .stat-icon {
            width: 34px; height: 34px; border-radius: 9px;
            display: grid; place-items: center; font-size: 16px;
        }
        .stat-card.green .stat-icon { background: rgba(63,185,80,.15);  color: var(--accent-green); }
        .stat-card.teal  .stat-icon { background: rgba(57,208,200,.15); color: var(--accent-teal); }
        .stat-card.blue  .stat-icon { background: rgba(88,166,255,.15); color: var(--accent-blue); }
        .stat-card.amber .stat-icon { background: rgba(227,179,65,.15); color: var(--accent-amber); }

        .stat-value {
            font-family: 'Sora', sans-serif;
            font-size: 26px; font-weight: 700;
            color: var(--text-primary); line-height: 1; margin-bottom: 6px;
        }

        /* ── CHART CARDS ── */
        .chart-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 22px;
            min-width: 0;
        }
        .chart-title    { font-size: 14px; font-weight: 700; color: var(--text-primary); }
        .chart-subtitle { font-size: 11.5px; color: var(--text-secondary); margin-top: 2px; }
        .chart-badge {
            font-size: 11px; font-weight: 600;
            padding: 3px 9px; border-radius: 20px;
        }
        .chart-badge.teal { background: rgba(57,208,200,.15); color: var(--accent-teal); }
        .chart-badge.blue { background: rgba(88,166,255,.15); color: var(--accent-blue); }
        .chart-responsive { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; padding-bottom: 10px; }
        .chart-wrap { position: relative; height: 250px; min-width: 500px; width: 100%; }

        /* ── TABLE CARD ── */
        .table-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }
        .table-card-header {
            border-bottom: 1px solid var(--border);
            padding: 20px 22px;
        }
        .table-title { font-size: 14px; font-weight: 700; color: var(--text-primary); }
        .table-desc  { font-size: 11.5px; color: var(--text-muted); margin-top: 2px; }

        .search-box {
            display: flex; align-items: center; gap: 8px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 8px; padding: 7px 12px;
            transition: border-color .18s;
        }
        .search-box:focus-within { border-color: var(--accent-teal); }
        .search-box input {
            background: none; border: none; outline: none;
            font-family: inherit; font-size: 13px;
            color: var(--text-primary); width: 180px;
        }

        /* Override Bootstrap table for dark theme */
        .dark-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
            color: var(--text-secondary);
        }
        .dark-table thead th {
            background: var(--bg-elevated);
            padding: 11px 22px;
            font-size: 11px; font-weight: 600;
            letter-spacing: 1px; text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            white-space: nowrap; border-top: none;
        }
        .dark-table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
        .dark-table tbody tr:hover { background: var(--bg-elevated); }
        .dark-table tbody td { padding: 13px 22px; font-size: 13.5px; white-space: nowrap; border: none; }

        .td-name { display: flex; align-items: center; gap: 10px; }
        .avatar-sm {
            width: 30px; height: 30px; border-radius: 8px;
            display: grid; place-items: center;
            font-size: 12px; font-weight: 700;
            flex-shrink: 0; color: #fff;
        }
        .av-2 { background: linear-gradient(135deg, #3fb950, #39d0c8); }
        .av-3 { background: linear-gradient(135deg, #e3b341, #f85149); }

        .name-text   { font-weight: 600; color: var(--text-primary); }
        .badge-origin {
            display: inline-block; padding: 2px 8px; border-radius: 20px;
            font-size: 11px; font-weight: 500;
            background: var(--bg-elevated); color: var(--text-secondary);
            border: 1px solid var(--border);
        }
        .badge-guide {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 9px; border-radius: 20px;
            font-size: 11.5px; font-weight: 600;
            background: rgba(88,166,255,.1); color: var(--accent-blue);
        }

        .table-footer-bar {
            padding: 14px 22px;
            border-top: 1px solid var(--border);
            font-size: 12.5px; color: var(--text-muted);
        }
        .page-btn {
            padding: 4px 10px; border-radius: 6px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            font-size: 12.5px; cursor: pointer;
            transition: all .15s;
        }
        .page-btn:hover, .page-btn.active {
            background: rgba(57,208,200,.15);
            border-color: var(--accent-teal);
            color: var(--accent-teal);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.active { transform: translateX(0); }
            #mainWrapper { margin-left: 0; }
            .topbar { padding: 0 16px; }
            .header-brand { display: none; }
            .content-area { padding: 16px; }
            .user-info { display: none; }
        }
        @media (max-width: 1024px) {
            .header-date { display: none; }
        }
    </style>

    @stack('styles')
</head>

<body>

{{-- ── SIDEBAR OVERLAY ── --}}
<div id="sidebarOverlay"></div>

{{-- ── SIDEBAR ── --}}
<aside id="sidebar">
    <div class="sidebar-logo">
        <div class="d-flex align-items-center gap-2">
            <div class="logo-icon">⛰️</div>
            <div>
                <div class="logo-text">SummitAdmin</div>
                <div class="logo-sub">Manajemen Pendakian</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Core</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>

        <div class="nav-section-label">Data</div>
        <a href="{{ route('admin.climbing') }}" class="sidebar-link {{ request()->routeIs('admin.climbing') ? 'active' : '' }}">
            <span class="nav-icon">🧗</span> Pendaki
        </a>
        <a href="{{ route('admin.tiket') }}" class="sidebar-link {{ request()->routeIs('admin.tiket') ? 'active' : '' }}">
            <span class="nav-icon">🎫</span> Monitoring Tiket
        </a>
        <a href="{{ route('admin.guide.index') }}" class="sidebar-link {{ request()->routeIs('admin.guide.index') ? 'active' : '' }}">
            <span class="nav-icon">🪖</span> Guide
        </a>
        <a href="{{ route('admin.group.index') }}" class="sidebar-link {{ request()->routeIs('admin.group.index') ? 'active' : '' }}">
            <span class="nav-icon">👥</span> Grup Pendakian
        </a>

        <div class="nav-section-label">Laporan</div>
        <a href="{{ route('admin.statistik') }}" class="sidebar-link {{ Request::is('admin/statistik') ? 'active' : '' }}">
            <span class="nav-icon">📈</span> Statistik
        </a>
        <a href="{{ route('admin.keuangan') }}" class="sidebar-link {{ Request::is('admin/keuangan') ? 'active' : '' }}">
            <span class="nav-icon">💰</span> Keuangan
        </a>
        <a href="{{ route('admin.ticket-counter.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.ticket-counter.*') ? 'active' : '' }}">
            <span class="nav-icon">👮</span>
            <span>Penjaga Tiket</span>
            @if(isset($counters) && $counters->count() > 0)
                <span class="ms-auto badge" style="background:#238636; font-size:10px;">
                    {{ $counters->count() }}
                </span>
            @endif
        </a>
        <a href="{{ route('admin.rekap') }}"
           class="sidebar-link {{ request()->routeIs('admin.rekap') ? 'active' : '' }}">
            <span class="nav-icon">📅</span> Rekap Bulanan
        </a>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <span>🚪</span> Logout
            </button>
        </form>
    </div>
</aside>

{{-- ── MAIN WRAPPER ── --}}
<div id="mainWrapper">

    {{-- ── TOPBAR ── --}}
    <header class="topbar d-flex align-items-center justify-content-between">
        {{-- Left --}}
        <div class="d-flex align-items-center gap-3">
            <button class="btn p-0 d-md-none" id="mobileToggle" style="color:var(--text-primary); font-size:24px;">☰</button>
            <span class="header-brand fw-bold" style="font-family:'Sora',sans-serif; font-size:16px; color:var(--text-primary);">Admin</span>
        </div>

        {{-- Right --}}
        <div class="d-flex align-items-center gap-3">
            <span class="header-date" style="font-size:12px; color:var(--text-muted);" id="headerDate"></span>

            {{-- Report Buttons --}}
            <div class="d-flex gap-2">
                <a href="{{ route('admin.report.excel') }}"
                   class="btn btn-sm fw-semibold"
                   style="background:rgba(63,185,80,.1); border:1px solid #238636; color:var(--accent-green); font-size:12px;">
                    📊 Excel
                </a>
                <a href="{{ route('admin.report.pdf') }}"
                   class="btn btn-sm fw-semibold"
                   style="background:rgba(248,81,73,.1); border:1px solid #da3633; color:var(--accent-red); font-size:12px;">
                    📄 PDF
                </a>
            </div>

            {{-- Notif Bell --}}
            <div class="notif-wrap" id="notifBtn">
                <div class="notif-icon-btn">🔔</div>
                @if(isset($notifCount) && $notifCount > 0)
                    <span class="notif-badge">{{ $notifCount }}</span>
                @endif

                <div class="notif-dropdown" id="notifDropdown">
                    <div class="notif-dropdown-header d-flex align-items-center gap-2">
                        <span>⚠️</span> Peringatan Keamanan
                    </div>
                    <div class="notif-dropdown-body">
                        @if(isset($overdueClimbers) && $overdueClimbers->count() > 0)
                            @foreach($overdueClimbers as $climber)
                                <div class="notif-item">
                                    <div class="notif-item-name">{{ $climber->name }}</div>
                                    <div class="notif-item-sub">Mulai: {{ $climber->created_at->format('d M, H:i') }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4" style="color:var(--text-muted);">
                                <div style="font-size:24px; margin-bottom:10px;">✅</div>
                                <div style="font-size:13px;">Semua pendaki aman.</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- User Chip --}}
            <div class="user-chip d-flex align-items-center gap-2">
                <div class="user-avatar">A</div>
                <div class="user-info">
                    <div class="user-name">{{ auth('admin')->user()->name ?? 'Admin' }}</div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>
        </div>
    </header>

    {{-- ── CONTENT ── --}}
    <div class="content-area">

        @if(Request::routeIs('admin.dashboard'))

            <div class="page-title mb-1">Dashboard</div>
            <div class="page-subtitle mb-4">Selamat datang kembali. Berikut ringkasan aktivitas hari ini.</div>

            {{-- STAT CARDS --}}
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card green">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="stat-label">Total Pendaki Bulan Ini</span>
                            <div class="stat-icon">🧗</div>
                        </div>
                        <div class="stat-value">{{ count($climbings ?? []) }}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card teal">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="stat-label">Tiket Terjual Bulan Ini</span>
                            <div class="stat-icon">🎫</div>
                        </div>
                        <div class="stat-value">{{ count($climbings ?? []) }}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card blue">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="stat-label">Jumlah Guide</span>
                            <div class="stat-icon">🪖</div>
                        </div>
                        <div class="stat-value">{{ count($guides ?? []) }}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card amber">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="stat-label">Total Penjualan Bulan ini</span>
                            <div class="stat-icon">💰</div>
                        </div>
                        <div class="stat-value" style="font-size:20px;">Rp. {{ number_format($income ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            {{-- CHARTS --}}
            <div class="row g-3 mb-4">
                <div class="col-12 col-lg-6">
                    <div class="chart-card">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <div class="chart-title">Pendaki Harian</div>
                                <div class="chart-subtitle">30 hari terakhir</div>
                            </div>
                            <span class="chart-badge teal">Harian</span>
                        </div>
                        <div class="chart-responsive">
                            <div class="chart-wrap">
                                <canvas id="dailyChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="chart-card">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <div class="chart-title">Penjualan Bulanan</div>
                                <div class="chart-subtitle">Tahun {{ date('Y') }}</div>
                            </div>
                            <span class="chart-badge blue">Bulanan</span>
                        </div>
                        <div class="chart-responsive">
                            <div class="chart-wrap">
                                <canvas id="monthlyChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-card">
                <div class="table-card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <div class="table-title">Daftar Pendaki Terdaftar Bulan Ini</div>
                        <div class="table-desc">Semua pendaki yang telah melakukan registrasi</div>
                    </div>
                    <div class="search-box">
                        <span>🔍</span>
                        <input type="text" id="searchInput" placeholder="Cari pendaki...">
                    </div>
                </div>

                <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
                    <table class="dark-table" id="climbingTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Asal</th>
                                <th>No Hp</th>
                                <th>Tiket</th>
                                <th>Waktu Naik</th>
                                <th>Waktu Turun</th>
                                <th>Guide</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($climbings))
                                @foreach ($climbings as $climbing)
                                <tr>
                                    <td style="color: #8b949e;">{{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>
                                        <div class="td-name">
                                            @if ($climbing->check_out_date)
                                                <div class="avatar-sm av-2">DN</div>
                                            @else
                                                <div class="avatar-sm av-3">CL</div>
                                            @endif
                                            <span class="name-text">{{ $climbing->name }}</span>
                                        </div>
                                    </td>
                                    <td><span class="badge-origin">{{ $climbing->residence }}</span></td>
                                    <td>{{ $climbing->phone_number }}</td>
                                    <td>{{ $climbing->ticket->name ?? '-' }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($climbing->check_in_date)->timezone('Asia/Makassar')->format('d M Y') }}
                                        <div style="font-size: 11px; color: #8b949e; margin-top: 2px;">
                                            Jam: {{ \Carbon\Carbon::parse($climbing->check_in_date)->timezone('Asia/Makassar')->format('H:i') }} WITA
                                        </div>
                                    </td>
                                    <td>
                                        @if ($climbing->check_out_date)
                                            {{ \Carbon\Carbon::parse($climbing->check_out_date)->timezone('Asia/Makassar')->format('d M Y') }}
                                            <div style="font-size: 11px; color: #8b949e; margin-top: 2px;">
                                                Jam: {{ \Carbon\Carbon::parse($climbing->check_out_date)->timezone('Asia/Makassar')->format('H:i') }} WITA
                                            </div>
                                        @else
                                            {{-- LOGIKA PERINGATAN 30 JAM --}}
                                            @if(\Carbon\Carbon::parse($climbing->check_in_date)->diffInHours(now()) > 30)
                                                <span class="badge" style="background: rgba(248,81,73,.1); border: 1px solid var(--accent-red); color: var(--accent-red); padding: 4px 8px; border-radius: 6px; font-weight: 600;">
                                                    ⚠️ Terlambat!
                                                </span>
                                            @else
                                                <span style="color:#ed8936; font-weight: 600;">⛰️ Di Puncak</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td><span class="badge-guide">{{ $climbing->group->guide->name ?? '-' }}</span></td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="table-footer-bar d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <span>Menampilkan data pendaki terbaru</span>
                    <div class="d-flex gap-1">
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">›</button>
                    </div>
                </div>
            </div>

        @else

            {{-- ══════════════════════════════════════════════════════
                 KONTEN HALAMAN LAIN
                 Setiap view (climbing, guide, group, statistik, dll)
                 harus menggunakan:
                   @extends('admin.dashboardAdmin')
                   @section('content') ... @endsection
            ══════════════════════════════════════════════════════ --}}
            @yield('content')

        @endif

    </div>{{-- end .content-area --}}

</div>{{-- end #mainWrapper --}}

{{-- Bootstrap 5 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // ── 1. SIDEBAR HAMBURGER ──
    const mobileToggle = document.getElementById('mobileToggle');
    const sidebar      = document.getElementById('sidebar');
    const overlay      = document.getElementById('sidebarOverlay');

    if (mobileToggle && sidebar && overlay) {
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        });
    }

    // ── 2. NOTIF DROPDOWN ──
    const notifBtn      = document.getElementById('notifBtn');
    const notifDropdown = document.getElementById('notifDropdown');

    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isVisible = notifDropdown.style.display === 'block';
            notifDropdown.style.display = isVisible ? 'none' : 'block';
        });
        document.addEventListener('click', function (e) {
            if (!notifBtn.contains(e.target)) {
                notifDropdown.style.display = 'none';
            }
        });
    }

    // ── 3. DATE ──
    const dateEl = document.getElementById('headerDate');
    if (dateEl) {
        dateEl.textContent = new Date().toLocaleDateString('id-ID', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
    }

    // ── 4. CHARTS ──
    if (typeof Chart !== 'undefined') {
        Chart.defaults.color       = '#8b949e';
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

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
                        backgroundColor: 'rgba(57,208,200,0.08)',
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#39d0c8',
                        tension: 0.45,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: ctx => 'Jumlah Pendaki: ' + ctx.raw } }
                    },
                    scales: {
                        x: { grid: { color: '#30363d' }, ticks: { font: { size: 10.5 } } },
                        y: { grid: { color: '#30363d' }, beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        }
        @endif

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
                        backgroundColor: 'rgba(88,166,255,0.7)',
                        borderColor:     'rgba(88,166,255,0.9)',
                        borderWidth: 1,
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { color: '#30363d' }, ticks: { font: { size: 10.5 } } },
                        y: { grid: { color: '#30363d' }, beginAtZero: true }
                    }
                }
            });
        }
        @endif
    }

    // ── 5. SEARCH TABLE ──
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#climbingTable tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    }
});
</script>

@stack('scripts')

</body>
</html>