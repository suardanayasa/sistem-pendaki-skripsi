<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Guide - SummitAdmin</title>

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
            --accent-red:     #f85149;
            --accent-green:   #3fb950;
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

        /* ── PAGE HEADER ── */
        .page-title {
            font-family: 'Sora', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }
        .page-subtitle { font-size: 13px; color: var(--text-muted); margin-top: 4px; }

        /* ── STAT MINI CARDS ── */
        .mini-stat {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 20px;
            transition: border-color .2s, transform .2s;
        }
        .mini-stat:hover { border-color: var(--border-light); transform: translateY(-2px); }
        .mini-stat-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .8px; color: var(--text-muted); }
        .mini-stat-value { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 700; color: var(--text-primary); line-height: 1.1; margin-top: 4px; }

        /* ── BTN ADD ── */
        .btn-add {
            background: var(--accent-teal);
            color: #0d1117;
            font-weight: 700;
            font-size: 13px;
            border: none;
            border-radius: 9px;
            padding: 10px 20px;
            transition: transform .2s, box-shadow .2s;
            white-space: nowrap;
        }
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(57,208,200,.25);
            color: #0d1117;
        }

        /* ── ALERT ── */
        .alert-success-custom {
            background: rgba(57,208,200,.1);
            border: 1px solid var(--accent-teal);
            color: var(--accent-teal);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13px;
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

        /* Search Box */
        .search-wrap {
            display: flex; align-items: center; gap: 8px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 7px 13px;
            transition: border-color .2s;
        }
        .search-wrap:focus-within { border-color: var(--accent-teal); }
        .search-wrap input {
            background: none; border: none; outline: none;
            font-family: inherit; font-size: 13px;
            color: var(--text-primary); width: 200px;
        }
        .search-wrap input::placeholder { color: var(--text-muted); }

        /* Dark Table Override */
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
        .dark-table tbody td { padding: 16px 22px; font-size: 13.5px; color: var(--text-secondary); border: none; vertical-align: middle; }

        /* Avatar */
        .guide-avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-blue));
            border-radius: 10px;
            display: grid; place-items: center;
            font-weight: 800; font-size: 14px; color: #fff;
            flex-shrink: 0;
        }
        .guide-name   { font-weight: 600; color: var(--text-primary); font-size: 14px; }
        .guide-email  { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

        /* Badges & Chips */
        .phone-chip {
            font-family: monospace; font-weight: 600;
            font-size: 13px; color: var(--accent-blue);
            background: rgba(88,166,255,.08);
            border: 1px solid rgba(88,166,255,.2);
            border-radius: 6px;
            padding: 3px 10px;
            display: inline-block;
        }
        .age-chip {
            font-size: 10.5px; color: var(--text-muted);
            background: var(--bg-elevated);
            border-radius: 20px; padding: 2px 8px;
            border: 1px solid var(--border);
            display: inline-block; margin-top: 4px;
        }

        /* Action Buttons */
        .action-btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 12px; border-radius: 7px;
            font-size: 12px; font-weight: 600; cursor: pointer;
            border: 1px solid; transition: all .18s;
        }
        .action-edit {
            color: var(--accent-blue);
            border-color: rgba(88,166,255,.3);
            background: rgba(88,166,255,.08);
            text-decoration: none;
        }
        .action-edit:hover { background: rgba(88,166,255,.18); color: var(--accent-blue); }
        .action-del {
            color: var(--accent-red);
            border-color: rgba(248,81,73,.3);
            background: rgba(248,81,73,.08);
            font-family: inherit;
        }
        .action-del:hover { background: rgba(248,81,73,.18); }

        /* Table Footer */
        .table-footer-bar {
            padding: 14px 22px;
            border-top: 1px solid var(--border);
            font-size: 12.5px; color: var(--text-muted);
        }

        /* Empty State */
        .empty-state { padding: 60px 20px; }
        .empty-state-icon {
            width: 64px; height: 64px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 16px;
            display: grid; place-items: center;
            font-size: 28px; margin: 0 auto 16px;
        }

        /* ── MODAL ── */
        .modal-dark .modal-content {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            color: var(--text-primary);
        }
        .modal-dark .modal-header {
            background: var(--bg-surface);
            border-bottom: 1px solid var(--border);
            border-radius: 16px 16px 0 0;
            padding: 20px 24px;
        }
        .modal-dark .modal-title {
            font-family: 'Sora', sans-serif;
            font-size: 18px; font-weight: 700;
        }
        .modal-dark .btn-close {
            filter: invert(1) grayscale(1);
            opacity: .5;
        }
        .modal-dark .modal-body { padding: 24px; }
        .modal-dark .modal-footer {
            border-top: 1px solid var(--border);
            padding: 16px 24px;
            background: var(--bg-elevated);
            border-radius: 0 0 16px 16px;
        }
        .modal-dark .modal-backdrop { --bs-backdrop-opacity: 0.7; }

        /* Form Controls in Modal */
        .dark-label { font-size: 12px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .5px; }
        .dark-input {
            width: 100%;
            background: var(--bg-base);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-primary);
            padding: 10px 12px;
            font-family: inherit;
            font-size: 13.5px;
            outline: none;
            transition: border-color .2s;
        }
        .dark-input:focus { border-color: var(--accent-blue); box-shadow: 0 0 0 3px rgba(88,166,255,.12); }
        .dark-input::placeholder { color: var(--text-muted); }

        .btn-submit {
            background: var(--accent-teal);
            color: #0d1117;
            font-weight: 700; font-size: 13px;
            border: none; border-radius: 8px;
            padding: 10px 24px;
            transition: transform .2s, box-shadow .2s;
        }
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(57,208,200,.25);
            color: #0d1117;
        }
        .btn-cancel {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 13px; font-weight: 500;
        }
        .btn-cancel:hover { background: var(--bg-elevated); color: var(--text-secondary); }
    </style>
</head>

<body>

    {{-- ── PAGE HEADER ── --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title">Database Guide</h1>
            <p class="page-subtitle mb-0">Daftar personil guide pendakian dari sistem.</p>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Guide
        </button>
    </div>

    {{-- ── MINI STATS ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="mini-stat">
                <div class="mini-stat-label">Total Guide</div>
                <div class="mini-stat-value">{{ $guides->count() }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="mini-stat">
                <div class="mini-stat-label">Aktif Bertugas</div>
                <div class="mini-stat-value" style="color: var(--accent-teal);">{{ $guides->count() }}</div>
            </div>
        </div>
    </div>

    {{-- ── ALERT SUCCESS ── --}}
    @if(session('success'))
        <div class="alert-success-custom mb-4 d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── TABLE CARD ── --}}
    <div class="table-card">
        {{-- Header --}}
        <div class="table-card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div style="font-size:14px; font-weight:700; color:var(--text-primary);">Daftar Guide</div>
                <div style="font-size:11.5px; color:var(--text-muted); margin-top:2px;">Semua guide terdaftar dalam sistem</div>
            </div>
            <div class="search-wrap">
                <i class="bi bi-search" style="color:var(--text-muted); font-size:13px;"></i>
                <input type="text" id="searchInput" placeholder="Cari guide...">
            </div>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
            <table class="dark-table" id="guideTable">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Nama & Email</th>
                        <th>Nomor HP</th>
                        <th>Tanggal Lahir</th>
                        <th>Deskripsi</th>
                        <th style="text-align:center;">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guides as $guide)
                    <tr>
                        <td style="color:var(--text-muted); font-weight:600;">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="guide-avatar">{{ strtoupper(substr($guide->name, 0, 1)) }}</div>
                                <div>
                                    <div class="guide-name">{{ $guide->name }}</div>
                                    <div class="guide-email">{{ $guide->email ?? '—' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="phone-chip">{{ $guide->phone }}</span>
                        </td>
                        <td>
                            @if($guide->date_of_birth)
                                <div style="font-size:13px; color:var(--text-primary);">
                                    {{ $guide->date_of_birth->format('d M Y') }}
                                </div>
                                <span class="age-chip">{{ $guide->date_of_birth->age }} Tahun</span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-size:12px; color:var(--text-muted); max-width:220px; line-height:1.5;">
                                {{ $guide->description ?? 'Tidak ada deskripsi profil.' }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <a href="{{ route('admin.guide.edit', $guide->id) }}" class="action-btn action-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.guide.destroy', $guide->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-del"
                                        onclick="return confirm('Hapus guide {{ $guide->name }}?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state text-center">
                                <div class="empty-state-icon">🪖</div>
                                <div style="font-size:15px; font-weight:600; color:var(--text-primary); margin-bottom:6px;">Belum ada data guide</div>
                                <div style="font-size:13px; color:var(--text-muted);">Tambahkan guide pertama dengan menekan tombol di atas.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="table-footer-bar d-flex flex-wrap align-items-center justify-content-between gap-2">
            <span>Menampilkan <strong style="color:var(--text-primary);">{{ $guides->count() }}</strong> guide</span>
            <span style="font-size:11px;">Data diperbarui secara real-time</span>
        </div>
    </div>

    {{-- ── MODAL TAMBAH GUIDE ── --}}
    <div class="modal fade modal-dark" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">
                        <i class="bi bi-person-plus me-2" style="color:var(--accent-teal);"></i> Tambah Guide Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form action="{{ route('admin.guide.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="dark-label">Nama Lengkap</label>
                                <input type="text" name="name" class="dark-input" required placeholder="Masukkan nama pemandu...">
                            </div>
                            <div class="col-12">
                                <label class="dark-label">Email <span style="opacity:.5;">(Opsional)</span></label>
                                <input type="email" name="email" class="dark-input" placeholder="contoh@mail.com">
                            </div>
                            <div class="col-md-6">
                                <label class="dark-label">Nomor HP</label>
                                <input type="text" name="phone" class="dark-input" required placeholder="0812xxxx">
                            </div>
                            <div class="col-md-6">
                                <label class="dark-label">Tanggal Lahir</label>
                                <input type="date" name="date_of_birth" class="dark-input" required
                                       style="color-scheme: dark;">
                            </div>
                            <div class="col-12">
                                <label class="dark-label">Deskripsi Profil</label>
                                <textarea name="description" class="dark-input" rows="3"
                                    placeholder="Tambahkan bio singkat atau spesialisasi jalur..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex gap-2">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-submit ms-auto">
                            <i class="bi bi-check-lg me-1"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Live search
        document.getElementById('searchInput').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#guideTable tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>
</body>
</html>