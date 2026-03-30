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
        --accent-red:     #f85149;
        --accent-green:   #3fb950;
        --accent-amber:   #e3b341;
        --text-primary:   #e6edf3;
        --text-secondary: #8b949e;
        --text-muted:     #6e7681;
    }

    /* ── INCOME CARDS ── */
    .income-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
        position: relative; overflow: hidden;
        transition: border-color .2s, transform .2s;
    }
    .income-card:hover { border-color: var(--border-light); transform: translateY(-3px); }
    .income-card::before {
        content: ''; position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
    }
    .income-card.c-teal::before  { background: var(--accent-teal); }
    .income-card.c-blue::before  { background: var(--accent-blue); }
    .income-card.c-red::before   { background: var(--accent-red); }
    .income-card.c-green::before { background: var(--accent-green); }

    /* glow blob */
    .income-card::after {
        content: ''; position: absolute;
        bottom: -25px; right: -25px;
        width: 110px; height: 110px; border-radius: 50%;
        opacity: .06;
    }
    .income-card.c-teal::after  { background: var(--accent-teal); }
    .income-card.c-blue::after  { background: var(--accent-blue); }
    .income-card.c-red::after   { background: var(--accent-red); }
    .income-card.c-green::after { background: var(--accent-green); }

    .income-icon {
        width: 42px; height: 42px; border-radius: 11px;
        display: grid; place-items: center;
        font-size: 19px; margin-bottom: 14px;
    }
    .c-teal  .income-icon { background: rgba(57,208,200,.12);  color: var(--accent-teal); }
    .c-blue  .income-icon { background: rgba(88,166,255,.12);  color: var(--accent-blue); }
    .c-red   .income-icon { background: rgba(248,81,73,.12);   color: var(--accent-red); }
    .c-green .income-icon { background: rgba(63,185,80,.12);   color: var(--accent-green); }

    .income-label {
        font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .8px;
        color: var(--text-muted);
    }
    .income-value {
        font-family: 'Sora', sans-serif;
        font-weight: 800; color: var(--text-primary);
        line-height: 1.1; margin: 8px 0 4px;
    }
    .income-desc { font-size: 11.5px; color: var(--text-muted); }

    /* Progress bar */
    .income-bar-wrap {
        height: 4px; background: var(--bg-elevated);
        border-radius: 99px; margin-top: 14px; overflow: hidden;
    }
    .income-bar {
        height: 100%; border-radius: 99px;
        transition: width .6s ease;
    }
    .c-teal  .income-bar { background: var(--accent-teal); }
    .c-blue  .income-bar { background: var(--accent-blue); }
    .c-red   .income-bar { background: var(--accent-red); }

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
    .dark-table { width: 100%; border-collapse: collapse; min-width: 650px; }
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
    .dark-table tbody td { padding: 14px 22px; font-size: 13.5px; color: var(--text-secondary); border: none; vertical-align: middle; }

    /* Climber avatar */
    .climber-avatar {
        width: 34px; height: 34px; border-radius: 9px;
        background: linear-gradient(135deg, var(--accent-teal), var(--accent-blue));
        display: grid; place-items: center;
        font-size: 12px; font-weight: 800; color: #fff;
        flex-shrink: 0; text-transform: uppercase;
    }

    /* Category chips */
    .cat-domestik {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(57,208,200,.1);
        border: 1px solid rgba(57,208,200,.25);
        color: var(--accent-teal);
        font-size: 11.5px; font-weight: 700;
        padding: 3px 10px; border-radius: 20px;
        text-transform: uppercase; letter-spacing: .3px;
    }
    .cat-mancanegara {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(248,81,73,.1);
        border: 1px solid rgba(248,81,73,.25);
        color: var(--accent-red);
        font-size: 11.5px; font-weight: 700;
        padding: 3px 10px; border-radius: 20px;
        text-transform: uppercase; letter-spacing: .3px;
    }

    /* Price */
    .price-text {
        font-weight: 700; font-size: 14px;
        color: var(--accent-green);
        font-family: 'Sora', sans-serif;
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
        Laporan Keuangan & Pendapatan
    </h1>
    <p style="color:var(--text-muted); font-size:13px; margin-top:4px; margin-bottom:0;">
        Ringkasan total uang masuk dari pendaftaran pendaki.
    </p>
</div>

{{-- ── INCOME CARDS ── --}}
@php
    $pctDomestik    = $totalIncome > 0 ? round(($incomeDomestik    / $totalIncome) * 100) : 0;
    $pctMancanegara = $totalIncome > 0 ? round(($incomeMancanegara / $totalIncome) * 100) : 0;
@endphp

<div class="row g-3 mb-4">
    {{-- Total --}}
    <div class="col-12 col-md-4">
        <div class="income-card c-teal">
            <div class="income-icon"><i class="bi bi-cash-stack"></i></div>
            <div class="income-label">Total Pendapatan Bulan Ini</div>
            <div class="income-value" style="font-size:26px;">
                Rp {{ number_format($totalIncome, 0, ',', '.') }}
            </div>
            <div class="income-desc">Akumulasi seluruh tiket</div>
            <div class="income-bar-wrap">
                <div class="income-bar" style="width:100%;"></div>
            </div>
        </div>
    </div>

    {{-- Domestik --}}
    <div class="col-12 col-sm-6 col-md-4">
        <div class="income-card c-blue">
            <div class="income-icon"><i class="bi bi-people-fill"></i></div>
            <div class="income-label">Tiket Domestik (WNI)</div>
            <div class="income-value" style="font-size:22px;">
                Rp {{ number_format($incomeDomestik, 0, ',', '.') }}
            </div>
            <div class="income-desc">{{ $pctDomestik }}% dari total pendapatan</div>
            <div class="income-bar-wrap">
                <div class="income-bar" style="width:{{ $pctDomestik }}%;"></div>
            </div>
        </div>
    </div>

    {{-- Mancanegara --}}
    <div class="col-12 col-sm-6 col-md-4">
        <div class="income-card c-red">
            <div class="income-icon"><i class="bi bi-globe-americas"></i></div>
            <div class="income-label">Tiket Mancanegara (WNA)</div>
            <div class="income-value" style="font-size:22px;">
                Rp {{ number_format($incomeMancanegara, 0, ',', '.') }}
            </div>
            <div class="income-desc">{{ $pctMancanegara }}% dari total pendapatan</div>
            <div class="income-bar-wrap">
                <div class="income-bar" style="width:{{ $pctMancanegara }}%;"></div>
            </div>
        </div>
    </div>
</div>

{{-- ── TABLE CARD ── --}}
<div class="table-card">
    {{-- Header --}}
    <div class="table-card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <div style="font-size:14px; font-weight:700; color:var(--text-primary);">Riwayat Pembayaran Tiket</div>
            <div style="font-size:11.5px; color:var(--text-muted); margin-top:2px;">Semua transaksi tiket masuk pendakian</div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            {{-- Filter chips --}}
            <button class="filter-chip active" data-filter="all">Semua</button>
            <button class="filter-chip" data-filter="domestik">🇮🇩 Domestik</button>
            <button class="filter-chip" data-filter="mancanegara">🌍 Mancanegara</button>
            {{-- Search --}}
            <div class="search-wrap">
                <i class="bi bi-search" style="color:var(--text-muted); font-size:13px;"></i>
                <input type="text" id="searchInput" placeholder="Cari nama pendaki...">
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
        <table class="dark-table" id="keuanganTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pendaki</th>
                    <th>Kategori</th>
                    <th>Harga Tiket</th>
                    <th>Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Data diurutkan terbaru (DESC) berdasarkan created_at --}}
                @forelse($climbings->sortByDesc('created_at') as $i => $climb)
                @php
                    $ticketName = optional($climb->ticket)->name ?? 'N/A';
                    $cat = strtolower($ticketName);
                @endphp
                <tr data-cat="{{ $cat }}">
                    {{-- No --}}
                    <td style="color:var(--text-muted); font-size:12px; font-weight:600;">
                        {{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}
                    </td>

                    {{-- Nama --}}
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="climber-avatar">{{ strtoupper(substr($climb->name, 0, 2)) }}</div>
                            <span style="font-weight:600; color:var(--text-primary);">{{ $climb->name }}</span>
                        </div>
                    </td>

                    {{-- Kategori --}}
                    <td>
                        <span class="{{ $cat === 'mancanegara' ? 'cat-mancanegara' : 'cat-domestik' }}">
                            {{ $cat === 'mancanegara' ? '🌍' : '🇮🇩' }} {{ $ticketName }}
                        </span>
                    </td>

                    {{-- Harga --}}
                    <td>
                        <span class="price-text">
                            Rp {{ number_format($climb->ticket->price ?? 0, 0, ',', '.') }}
                        </span>
                    </td>

                    {{-- Tanggal --}}
                    <td>
                        <div style="font-size:13px; color:var(--text-primary);">
                            {{ $climb->created_at->format('d M Y') }}
                        </div>
                        <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">
                            <i class="bi bi-clock me-1"></i>{{ $climb->created_at->format('H:i') }} WITA
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="text-center py-5">
                            <div class="empty-icon">💰</div>
                            <div style="font-size:15px; font-weight:600; color:var(--text-primary); margin-bottom:6px;">
                                Belum ada riwayat pembayaran
                            </div>
                            <div style="font-size:13px; color:var(--text-muted);">
                                Transaksi akan muncul setelah ada pendaki yang mendaftar.
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
            Menampilkan <strong style="color:var(--text-primary);" id="rowCount">{{ $climbings->count() }}</strong> transaksi
        </span>
        <div class="d-flex align-items-center gap-3" style="font-size:11.5px;">
            <span>
                <span style="display:inline-block; width:8px; height:8px; background:var(--accent-teal); border-radius:50%; margin-right:5px;"></span>Domestik
            </span>
            <span>
                <span style="display:inline-block; width:8px; height:8px; background:var(--accent-red); border-radius:50%; margin-right:5px;"></span>Mancanegara
            </span>
        </div>
    </div>
</div>

<style>
    .filter-chip {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border-radius: 20px;
        font-size: 12px; font-weight: 600;
        border: 1px solid var(--border);
        background: var(--bg-elevated);
        color: var(--text-secondary);
        cursor: pointer; transition: all .18s;
        font-family: inherit;
    }
    .filter-chip:hover, .filter-chip.active {
        border-color: var(--accent-teal);
        background: rgba(57,208,200,.1);
        color: var(--accent-teal);
    }
</style>

<script>
    // Filter + Search
    const chips = document.querySelectorAll('.filter-chip');
    chips.forEach(chip => {
        chip.addEventListener('click', function () {
            chips.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            filterTable(this.dataset.filter, document.getElementById('searchInput').value);
        });
    });

    document.getElementById('searchInput').addEventListener('input', function () {
        const activeFilter = document.querySelector('.filter-chip.active').dataset.filter;
        filterTable(activeFilter, this.value);
    });

    function filterTable(cat, query) {
        const q = query.toLowerCase();
        let visible = 0;
        document.querySelectorAll('#keuanganTable tbody tr[data-cat]').forEach(row => {
            const matchCat   = cat === 'all' || row.dataset.cat === cat;
            const matchQuery = row.textContent.toLowerCase().includes(q);
            const show = matchCat && matchQuery;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        document.getElementById('rowCount').textContent = visible;
    }
</script>

@endsection