@extends('admin.dashboardAdmin')

@section('content')

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
    /* ── VARIABLES ── */
    :root {
        --bg-base:        #0d1117;
        --bg-surface:     #161b22;
        --bg-elevated:    #1c2330;
        --bg-card:        #21262d;
        --border:         #30363d;
        --accent-teal:    #39d0c8;
        --accent-blue:    #58a6ff;
        --accent-red:     #f85149;
        --accent-purple:  #bc8cff;
        --accent-amber:   #e3b341;
        --text-primary:   #e6edf3;
        --text-secondary: #8b949e;
        --text-muted:     #6e7681;
    }

    /* ── MINI STAT CARDS ── */
    .mini-stat {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px 20px;
        transition: border-color .2s, transform .2s;
    }
    .mini-stat:hover { border-color: #3d444d; transform: translateY(-2px); }
    .mini-stat-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .8px; color: var(--text-muted); }
    .mini-stat-value { font-family: 'Sora', sans-serif; font-size: 26px; font-weight: 700; color: var(--text-primary); line-height: 1.1; margin-top: 4px; }

    /* ── TABLE CARD ── */
    .table-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; margin-top: 24px; }
    .table-card-header { background: var(--bg-surface); border-bottom: 1px solid var(--border); padding: 18px 24px; }

    /* Search Box */
    .search-wrap { display: flex; align-items: center; gap: 8px; background: var(--bg-elevated); border: 1px solid var(--border); border-radius: 8px; padding: 7px 13px; transition: border-color .2s; }
    .search-wrap:focus-within { border-color: var(--accent-teal); }
    .search-wrap input { background: none; border: none; outline: none; font-family: inherit; font-size: 13px; color: var(--text-primary); width: 200px; }

    /* Dark Table */
    .dark-table { width: 100%; border-collapse: collapse; min-width: 1000px; }
    .dark-table thead th { background: var(--bg-elevated); padding: 12px 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); border: none; white-space: nowrap; }
    .dark-table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
    .dark-table tbody tr:hover { background: var(--bg-elevated); }
    .dark-table tbody td { padding: 15px 20px; font-size: 13px; color: var(--text-secondary); border: none; vertical-align: middle; }

    /* Badges & Status */
    .badge-initial { width: 36px; height: 36px; border-radius: 9px; background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple)); display: grid; place-items: center; font-weight: 800; font-size: 12px; color: #fff; flex-shrink: 0; text-transform: uppercase; }
    
    .status-hiking { display: inline-flex; align-items: center; gap: 5px; background: rgba(249,130,108,.1); border: 1px solid rgba(249,130,108,.3); color: #f9826c; font-size: 11.5px; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
    .status-hiking::before { content: ''; width: 6px; height: 6px; background: #f9826c; border-radius: 50%; display: inline-block; animation: pulse 1.5s infinite; }
    
    .status-overdue { display: inline-flex; align-items: center; gap: 5px; background: rgba(248,81,73,.1); border: 1px solid var(--accent-red); color: var(--accent-red); font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 20px; }

    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .3; } }

    .time-main { font-size: 13px; color: var(--text-primary); font-weight: 500; }
    .time-sub  { font-size: 11px; color: var(--text-muted); margin-top: 2px; display: block; }
    .duration-chip { display: inline-flex; align-items: center; gap: 4px; background: rgba(227,179,65,.08); border: 1px solid rgba(227,179,65,.2); color: var(--accent-amber); font-size: 11.5px; font-weight: 600; padding: 3px 10px; border-radius: 6px; }

    .table-footer-bar { padding: 14px 22px; border-top: 1px solid var(--border); font-size: 12.5px; color: var(--text-muted); background: var(--bg-surface); }
</style>

{{-- ── PAGE HEADER ── --}}
<div class="pt-2 mb-4">
    <h1 style="font-family:'Sora',sans-serif; font-size:24px; font-weight:700; color:var(--text-primary); margin:0;">
        Data Seluruh Pendaki Bulan ini
    </h1>
    <p style="color:#8b949e; font-size:13px; margin-top:4px;">Monitoring status pendaftaran dan keamanan pendaki.</p>
</div>

{{-- ── MINI STAT CARDS ── --}}
<div class="row g-3 mb-2">
    <div class="col-6 col-md-3">
        <div class="mini-stat">
            <div class="mini-stat-label">Total Pendaki</div>
            <div class="mini-stat-value">{{ $climbings->count() }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mini-stat">
            <div class="mini-stat-label">Masih di Atas</div>
            <div class="mini-stat-value" style="color:#f9826c;">{{ $climbings->whereNull('check_out_date')->count() }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mini-stat">
            <div class="mini-stat-label">Sudah Turun</div>
            <div class="mini-stat-value" style="color:#3fb950;">{{ $climbings->whereNotNull('check_out_date')->count() }}</div>
        </div>
    </div>
</div>

{{-- ── TABLE CARD ── --}}
<div class="table-card">
    <div class="table-card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="search-wrap">
            <i class="bi bi-search" style="color:#6e7681; font-size:13px;"></i>
            <input type="text" id="searchInput" placeholder="Cari nama atau tiket...">
        </div>
    </div>

    <div style="overflow-x:auto;">
        <table class="dark-table" id="climbingTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pendaki</th>
                    <th>Asal</th>
                    <th>Jenis Tiket</th>
                    <th>Waktu Naik</th>
                    <th>Waktu Turun</th>
                    <th>Durasi</th>
                    <th>Guide</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($climbings as $key => $climbing)
                <tr>
                    <td>{{ str_pad($key + 1, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="badge-initial">{{ strtoupper(substr($climbing->name, 0, 2)) }}</div>
                            <span style="font-weight:600; color:#e6edf3;">{{ $climbing->name }}</span>
                        </div>
                    </td>
                    <td><span style="background:#1c2330; border:1px solid #30363d; border-radius:6px; padding:3px 9px; font-size:12px;">{{ $climbing->residence ?? '—' }}</span></td>
                    <td><span style="color:var(--accent-teal); font-size:12px;">🎫 {{ $climbing->ticket->name ?? 'N/A' }}</span></td>
                    
                    {{-- WAKTU NAIK --}}
                    <td>
                        <div class="time-main">{{ $climbing->created_at->timezone('Asia/Makassar')->format('d M Y') }}</div>
                        <span class="time-sub"><i class="bi bi-clock me-1"></i>{{ $climbing->created_at->timezone('Asia/Makassar')->format('H:i') }} WITA</span>
                    </td>

                    {{-- WAKTU TURUN (LOGIKA STATUS) --}}
                    <td>
                        @if($climbing->check_out_date)
                            {{-- JIKA SUDAH SELESAI PENDAKIAN --}}
                            <div class="time-main text-success" style="color: #3fb950 !important;">{{ \Carbon\Carbon::parse($climbing->check_out_date)->timezone('Asia/Makassar')->format('d M Y') }}</div>
                            <span class="time-sub">
                                <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($climbing->check_out_date)->timezone('Asia/Makassar')->format('H:i') }} WITA
                            </span>
                        @else
                            {{-- JIKA BELUM SELESAI --}}
                            @php
                                $jamMendaki = \Carbon\Carbon::parse($climbing->created_at)->diffInHours(now());
                            @endphp

                            @if($jamMendaki > 30)
                                <span class="status-overdue">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Terlambat!
                                </span>
                            @else
                                <span class="status-hiking">Masih di Atas</span>
                            @endif
                        @endif
                    </td>

                    <td>
                        @if($climbing->check_out_date)
                            <span class="duration-chip"><i class="bi bi-hourglass-split"></i> {{ \Carbon\Carbon::parse($climbing->created_at)->diffForHumans(\Carbon\Carbon::parse($climbing->check_out_date), true) }}</span>
                        @else
                            <span style="color:#6e7681; font-size:12px; font-style:italic;">Mendaki...</span>
                        @endif
                    </td>

                    <td>
                        @if($climbing->group) <span style="color:var(--accent-purple); font-weight:600;">🪖 {{ $climbing->group->guide->name ?? 'Guide' }}</span>
                        @elseif($climbing->guide) <span style="color:var(--accent-purple); font-weight:600;">👤 {{ $climbing->guide->name }}</span>
                        @else <span style="color:#6e7681;">— Tanpa Guide</span> @endif
                    </td>

                    <td style="text-align:center;">
                        <form action="{{ route('admin.climbing.destroy', $climbing->id) }}" method="POST" onsubmit="return confirm('Hapus data?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="padding:5px 12px; border-radius:7px; border:1px solid rgba(248,81,73,.3); background:rgba(248,81,73,.08); color:#f85149; cursor:pointer;"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-5">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer-bar d-flex justify-content-between">
        <span>Total: <strong>{{ $climbings->count() }}</strong> pendaki</span>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#climbingTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>

@endsection