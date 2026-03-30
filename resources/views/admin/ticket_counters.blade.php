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
        --accent-red:     #f85149;
        --accent-amber:   #e3b341;
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
    }
    .mini-stat:hover { border-color: var(--border-light); transform: translateY(-2px); }
    .mini-stat-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .8px; color: var(--text-muted); }
    .mini-stat-value { font-family: 'Sora', sans-serif; font-size: 26px; font-weight: 700; color: var(--text-primary); line-height: 1.1; margin-top: 4px; }

    /* ── FORM CARD ── */
    .form-card {
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
    }
    .form-card-header {
        background: var(--bg-elevated);
        border-bottom: 1px solid var(--border);
        padding: 18px 24px;
        display: flex; align-items: center; gap: 10px;
    }
    .form-card-body { padding: 24px; }

    /* Dark inputs */
    .dark-label {
        font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .8px;
        color: var(--text-muted); margin-bottom: 7px; display: block;
    }
    .dark-input {
        width: 100%;
        background: var(--bg-base);
        border: 1px solid var(--border);
        border-radius: 9px;
        color: var(--text-primary);
        padding: 10px 14px;
        font-family: inherit; font-size: 13.5px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .dark-input:focus {
        border-color: var(--accent-blue);
        box-shadow: 0 0 0 3px rgba(88,166,255,.12);
    }
    .dark-input::placeholder { color: var(--text-muted); }
    .dark-input[type="date"] { color-scheme: dark; }

    .btn-save {
        background: var(--accent-green);
        color: #0d1117;
        border: none; border-radius: 9px;
        font-weight: 700; font-size: 13px;
        padding: 11px 24px;
        transition: transform .2s, box-shadow .2s;
        width: 100%;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(63,185,80,.25);
        color: #0d1117;
    }

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
        color: var(--text-primary); width: 180px;
    }
    .search-wrap input::placeholder { color: var(--text-muted); }

    /* Dark Table */
    .dark-table { width: 100%; border-collapse: collapse; min-width: 900px; }
    .dark-table thead th {
        background: var(--bg-elevated);
        padding: 12px 20px;
        font-size: 11px; font-weight: 600;
        text-transform: uppercase; letter-spacing: 1px;
        color: var(--text-muted); border: none;
        white-space: nowrap;
    }
    .dark-table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
    .dark-table tbody tr:hover { background: var(--bg-elevated); }
    .dark-table tbody td { padding: 15px 20px; font-size: 13px; color: var(--text-secondary); border: none; vertical-align: middle; }

    /* Counter avatar */
    .counter-avatar {
        width: 38px; height: 38px; border-radius: 10px;
        background: linear-gradient(135deg, var(--accent-blue), var(--accent-teal));
        display: grid; place-items: center;
        font-size: 14px; font-weight: 800; color: #fff;
        flex-shrink: 0; text-transform: uppercase;
    }

    /* Status chips */
    .status-login {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(63,185,80,.1);
        border: 1px solid rgba(63,185,80,.25);
        color: var(--accent-green);
        font-size: 11.5px; font-weight: 700;
        padding: 3px 10px; border-radius: 20px;
    }
    .status-dot-green {
        width: 6px; height: 6px; background: var(--accent-green);
        border-radius: 50%; animation: pulse 2s infinite;
    }
    .status-logout {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(248,81,73,.1);
        border: 1px solid rgba(248,81,73,.25);
        color: var(--accent-red);
        font-size: 11.5px; font-weight: 700;
        padding: 3px 10px; border-radius: 20px;
    }
    .status-no-record {
        font-size: 12px; color: var(--text-muted); font-style: italic;
    }

    @keyframes pulse {
        0%,100% { opacity:1; } 50% { opacity:.3; }
    }

    /* Time sub text */
    .time-sub { font-size: 11px; color: var(--text-muted); margin-top: 4px; }

    /* Delete button */
    .action-del {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 7px;
        font-size: 12px; font-weight: 600; cursor: pointer;
        border: 1px solid rgba(248,81,73,.3);
        background: rgba(248,81,73,.08);
        color: var(--accent-red);
        font-family: inherit;
        transition: all .18s;
    }
    .action-del:hover { background: rgba(248,81,73,.18); }

    /* Alert */
    .alert-success-custom {
        background: rgba(63,185,80,.1);
        border: 1px solid var(--accent-green);
        color: var(--accent-green);
        border-radius: 10px; padding: 12px 16px;
        font-size: 13px;
    }
    .alert-error-custom {
        background: rgba(248,81,73,.1);
        border: 1px solid var(--accent-red);
        color: var(--accent-red);
        border-radius: 10px; padding: 12px 16px;
        font-size: 13px;
    }

    /* Table footer */
    .table-footer-bar {
        padding: 14px 22px;
        border-top: 1px solid var(--border);
        background: var(--bg-surface);
        font-size: 12.5px; color: var(--text-muted);
    }

    /* Empty state */
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
<div class="pt-1 mb-4">
    <h1 style="font-family:'Sora',sans-serif; font-size:24px; font-weight:700; color:var(--text-primary); margin:0;">
        Manajemen Penjaga Tiket
    </h1>
    <p style="color:var(--text-muted); font-size:13px; margin-top:4px; margin-bottom:0;">
        Tambah akun petugas dan pantau log aktivitas login/logout secara real-time.
    </p>
</div>

{{-- ── ALERTS ── --}}
@if(session('success'))
    <div class="alert-success-custom mb-4 d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert-error-custom mb-4 d-flex align-items-center gap-2">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    </div>
@endif

{{-- ── MINI STATS ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="mini-stat">
            <div class="mini-stat-label">Total Petugas</div>
            <div class="mini-stat-value">{{ $counters->count() }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mini-stat">
            <div class="mini-stat-label">Pernah Login</div>
            <div class="mini-stat-value" style="color:var(--accent-green);">
                {{ $counters->whereNotNull('last_login_at')->count() }}
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mini-stat">
            <div class="mini-stat-label">Sesi Selesai</div>
            <div class="mini-stat-value" style="color:var(--accent-red);">
                {{ $counters->whereNotNull('last_logout_at')->count() }}
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mini-stat">
            <div class="mini-stat-label">Belum Login</div>
            <div class="mini-stat-value" style="color:var(--accent-amber);">
                {{ $counters->whereNull('last_login_at')->count() }}
            </div>
        </div>
    </div>
</div>

{{-- ── FORM TAMBAH PETUGAS ── --}}
<div class="form-card mb-4">
    <div class="form-card-header">
        <i class="bi bi-person-plus-fill" style="color:var(--accent-green); font-size:17px;"></i>
        <span style="font-size:14px; font-weight:700; color:var(--text-primary);">Daftarkan Akun Penjaga Tiket Baru</span>
    </div>
    <div class="form-card-body">
        <form action="{{ route('admin.ticket-counter.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="dark-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="dark-input" placeholder="Nama petugas..." required>
                </div>
                <div class="col-12 col-md-6">
                    <label class="dark-label">E-mail Akun</label>
                    <input type="email" name="email" class="dark-input" placeholder="email@organisasi.com" required>
                </div>
                <div class="col-12 col-md-6">
                    <label class="dark-label">Kata Sandi</label>
                    <input type="password" name="password" class="dark-input" placeholder="Minimal 6 karakter..." required>
                </div>
                <div class="col-12 col-md-6">
                    <label class="dark-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="dark-input" required>
                </div>
                <div class="col-12">
                    <label class="dark-label">Alamat Domisili</label>
                    <textarea name="alamat" rows="2" class="dark-input" placeholder="Alamat lengkap petugas..." required></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn-save">
                        <i class="bi bi-person-check-fill me-2"></i> Daftarkan Akun Petugas
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ── TABLE CARD ── --}}
<div class="table-card">
    {{-- Header --}}
    <div class="table-card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <div style="font-size:14px; font-weight:700; color:var(--text-primary);">Log Aktivitas Monitoring</div>
            <div style="font-size:11.5px; color:var(--text-muted); margin-top:2px;">Status login & logout setiap petugas</div>
        </div>
        <div class="search-wrap">
            <i class="bi bi-search" style="color:var(--text-muted); font-size:13px;"></i>
            <input type="text" id="searchInput" placeholder="Cari nama atau email...">
        </div>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
        <table class="dark-table" id="counterTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Informasi Petugas</th>
                    <th>Alamat</th>
                    <th>Status Login</th>
                    <th>Status Logout</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($counters as $i => $counter)
                <tr>
                    {{-- No --}}
                    <td style="color:var(--text-muted); font-size:12px; font-weight:600;">
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </td>

                    {{-- Info --}}
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="counter-avatar">{{ strtoupper(substr($counter->name, 0, 2)) }}</div>
                            <div>
                                <div style="font-weight:600; color:var(--text-primary); font-size:14px;">{{ $counter->name }}</div>
                                <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">
                                    <i class="bi bi-envelope me-1"></i>{{ $counter->email }}
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Alamat --}}
                    <td>
                        <span style="font-size:12px; color:var(--text-muted);">
                            <i class="bi bi-geo-alt me-1"></i>{{ Str::limit($counter->address, 28) }}
                        </span>
                    </td>

                    {{-- Status Login --}}
                    <td>
                        @if($counter->last_login_at)
                            <span class="status-login">
                                <span class="status-dot-green"></span> Aktif Masuk
                            </span>
                            <div class="time-sub mt-1">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ \Carbon\Carbon::parse($counter->last_login_at)->timezone('Asia/Makassar')->format('d M Y') }}
                                &nbsp;·&nbsp;
                                {{ \Carbon\Carbon::parse($counter->last_login_at)->timezone('Asia/Makassar')->format('H:i:s') }} WITA
                            </div>
                        @else
                            <span class="status-no-record">Belum ada record</span>
                        @endif
                    </td>

                    {{-- Status Logout --}}
                    <td>
                        @if($counter->last_logout_at)
                            <span class="status-logout">
                                <i class="bi bi-box-arrow-right" style="font-size:10px;"></i> Sesi Selesai
                            </span>
                            <div class="time-sub mt-1">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ \Carbon\Carbon::parse($counter->last_logout_at)->timezone('Asia/Makassar')->format('d M Y') }}
                                &nbsp;·&nbsp;
                                {{ \Carbon\Carbon::parse($counter->last_logout_at)->timezone('Asia/Makassar')->format('H:i:s') }} WITA
                            </div>
                        @else
                            <span class="status-no-record">—</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td style="text-align:center;">
                        <form action="{{ route('admin.ticket-counter.destroy', $counter->id) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus petugas {{ addslashes($counter->name) }} dari organisasi?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-del">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="text-center py-5">
                            <div class="empty-icon">👮</div>
                            <div style="font-size:15px; font-weight:600; color:var(--text-primary); margin-bottom:6px;">
                                Belum ada akun penjaga tiket
                            </div>
                            <div style="font-size:13px; color:var(--text-muted);">
                                Daftarkan petugas pertama menggunakan form di atas.
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="table-footer-bar d-flex flex-wrap align-items-center justify-content-between gap-2">
        <span>
            Menampilkan <strong style="color:var(--text-primary);">{{ $counters->count() }}</strong> petugas
        </span>
        <div class="d-flex align-items-center gap-3" style="font-size:11.5px;">
            <span>
                <span style="display:inline-block; width:8px; height:8px; background:var(--accent-green); border-radius:50%; margin-right:5px;"></span>Login aktif
            </span>
            <span>
                <span style="display:inline-block; width:8px; height:8px; background:var(--accent-red); border-radius:50%; margin-right:5px;"></span>Sesi selesai
            </span>
        </div>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#counterTable tbody tr').forEach(row => {
            if (!row.querySelector('td[colspan]')) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            }
        });
    });
</script>

@endsection