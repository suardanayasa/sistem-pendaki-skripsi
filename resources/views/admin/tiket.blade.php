<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Tiket - SummitAdmin</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">

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
            --accent-orange:  #f9826c;
            --accent-green:   #3fb950;
            --accent-amber:   #e3b341;
            --text-primary:   #e6edf3;
            --text-secondary: #8b949e;
            --text-muted:     #6e7681;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-base);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 32px 28px;
        }

        /* ── PAGE TITLE ── */
        .page-title {
            font-family: 'Sora', sans-serif;
            font-size: 24px; font-weight: 700;
            color: var(--text-primary); margin: 0;
        }
        .page-subtitle { font-size: 13px; color: var(--text-muted); margin-top: 4px; }

        /* ── STAT CARDS ── */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            transition: transform .2s, border-color .2s;
        }
        .stat-card:hover { transform: translateY(-3px); border-color: var(--border-light); }

        /* vertical accent bar */
        .stat-card::before {
            content: '';
            position: absolute; top: 0; left: 0;
            width: 3px; height: 100%;
            border-radius: 4px 0 0 4px;
        }
        .stat-blue::before   { background: var(--accent-blue); }
        .stat-teal::before   { background: var(--accent-teal); }
        .stat-orange::before { background: var(--accent-orange); }
        .stat-green::before  { background: var(--accent-green); }

        /* glow blob behind value */
        .stat-card::after {
            content: '';
            position: absolute; bottom: -20px; right: -20px;
            width: 90px; height: 90px; border-radius: 50%;
            opacity: .07;
        }
        .stat-blue::after   { background: var(--accent-blue); }
        .stat-teal::after   { background: var(--accent-teal); }
        .stat-orange::after { background: var(--accent-orange); }
        .stat-green::after  { background: var(--accent-green); }

        .stat-icon {
            width: 38px; height: 38px; border-radius: 10px;
            display: grid; place-items: center;
            font-size: 18px; margin-bottom: 14px;
        }
        .stat-blue   .stat-icon { background: rgba(88,166,255,.12);  color: var(--accent-blue); }
        .stat-teal   .stat-icon { background: rgba(57,208,200,.12);  color: var(--accent-teal); }
        .stat-orange .stat-icon { background: rgba(249,130,108,.12); color: var(--accent-orange); }
        .stat-green  .stat-icon { background: rgba(63,185,80,.12);   color: var(--accent-green); }

        .stat-label {
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1px;
            color: var(--text-muted);
        }
        .stat-value {
            font-family: 'Sora', sans-serif;
            font-size: 32px; font-weight: 800;
            color: var(--text-primary);
            line-height: 1.1; margin: 6px 0 4px;
        }
        .stat-desc { font-size: 11.5px; color: var(--text-muted); }

        /* ── FILTER BAR ── */
        .filter-bar {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 20px;
        }
        .filter-chip {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 14px; border-radius: 20px;
            font-size: 12px; font-weight: 600;
            border: 1px solid var(--border);
            background: var(--bg-elevated);
            color: var(--text-secondary);
            cursor: pointer; transition: all .18s;
        }
        .filter-chip:hover, .filter-chip.active {
            border-color: var(--accent-teal);
            background: rgba(57,208,200,.1);
            color: var(--accent-teal);
        }

        /* Search Box */
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

        /* Dark Table */
        .dark-table { width: 100%; border-collapse: collapse; min-width: 750px; }
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
        .dark-table tbody td {
            padding: 15px 22px; font-size: 13.5px;
            color: var(--text-secondary); border: none;
            vertical-align: middle;
        }

        /* Ticket ID */
        .ticket-id {
            font-family: monospace; font-size: 13px; font-weight: 700;
            color: var(--accent-blue);
            background: rgba(88,166,255,.08);
            border: 1px solid rgba(88,166,255,.2);
            border-radius: 6px; padding: 3px 9px;
            display: inline-block;
        }

        /* Climber name */
        .climber-avatar {
            width: 34px; height: 34px; border-radius: 9px;
            background: linear-gradient(135deg, var(--accent-blue), #bc8cff);
            display: grid; place-items: center;
            font-size: 12px; font-weight: 800; color: #fff;
            flex-shrink: 0; text-transform: uppercase;
        }

        /* Category badges */
        .cat-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 11px; border-radius: 20px;
            font-size: 11.5px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .5px;
        }
        .cat-domestik {
            background: rgba(57,208,200,.1);
            border: 1px solid rgba(57,208,200,.25);
            color: var(--accent-teal);
        }
        .cat-mancanegara {
            background: rgba(249,130,108,.1);
            border: 1px solid rgba(249,130,108,.25);
            color: var(--accent-orange);
        }

        /* Price chip */
        .price-chip {
            font-weight: 700; font-size: 13.5px;
            color: var(--accent-green);
        }

        /* Table Footer */
        .table-footer-bar {
            padding: 14px 22px;
            border-top: 1px solid var(--border);
            background: var(--bg-surface);
            font-size: 12.5px; color: var(--text-muted);
        }

        /* Empty State */
        .empty-state-icon {
            width: 64px; height: 64px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 16px;
            display: grid; place-items: center;
            font-size: 28px; margin: 0 auto 16px;
        }
    </style>
</head>

<body>

    {{-- ── PAGE HEADER ── --}}
    <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title">Monitoring Penjualan Tiket</h1>
            <p class="page-subtitle mb-0">Data transaksi tiket masuk pendakian secara real-time.</p>
        </div>
        {{-- Export button --}}
        <button class="btn btn-sm fw-semibold d-flex align-items-center gap-2"
            style="background:rgba(57,208,200,.1); border:1px solid rgba(57,208,200,.3); color:var(--accent-teal); border-radius:9px; padding:8px 16px;">
            <i class="bi bi-download"></i> Export Data
        </button>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card stat-blue">
                <div class="stat-icon"><i class="bi bi-ticket-perforated-fill"></i></div>
                <div class="stat-label">Total Terjual Bulan Ini</div>
                <div class="stat-value">{{ $totalTiket }}</div>
                <div class="stat-desc">Akumulasi seluruh pendaki</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card stat-teal">
                <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                <div class="stat-label">Domestik (WNI)</div>
                <div class="stat-value">{{ $totalDomestik }}</div>
                <div class="stat-desc">Tiket WNI yang terjual</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card stat-orange">
                <div class="stat-icon"><i class="bi bi-globe-americas"></i></div>
                <div class="stat-label">Mancanegara (WNA)</div>
                <div class="stat-value">{{ $totalMancanegara }}</div>
                <div class="stat-desc">Tiket WNA yang terjual</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card stat-green">
                <div class="stat-icon"><i class="bi bi-cash-coin"></i></div>
                <div class="stat-label">Total Pendapatan Bulan Ini</div>
                <div class="stat-value" style="font-size:20px; padding-top:6px;">
                    Rp {{ number_format($climbings->sum(fn($c) => $c->ticket->price ?? 0), 0, ',', '.') }}
                </div>
                <div class="stat-desc">Dari seluruh transaksi</div>
            </div>
        </div>
    </div>

    {{-- ── TABLE CARD ── --}}
    <div class="table-card">
        {{-- Header --}}
        <div class="table-card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div style="font-size:14px; font-weight:700; color:var(--text-primary);">Riwayat Transaksi</div>
                <div style="font-size:11.5px; color:var(--text-muted); margin-top:2px;">Semua tiket yang telah diterbitkan</div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                {{-- Filter chips --}}
                <button class="filter-chip active" data-filter="all">Semua</button>
                <button class="filter-chip" data-filter="domestik">🇮🇩 Domestik</button>
                <button class="filter-chip" data-filter="mancanegara">🌍 Mancanegara</button>
                {{-- Search --}}
                <div class="search-wrap">
                    <i class="bi bi-search" style="color:var(--text-muted); font-size:13px;"></i>
                    <input type="text" id="searchInput" placeholder="Cari tiket atau nama...">
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
            <table class="dark-table" id="tiketTable">
                <thead>
                    <tr>
                        <th>ID Tiket</th>
                        <th>Nama Pendaki</th>
                        <th>Kategori</th>
                        <th>Harga Tiket</th>
                        <th>Tanggal Beli</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Diurutkan dari yang terbaru (Registrasi Akhir) --}}
                    @forelse($climbings->sortByDesc('created_at') as $climbing)
                    @php
                        $catName  = $climbing->ticket->name ?? 'Domestik';
                        $lowerCat = strtolower($catName);
                    @endphp
                    <tr data-cat="{{ $lowerCat }}">
                        {{-- ID --}}
                        <td>
                            <span class="ticket-id">#TKT-{{ str_pad($climbing->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </td>

                        {{-- Nama --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="climber-avatar">{{ strtoupper(substr($climbing->name, 0, 2)) }}</div>
                                <span style="font-weight:600; color:var(--text-primary);">{{ $climbing->name }}</span>
                            </div>
                        </td>

                        {{-- Kategori --}}
                        <td>
                            <span class="cat-badge {{ $lowerCat == 'mancanegara' ? 'cat-mancanegara' : 'cat-domestik' }}">
                                {{ $lowerCat == 'mancanegara' ? '🌍' : '🇮🇩' }} {{ $catName }}
                            </span>
                        </td>

                        {{-- Harga --}}
                        <td>
                            <span class="price-chip">
                                Rp {{ number_format($climbing->ticket->price ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td>
                            <div style="font-size:13px; color:var(--text-primary);">
                                {{ $climbing->created_at->format('d M Y') }}
                            </div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">
                                <i class="bi bi-clock me-1"></i>{{ $climbing->created_at->format('H:i') }} WITA
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="text-center py-5">
                                <div class="empty-state-icon">🎫</div>
                                <div style="font-size:15px; font-weight:600; color:var(--text-primary); margin-bottom:6px;">
                                    Belum ada transaksi tiket
                                </div>
                                <div style="font-size:13px; color:var(--text-muted);">
                                    Tiket akan muncul setelah ada pendaki yang mendaftar.
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
                    <span style="display:inline-block; width:8px; height:8px; background:var(--accent-orange); border-radius:50%; margin-right:5px;"></span>Mancanegara
                </span>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ── Filter chips ──
        const chips = document.querySelectorAll('.filter-chip');
        chips.forEach(chip => {
            chip.addEventListener('click', function () {
                chips.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                filterTable(this.dataset.filter, document.getElementById('searchInput').value);
            });
        });

        // ── Search ──
        document.getElementById('searchInput').addEventListener('input', function () {
            const activeFilter = document.querySelector('.filter-chip.active').dataset.filter;
            filterTable(activeFilter, this.value);
        });

        function filterTable(cat, query) {
            const q = query.toLowerCase();
            let visible = 0;
            document.querySelectorAll('#tiketTable tbody tr[data-cat]').forEach(row => {
                const matchCat   = cat === 'all' || row.dataset.cat === cat;
                const matchQuery = row.textContent.toLowerCase().includes(q);
                const show = matchCat && matchQuery;
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            document.getElementById('rowCount').textContent = visible;
        }
    </script>
</body>

</html>