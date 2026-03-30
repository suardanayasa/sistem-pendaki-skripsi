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
        --text-primary:   #e6edf3;
        --text-secondary: #8b949e;
        --text-muted:     #6e7681;
    }

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
    }
    .form-card-body { padding: 24px; }

    /* Dark inputs */
    .dark-label {
        font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .8px;
        color: var(--text-muted); margin-bottom: 7px;
        display: block;
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
        appearance: none; -webkit-appearance: none;
    }
    .dark-input:focus {
        border-color: var(--accent-blue);
        box-shadow: 0 0 0 3px rgba(88,166,255,.12);
    }
    .dark-input::placeholder { color: var(--text-muted); }

    /* Custom select arrow */
    .select-wrap { position: relative; }
    .select-wrap::after {
        content: '\F282';
        font-family: 'bootstrap-icons';
        position: absolute; right: 13px; top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted); pointer-events: none;
        font-size: 14px;
    }
    .select-wrap .dark-input { padding-right: 38px; cursor: pointer; }
    .dark-input option { background: var(--bg-surface); color: var(--text-primary); }

    /* Submit btn */
    .btn-save {
        background: var(--accent-green);
        color: #0d1117;
        border: none; border-radius: 9px;
        font-weight: 700; font-size: 13px;
        padding: 11px 24px;
        white-space: nowrap;
        transition: transform .2s, box-shadow .2s;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(63,185,80,.25);
        color: #0d1117;
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
        color: var(--text-primary); width: 180px;
    }
    .search-wrap input::placeholder { color: var(--text-muted); }

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
    .dark-table tbody td { padding: 15px 22px; font-size: 13.5px; color: var(--text-secondary); border: none; vertical-align: middle; }

    /* Group name chip */
    .group-chip {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(88,166,255,.08);
        border: 1px solid rgba(88,166,255,.2);
        color: var(--accent-blue);
        font-size: 13px; font-weight: 600;
        padding: 4px 12px; border-radius: 8px;
    }

    /* Guide chip */
    .guide-chip {
        display: inline-flex; align-items: center; gap: 6px;
        color: var(--accent-amber); font-weight: 600; font-size: 13px;
    }

    /* Status badge */
    .status-aktif {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(57,208,200,.08);
        border: 1px solid rgba(57,208,200,.2);
        color: var(--accent-teal);
        font-size: 11.5px; font-weight: 600;
        padding: 3px 10px; border-radius: 20px;
    }
    .status-dot {
        width: 6px; height: 6px;
        background: var(--accent-teal); border-radius: 50%;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%,100% { opacity:1; } 50% { opacity:.3; }
    }

    /* Alert */
    .alert-success-custom {
        background: rgba(63,185,80,.1);
        border: 1px solid var(--accent-green);
        color: var(--accent-green);
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
        Groups Pendakian
    </h1>
    <p style="color:var(--text-muted); font-size:13px; margin-top:4px; margin-bottom:0;">
        Kelola daftar rombongan dan tentukan Guide penanggung jawab.
    </p>
</div>

{{-- ── ALERT ── --}}
@if(session('success'))
    <div class="alert-success-custom mb-4 d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
@endif

{{-- ── MINI STATS ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="mini-stat">
            <div class="mini-stat-label">Total Group</div>
            <div class="mini-stat-value">{{ $groups->count() }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mini-stat">
            <div class="mini-stat-label">Guide Tersedia</div>
            <div class="mini-stat-value" style="color:var(--accent-amber);">{{ $guides->count() }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mini-stat">
            <div class="mini-stat-label">Group Aktif</div>
            <div class="mini-stat-value" style="color:var(--accent-teal);">{{ $groups->count() }}</div>
        </div>
    </div>
</div>

{{-- ── FORM BUAT GROUP ── --}}
<div class="form-card mb-4">
    <div class="form-card-header d-flex align-items-center gap-2">
        <i class="bi bi-folder-plus" style="color:var(--accent-green); font-size:17px;"></i>
        <span style="font-size:14px; font-weight:700; color:var(--text-primary);">Buat Group Baru</span>
    </div>
    <div class="form-card-body">
        <form action="{{ route('admin.group.store') }}" method="POST">
            @csrf
            <input type="hidden" name="description" value="Reguler">

            <div class="row g-3 align-items-end">
                {{-- Nama Group --}}
                <div class="col-12 col-md-5">
                    <label class="dark-label">Nama Group</label>
                    <input type="text" name="name" class="dark-input"
                        placeholder="Contoh: Rombongan Pendaki Bali" required>
                </div>

                {{-- Pilih Guide --}}
                <div class="col-12 col-md-5">
                    <label class="dark-label">Guide Penanggung Jawab</label>
                    <div class="select-wrap">
                        <select name="guide_id" class="dark-input" required>
                            <option value="" disabled selected>— Pilih Guide —</option>
                            @foreach($guides as $guide)
                                <option value="{{ $guide->id }}">{{ $guide->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn-save w-100">
                        <i class="bi bi-check-lg me-1"></i> Simpan
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
            <div style="font-size:14px; font-weight:700; color:var(--text-primary);">Daftar Group</div>
            <div style="font-size:11.5px; color:var(--text-muted); margin-top:2px;">Semua rombongan terdaftar dalam sistem</div>
        </div>
        <div class="search-wrap">
            <i class="bi bi-search" style="color:var(--text-muted); font-size:13px;"></i>
            <input type="text" id="searchInput" placeholder="Cari nama group atau guide...">
        </div>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
        <table class="dark-table" id="groupTable">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Nama Group</th>
                    <th>Guide Penanggung Jawab</th>
                    <th>Tanggal Dibuat</th>
                    <th style="text-align:center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groups as $index => $group)
                <tr>
                    <td style="color:var(--text-muted); font-weight:600; font-size:12px;">
                        {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}
                    </td>
                    <td>
                        <span class="group-chip">
                            <i class="bi bi-people-fill" style="font-size:12px;"></i>
                            {{ $group->name }}
                        </span>
                    </td>
                    <td>
                        @if($group->guide)
                            <span class="guide-chip">
                                🪖 {{ $group->guide->name }}
                            </span>
                        @else
                            <span style="color:var(--text-muted); font-size:12px; font-style:italic;">Belum ada guide</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-size:13px; color:var(--text-primary);">
                            {{ $group->created_at ? $group->created_at->format('d M Y') : '—' }}
                        </div>
                        @if($group->created_at)
                            <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">
                                <i class="bi bi-clock me-1"></i>{{ $group->created_at->format('H:i') }} WIB
                            </div>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        <span class="status-aktif">
                            <span class="status-dot"></span> Aktif
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="text-center py-5">
                            <div class="empty-icon">👥</div>
                            <div style="font-size:15px; font-weight:600; color:var(--text-primary); margin-bottom:6px;">Belum ada data group</div>
                            <div style="font-size:13px; color:var(--text-muted);">Buat group baru menggunakan form di atas.</div>
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
            Menampilkan <strong style="color:var(--text-primary);">{{ $groups->count() }}</strong> group
        </span>
        <span style="font-size:11px;">Data diperbarui secara real-time</span>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#groupTable tbody tr[data-filter]').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
        // Fallback untuk semua tr
        document.querySelectorAll('#groupTable tbody tr').forEach(row => {
            if (!row.querySelector('td[colspan]')) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            }
        });
    });
</script>

@endsection