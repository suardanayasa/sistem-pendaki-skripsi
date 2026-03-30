<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Domestik | Sistem Pendaki</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-base:      #0d1117;
            --bg-card:      #161b22;
            --bg-elevated:  #1c2330;
            --border:       #30363d;
            --accent-teal:  #39d0c8;
            --accent-blue:  #58a6ff;
            --accent-green: #3fb950;
            --accent-red:   #f85149;
            --text-primary: #e6edf3;
            --text-muted:   #8b949e;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-base);
            color: var(--text-primary);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 16px;
            background-image:
                radial-gradient(ellipse 55% 45% at 20% 20%, rgba(57,208,200,.07) 0%, transparent 70%),
                radial-gradient(ellipse 50% 40% at 80% 80%, rgba(88,166,255,.05) 0%, transparent 70%);
        }

        /* ── CARD ── */
        .form-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 44px 40px 36px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 24px 64px rgba(0,0,0,.5);
            position: relative; overflow: hidden;
        }

        /* top glow line */
        .form-card::before {
            content: '';
            position: absolute; top: 0; left: 10%; right: 10%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent-teal), transparent);
            opacity: .7;
        }

        /* ── BRAND ── */
        .brand-wrap { text-align: center; margin-bottom: 28px; }
        .brand-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-blue));
            border-radius: 16px;
            display: grid; place-items: center;
            font-size: 26px;
            margin: 0 auto 16px;
            box-shadow: 0 8px 24px rgba(57,208,200,.2);
        }
        .brand-title {
            font-family: 'Sora', sans-serif;
            font-size: 22px; font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -.4px; margin: 0;
        }
        .brand-sub {
            font-size: 13px; color: var(--text-muted);
            margin-top: 6px; line-height: 1.5;
        }

        /* Role badge */
        .role-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(57,208,200,.1);
            border: 1px solid rgba(57,208,200,.25);
            color: var(--accent-teal);
            font-size: 11px; font-weight: 700;
            padding: 3px 10px; border-radius: 20px;
            margin-bottom: 14px;
            text-transform: uppercase; letter-spacing: .5px;
        }

        /* Divider */
        .card-divider {
            height: 1px; background: var(--border);
            margin: 0 -40px 28px; opacity: .7;
        }

        /* ── ALERTS ── */
        .alert-success-custom {
            background: rgba(63,185,80,.08);
            border: 1px solid rgba(63,185,80,.3);
            color: var(--accent-green);
            border-radius: 10px; padding: 12px 14px;
            font-size: 13px; font-weight: 600;
            margin-bottom: 22px;
            display: flex; align-items: center; gap: 8px;
        }
        .alert-error-custom {
            background: rgba(248,81,73,.08);
            border: 1px solid rgba(248,81,73,.3);
            color: var(--accent-red);
            border-radius: 10px; padding: 12px 14px;
            font-size: 13px; font-weight: 600;
            margin-bottom: 22px;
            display: flex; align-items: center; gap: 8px;
        }

        /* ── FORM FIELDS ── */
        .field-label {
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .9px;
            color: var(--text-muted); margin-bottom: 8px;
            display: block;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted); font-size: 15px;
            pointer-events: none; transition: color .2s;
        }
        .dark-input {
            width: 100%;
            background: var(--bg-base);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 14px 12px 42px;
            color: var(--text-primary);
            font-family: inherit; font-size: 13.5px;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
            appearance: none; -webkit-appearance: none;
        }
        .dark-input::placeholder { color: var(--text-muted); }
        .dark-input:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 4px rgba(88,166,255,.1);
            background: #111821;
        }
        .input-wrap:focus-within .input-icon { color: var(--accent-blue); }

        /* Custom select arrow */
        .select-arrow {
            position: absolute; right: 13px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted); pointer-events: none;
            font-size: 14px;
        }
        .dark-input option { background: var(--bg-card); color: var(--text-primary); }
        select.dark-input { padding-right: 38px; cursor: pointer; color-scheme: dark; }

        /* ── SUBMIT BTN ── */
        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, var(--accent-teal), #2fb8b0);
            color: #0d1117;
            border: none; border-radius: 11px;
            padding: 14px;
            font-family: 'Sora', sans-serif;
            font-weight: 700; font-size: 14px;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 18px rgba(57,208,200,.25);
            margin-top: 6px;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(57,208,200,.35);
        }
        .btn-register:active { transform: translateY(0); }

        /* ── FOOTER ── */
        .form-footer {
            text-align: center;
            margin-top: 26px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 11.5px;
            color: var(--text-muted);
            line-height: 1.7;
        }

        /* ── STEP INDICATOR ── */
        .step-info {
            display: flex; align-items: center; gap: 8px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 10px; padding: 10px 14px;
            font-size: 12px; color: var(--text-muted);
            margin-bottom: 24px;
        }
        .step-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--accent-teal); flex-shrink: 0;
            animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:.3;} }

        @media (max-width: 480px) {
            .form-card { padding: 32px 22px 28px; }
            .card-divider { margin: 0 -22px 24px; }
        }
    </style>
</head>
<body>

    <div class="form-card">

        {{-- Brand --}}
        <div class="brand-wrap">
            <div class="brand-icon">⛰️</div>
            <div class="role-badge">
                <i class="bi bi-flag-fill"></i> Tiket Domestik
            </div>
            <h1 class="brand-title">Registrasi Pendaki</h1>
            <p class="brand-sub">Pastikan data diisi lengkap dan benar untuk tiket lokal.</p>
        </div>

        <div class="card-divider"></div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert-success-custom">
                <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error-custom">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        {{-- Status indicator --}}
        <div class="step-info">
            <span class="step-dot"></span>
            Formulir aktif — isi data pendaki dengan lengkap dan benar.
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('climbing.domestic.store') }}">
            @csrf

            {{-- Nama --}}
            <div class="mb-4">
                <label class="field-label">Nama Lengkap Pendaki</label>
                <div class="input-wrap">
                    <input type="text" name="name"
                        class="dark-input"
                        value="{{ old('name') }}"
                        placeholder="Sesuai KTP" required>
                    <i class="bi bi-person input-icon"></i>
                </div>
            </div>

            {{-- Asal --}}
            <div class="mb-4">
                <label class="field-label">Asal / Kota Domisili</label>
                <div class="input-wrap">
                    <input type="text" name="residence"
                        class="dark-input"
                        value="{{ old('residence') }}"
                        placeholder="Contoh: Denpasar, Bali" required>
                    <i class="bi bi-geo-alt input-icon"></i>
                </div>
            </div>

            {{-- No HP --}}
            <div class="mb-4">
                <label class="field-label">Nomor HP Aktif</label>
                <div class="input-wrap">
                    <input type="text" name="phone_number"
                        class="dark-input"
                        value="{{ old('phone_number') }}"
                        placeholder="Contoh: 08123456789" required>
                    <i class="bi bi-telephone input-icon"></i>
                </div>
            </div>

            {{-- Group --}}
            <div class="mb-4">
                <label class="field-label">
                    Pilih Group
                    <span style="color:var(--text-muted); font-weight:400; text-transform:none; letter-spacing:0;">(Opsional)</span>
                </label>
                <div class="input-wrap">
                    <select name="group_id" class="dark-input">
                        <option value="">— Tanpa Group —</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                {{ $group->name }}
                                @if($group->guide) · Guide: {{ $group->guide->name }} @endif
                            </option>
                        @endforeach
                    </select>
                    <i class="bi bi-people input-icon"></i>
                    <i class="bi bi-chevron-down select-arrow"></i>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-check2-circle me-2"></i>Daftarkan Pendaki
            </button>
        </form>

        {{-- Footer --}}
        <div class="form-footer">
            © 2026 Sistem Monitoring Pendaki<br>
            Organisasi Pendaki Gunung Agung Desa Besakih
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>