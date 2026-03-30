<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas | Sistem Tiket Konter</title>

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
            --accent-blue:  #58a6ff;
            --accent-teal:  #39d0c8;
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
            padding: 24px 16px;
            /* Ambient glow background */
            background-image:
                radial-gradient(ellipse 60% 50% at 30% 20%, rgba(88,166,255,.07) 0%, transparent 70%),
                radial-gradient(ellipse 50% 40% at 75% 80%, rgba(57,208,200,.06) 0%, transparent 70%);
        }

        /* ── CARD ── */
        .login-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 44px 40px 36px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 24px 64px rgba(0,0,0,.55);
            position: relative;
            overflow: hidden;
        }

        /* Subtle top glow line */
        .login-card::before {
            content: '';
            position: absolute; top: 0; left: 10%; right: 10%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent-blue), transparent);
            opacity: .6;
        }

        /* ── BRAND ── */
        .brand-wrap { text-align: center; margin-bottom: 32px; }
        .brand-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-teal));
            border-radius: 16px;
            display: grid; place-items: center;
            font-size: 26px;
            margin: 0 auto 18px;
            box-shadow: 0 8px 24px rgba(88,166,255,.25);
        }
        .brand-title {
            font-family: 'Sora', sans-serif;
            font-size: 24px; font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -.5px; margin: 0;
        }
        .brand-sub {
            font-size: 13px; color: var(--text-muted);
            margin-top: 7px; line-height: 1.5;
        }

        /* ── DIVIDER ── */
        .card-divider {
            height: 1px; background: var(--border);
            margin: 0 -40px 28px; opacity: .7;
        }

        /* ── ALERT ── */
        .alert-error-custom {
            background: rgba(248,81,73,.08);
            border: 1px solid rgba(248,81,73,.35);
            color: #ff7b72;
            border-radius: 10px; padding: 12px 14px;
            font-size: 13px; font-weight: 600;
            margin-bottom: 24px;
            display: flex; align-items: center; gap: 8px;
        }

        /* ── FORM ── */
        .field-label {
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .9px;
            color: var(--text-muted); margin-bottom: 8px;
            display: block;
        }

        .input-wrap {
            position: relative;
        }
        .input-wrap .input-icon {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted); font-size: 15px;
            pointer-events: none;
            transition: color .2s;
        }
        .dark-input {
            width: 100%;
            background: var(--bg-base);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 13px 14px 13px 42px;
            color: var(--text-primary);
            font-family: inherit; font-size: 14px;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .dark-input::placeholder { color: var(--text-muted); }
        .dark-input:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 4px rgba(88,166,255,.12);
            background: #111821;
        }
        .dark-input:focus + .input-icon,
        .input-wrap:focus-within .input-icon { color: var(--accent-blue); }

        /* Password toggle */
        .pw-toggle {
            position: absolute; right: 13px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted); cursor: pointer;
            font-size: 15px; transition: color .2s;
            background: none; border: none; padding: 0;
        }
        .pw-toggle:hover { color: var(--text-primary); }

        /* ── SUBMIT BTN ── */
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--accent-blue), #4493f8);
            color: #fff;
            border: none; border-radius: 11px;
            padding: 14px;
            font-family: 'Sora', sans-serif;
            font-weight: 700; font-size: 14px;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 18px rgba(88,166,255,.28);
            margin-top: 6px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(88,166,255,.38);
        }
        .btn-login:active { transform: translateY(0); }

        /* ── FOOTER ── */
        .login-footer {
            text-align: center;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 11.5px;
            color: var(--text-muted);
            line-height: 1.7;
        }
        .login-footer strong { color: var(--text-primary); }

        /* ── ROLE BADGE ── */
        .role-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(88,166,255,.1);
            border: 1px solid rgba(88,166,255,.2);
            color: var(--accent-blue);
            font-size: 11px; font-weight: 700;
            padding: 3px 10px; border-radius: 20px;
            margin-bottom: 16px;
            text-transform: uppercase; letter-spacing: .5px;
        }
    </style>
</head>

<body>

    <div class="login-card">

        {{-- Brand --}}
        <div class="brand-wrap">
            <div class="brand-icon">⛰️</div>
            <div class="role-badge">
                <i class="bi bi-ticket-perforated-fill"></i> Ticket Counter
            </div>
            <h1 class="brand-title">Selamat Datang</h1>
            <p class="brand-sub">Masuk untuk mulai memproses tiket pendaki.</p>
        </div>

        <div class="card-divider"></div>

        {{-- Error Alert --}}
        @if ($errors->any())
            <div class="alert-error-custom">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('ticket.login.post') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="field-label">Alamat Email</label>
                <div class="input-wrap">
                    <input
                        type="email" name="email" id="email"
                        class="dark-input"
                        placeholder="contoh@mail.com"
                        value="{{ old('email') }}"
                        required autocomplete="email" autofocus>
                    <i class="bi bi-envelope input-icon"></i>
                </div>
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="field-label">Kata Sandi</label>
                <div class="input-wrap">
                    <input
                        type="password" name="password" id="password"
                        class="dark-input"
                        placeholder="••••••••"
                        required autocomplete="current-password"
                        style="padding-right: 44px;">
                    <i class="bi bi-lock input-icon"></i>
                    <button type="button" class="pw-toggle" id="pwToggle" tabindex="-1">
                        <i class="bi bi-eye" id="pwIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem
            </button>
        </form>

        {{-- Footer --}}
        <div class="login-footer">
            <strong>Sistem Monitoring Pendakian</strong> &copy; 2026<br>
            Organisasi Pendaki Gunung Agung Desa Besakih
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle show/hide password
        const pwToggle = document.getElementById('pwToggle');
        const pwInput  = document.getElementById('password');
        const pwIcon   = document.getElementById('pwIcon');

        pwToggle.addEventListener('click', () => {
            const isHidden = pwInput.type === 'password';
            pwInput.type   = isHidden ? 'text' : 'password';
            pwIcon.className = isHidden ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    </script>

</body>
</html>