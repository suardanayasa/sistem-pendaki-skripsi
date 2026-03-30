<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Monitoring Pendakian | Loket</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@600;700&display=swap" rel="stylesheet">

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
            --accent-red:     #f85149;
            --accent-amber:   #e3b341;
            --accent-orange:  #f9826c;
            --text-primary:   #e6edf3;
            --text-secondary: #8b949e;
            --text-muted:     #6e7681;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-base);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 28px 20px;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 16px 24px;
            margin-bottom: 28px;
        }
        .site-title {
            font-family: 'Sora', sans-serif;
            font-size: 20px; font-weight: 700;
            color: var(--text-primary); margin: 0;
        }
        .officer-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12px; color: var(--text-muted);
        }
        .officer-badge strong { color: var(--text-primary); }

        /* Notif bell */
        .notif-btn-wrap { position: relative; cursor: pointer; }
        .notif-btn {
            width: 40px; height: 40px; border-radius: 10px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            display: grid; place-items: center;
            font-size: 18px; color: var(--text-secondary);
            transition: all .2s;
        }
        .notif-btn:hover { border-color: var(--accent-teal); color: var(--accent-teal); }
        .notif-badge {
            position: absolute; top: -5px; right: -5px;
            background: var(--accent-red); color: #fff;
            font-size: 10px; font-weight: 700;
            padding: 2px 5px; border-radius: 50%;
            border: 2px solid var(--bg-base);
        }

        /* Notif dropdown */
        .notif-dropdown {
            display: none;
            position: fixed;
            top: auto;
            right: 20px;
            width: min(300px, calc(100vw - 40px));
            z-index: 99999;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 16px 48px rgba(0,0,0,.85);
            overflow: hidden;
        }
        .notif-dropdown-header {
            padding: 14px 16px;
            background: rgba(248,81,73,.12);
            border-bottom: 1px solid var(--border);
            font-weight: 700; color: var(--accent-red);
            font-size: 13px;
        }
        .notif-dropdown-body { padding: 20px; text-align: center; }

        /* Logout btn */
        .btn-logout {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; border-radius: 9px;
            background: rgba(248,81,73,.1);
            border: 1px solid rgba(248,81,73,.3);
            color: var(--accent-red);
            font-size: 13px; font-weight: 600;
            font-family: inherit; cursor: pointer;
            transition: all .2s;
        }
        .btn-logout:hover { background: rgba(248,81,73,.2); }

        /* ── ALERT OVERDUE ── */
        .alert-overdue {
            background: rgba(248,81,73,.08);
            border: 1px solid rgba(248,81,73,.35);
            border-radius: 12px; padding: 14px 18px;
            color: #ff7b72; font-size: 13px; font-weight: 500;
            margin-bottom: 24px;
        }

        /* ── MINI STATS ── */
        .mini-stat {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 20px;
            transition: border-color .2s, transform .2s;
        }
        .mini-stat:hover { border-color: var(--border-light); transform: translateY(-2px); }
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

        /* Search */
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
            color: var(--text-primary); width: 170px;
        }
        .search-wrap input::placeholder { color: var(--text-muted); }

        /* Dark Table */
        .dark-table { width: 100%; border-collapse: collapse; min-width: 950px; }
        .dark-table thead th {
            background: var(--bg-elevated);
            padding: 12px 18px;
            font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 1px;
            color: var(--text-muted); border: none;
            white-space: nowrap;
        }
        .dark-table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
        .dark-table tbody tr:hover { background: var(--bg-elevated); }
        .dark-table tbody tr.row-overdue { background: rgba(248,81,73,.04); }
        .dark-table tbody tr.row-overdue:hover { background: rgba(248,81,73,.08); }
        .dark-table tbody td { padding: 14px 18px; font-size: 13px; color: var(--text-secondary); border: none; vertical-align: middle; }

        /* Climber avatar */
        .climber-avatar {
            width: 36px; height: 36px; border-radius: 9px;
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-blue));
            display: grid; place-items: center;
            font-size: 12px; font-weight: 800; color: #fff;
            flex-shrink: 0; text-transform: uppercase;
        }
        .climber-avatar.overdue {
            background: linear-gradient(135deg, var(--accent-red), var(--accent-orange));
        }

        /* Status chips */
        .status-mountain {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(227,179,65,.1);
            border: 1px solid rgba(227,179,65,.25);
            color: var(--accent-amber);
            font-size: 11.5px; font-weight: 700;
            padding: 3px 10px; border-radius: 20px;
        }
        .status-mountain-dot {
            width: 6px; height: 6px; background: var(--accent-amber);
            border-radius: 50%; animation: pulse 2s infinite;
        }
        .status-overdue {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(248,81,73,.1);
            border: 1px solid rgba(248,81,73,.3);
            color: var(--accent-red);
            font-size: 11.5px; font-weight: 700;
            padding: 3px 10px; border-radius: 20px;
        }
        .status-done {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(63,185,80,.1);
            border: 1px solid rgba(63,185,80,.25);
            color: var(--accent-green);
            font-size: 11.5px; font-weight: 700;
            padding: 3px 10px; border-radius: 20px;
        }

        @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:.3;} }

        /* Time cell */
        .time-main { font-size: 13px; color: var(--text-primary); font-weight: 500; }
        .time-sub { font-size: 11px; color: var(--text-muted); margin-top: 2px; display: block; }

        /* Duration chip */
        .duration-chip {
            display: inline-flex; align-items: center; gap: 4px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            font-size: 11.5px; font-weight: 600;
            padding: 3px 10px; border-radius: 6px;
        }

        /* Phone chip */
        .phone-chip {
            font-family: monospace; font-weight: 600;
            font-size: 12.5px; color: var(--accent-blue);
        }

        /* Action buttons */
        .btn-finish {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(63,185,80,.12);
            border: 1px solid rgba(63,185,80,.3);
            color: var(--accent-green);
            font-size: 12px; font-weight: 700;
            padding: 6px 14px; border-radius: 8px;
            font-family: inherit; cursor: pointer;
            transition: all .2s;
        }
        .btn-finish:hover {
            background: rgba(63,185,80,.22);
            transform: translateY(-1px);
        }

        /* Table footer */
        .table-footer-bar {
            padding: 14px 22px;
            border-top: 1px solid var(--border);
            background: var(--bg-surface);
            font-size: 12.5px; color: var(--text-muted);
        }

        /* Shake animation for bell */
        .shake { animation: shake .5s infinite; }
        @keyframes shake { 0%,100%{transform:rotate(0);} 25%{transform:rotate(12deg);} 75%{transform:rotate(-12deg);} }
    </style>
</head>

<body>

@php
    $overdueCount = $climbings->whereNull('check_out_date')
        ->filter(fn($item) => \Carbon\Carbon::parse($item->check_in_date)->diffInHours(now()) > 30)
        ->count();

    $totalPendaki   = $climbings->count();
    $masihDiAtas    = $climbings->whereNull('check_out_date')->count();
    $sudahTurun     = $climbings->whereNotNull('check_out_date')->count();
@endphp

<div class="container-fluid" style="max-width:1280px;">

    {{-- ── OVERDUE ALERT ── --}}
    @if($overdueCount > 0)
    <div class="alert-overdue d-flex align-items-center gap-3">
        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
        <span><strong>Peringatan:</strong> Ada <strong>{{ $overdueCount }} pendaki</strong> yang terlambat turun melebihi 30 jam!</span>
    </div>
    @endif

    {{-- ── TOPBAR ── --}}
    <div class="topbar d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        {{-- Left --}}
        <div>
            <h1 class="site-title mb-1">Dashboard Ticket Counter</h1>
            <div class="officer-badge">
                <i class="bi bi-person-badge"></i>
                Petugas: <strong>{{ auth('ticket_counter')->user()->name }}</strong>
            </div>
        </div>

        {{-- Right --}}
        <div class="d-flex align-items-center gap-3">
            {{-- Notif bell --}}
            <div class="notif-btn-wrap" id="notifWrap">
                <div class="notif-btn {{ $overdueCount > 0 ? 'shake' : '' }}">
                    <i class="bi bi-bell-fill"></i>
                </div>
                @if($overdueCount > 0)
                    <span class="notif-badge">{{ $overdueCount }}</span>
                @endif

                <div class="notif-dropdown" id="notifDropdown">
                    <div class="notif-dropdown-header d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill"></i> Peringatan Keamanan
                    </div>
                    <div class="notif-dropdown-body">
                        @if($overdueCount > 0)
                            <div style="font-size:32px; margin-bottom:10px;">🚨</div>
                            <div style="color:var(--accent-red); font-weight:700; font-size:14px;">
                                {{ $overdueCount }} Pendaki Melewati Batas Waktu!
                            </div>
                            <div style="color:var(--text-muted); font-size:12px; margin-top:6px;">
                                Segera hubungi tim SAR atau petugas lapangan.
                            </div>
                        @else
                            <div style="font-size:32px; margin-bottom:10px;">✅</div>
                            <div style="color:var(--accent-green); font-weight:700; font-size:14px;">Semua pendaki aman.</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('ticket.logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </div>

    {{-- ── MINI STATS ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="mini-stat">
                <div class="mini-stat-label">Total Pendaki</div>
                <div class="mini-stat-value">{{ $totalPendaki }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="mini-stat">
                <div class="mini-stat-label">Masih di Atas</div>
                <div class="mini-stat-value" style="color:var(--accent-amber);">{{ $masihDiAtas }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="mini-stat">
                <div class="mini-stat-label">Sudah Turun</div>
                <div class="mini-stat-value" style="color:var(--accent-green);">{{ $sudahTurun }}</div>
            </div>
        </div>
    </div>

    {{-- ── TABLE CARD ── --}}
    <div class="table-card">
        {{-- Header --}}
        <div class="table-card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div style="font-size:14px; font-weight:700; color:var(--text-primary);">Log Pendakian</div>
                <div style="font-size:11.5px; color:var(--text-muted); margin-top:2px;">
                    Status real-time seluruh pendaki yang terdaftar
                </div>
            </div>
            <div class="search-wrap">
                <i class="bi bi-search" style="color:var(--text-muted); font-size:13px;"></i>
                <input type="text" id="searchInput" placeholder="Cari nama atau asal...">
            </div>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
            <table class="dark-table" id="mainTable">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Nama Pendaki</th>
                        <th>Kontak & Asal</th>
                        <th>Waktu Naik</th>
                        <th>Waktu Turun</th>
                        <th>Durasi</th>
                        <th>Guide / PJ</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($climbings as $climbing)
                    @php
                        $isOverdue = !$climbing->check_out_date &&
                            \Carbon\Carbon::parse($climbing->check_in_date)->diffInHours(now()) > 30;
                    @endphp
                    <tr class="{{ $isOverdue ? 'row-overdue' : '' }}">
                        {{-- No --}}
                        <td style="color:var(--text-muted); font-size:12px; font-weight:600;">
                            {{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Nama --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="climber-avatar {{ $isOverdue ? 'overdue' : '' }}">
                                    {{ strtoupper(substr($climbing->name, 0, 2)) }}
                                </div>
                                <span style="font-weight:600; color:var(--text-primary);">{{ $climbing->name }}</span>
                            </div>
                        </td>

                        {{-- Kontak --}}
                        <td>
                            <div class="phone-chip">{{ $climbing->phone_number ?? '—' }}</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:3px;">
                                <i class="bi bi-geo-alt me-1"></i>{{ $climbing->residence ?? '—' }}
                            </div>
                        </td>

                        {{-- Waktu Naik --}}
                        <td>
                            <div class="time-main">
                                {{ \Carbon\Carbon::parse($climbing->check_in_date)->timezone('Asia/Makassar')->format('d M Y') }}
                            </div>
                            <span class="time-sub">
                                <i class="bi bi-clock me-1"></i>
                                {{ \Carbon\Carbon::parse($climbing->check_in_date)->timezone('Asia/Makassar')->format('H:i') }} WITA
                            </span>
                        </td>

                        {{-- Waktu Turun --}}
                        <td>
                            @if($climbing->check_out_date)
                                <div class="time-main">
                                    {{ \Carbon\Carbon::parse($climbing->check_out_date)->timezone('Asia/Makassar')->format('d M Y') }}
                                </div>
                                <span class="time-sub">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($climbing->check_out_date)->timezone('Asia/Makassar')->format('H:i') }} WITA
                                </span>
                            @elseif($isOverdue)
                                <span class="status-overdue">
                                    <i class="bi bi-exclamation-triangle" style="font-size:10px;"></i> Terlambat!
                                </span>
                            @else
                                <span class="status-mountain">
                                    <span class="status-mountain-dot"></span> Di Gunung
                                </span>
                            @endif
                        </td>

                        {{-- Durasi --}}
                        <td>
                            <span class="duration-chip">
                                <i class="bi bi-hourglass-split" style="font-size:10px;"></i>
                                {{ $climbing->duration ?? '—' }}
                            </span>
                        </td>

                        {{-- Guide --}}
                        <td>
                            @if($climbing->group && $climbing->group->guide)
                                <div style="font-size:12.5px; color:var(--accent-teal); font-weight:600;">
                                    🪖 {{ $climbing->group->guide->name }}
                                </div>
                                <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">
                                    Grup: {{ $climbing->group->name }}
                                </div>
                            @else
                                <span style="color:var(--text-muted); font-size:12px; font-style:italic;">Tanpa Guide</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td style="text-align:center;">
                            @if(!$climbing->check_out_date)
                                <form action="{{ route('climbing.finish', $climbing->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-finish">
                                        <i class="bi bi-check2-circle"></i> Selesaikan
                                    </button>
                                </form>
                            @else
                                <span class="status-done">
                                    <i class="bi bi-check-circle-fill" style="font-size:10px;"></i> Selesai
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="table-footer-bar d-flex flex-wrap align-items-center justify-content-between gap-2">
            <span>
                Menampilkan <strong style="color:var(--text-primary);">{{ $totalPendaki }}</strong> pendaki
            </span>
            <div class="d-flex align-items-center gap-3" style="font-size:11.5px;">
                <span><span style="display:inline-block;width:8px;height:8px;background:var(--accent-amber);border-radius:50%;margin-right:5px;"></span>Di gunung</span>
                <span><span style="display:inline-block;width:8px;height:8px;background:var(--accent-red);border-radius:50%;margin-right:5px;"></span>Terlambat</span>
                <span><span style="display:inline-block;width:8px;height:8px;background:var(--accent-green);border-radius:50%;margin-right:5px;"></span>Selesai</span>
            </div>
        </div>
    </div>

</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ── Notif dropdown ──
    const notifWrap     = document.getElementById('notifWrap');
    const notifDropdown = document.getElementById('notifDropdown');

    notifWrap.addEventListener('click', function (e) {
        e.stopPropagation();
        const isVisible = notifDropdown.style.display === 'block';
        if (isVisible) {
            notifDropdown.style.display = 'none';
            return;
        }
        // Hitung posisi tepat di bawah tombol bell
        const rect = notifWrap.getBoundingClientRect();
        notifDropdown.style.top  = (rect.bottom + window.scrollY + 10) + 'px';

        const dropW = Math.min(300, window.innerWidth - 40);
        let leftPos = rect.right - dropW;
        if (leftPos < 20) leftPos = 20;
        notifDropdown.style.right = 'auto';
        notifDropdown.style.left  = leftPos + 'px';
        notifDropdown.style.width = dropW + 'px';
        notifDropdown.style.display = 'block';
    });

    document.addEventListener('click', (e) => {
        if (!notifWrap.contains(e.target)) {
            notifDropdown.style.display = 'none';
        }
    });

    // ── Live search ──
    document.getElementById('searchInput').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#mainTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>

</body>
</html>