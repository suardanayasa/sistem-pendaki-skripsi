<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – SummitAdmin</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg-base: #0d1117;
            --bg-surface: #161b22;
            --bg-elevated: #1c2330;
            --bg-card: #21262d;
            --border: #30363d;
            --border-light: #3d444d;
            --accent-teal: #39d0c8;
            --accent-blue: #58a6ff;
            --accent-red: #f85149;
            --text-primary: #e6edf3;
            --text-secondary: #8b949e;
            --text-muted: #6e7681;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-base);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Background decoration */
        body::before {
            content: '';
            position: fixed;
            top: -200px;
            left: 50%;
            transform: translateX(-50%);
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(57, 208, 200, 0.06) 0%, transparent 65%);
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -150px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(88, 166, 255, 0.05) 0%, transparent 65%);
            pointer-events: none;
        }

        /* Grid pattern overlay */
        .grid-bg {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(48, 54, 61, 0.3) 1px, transparent 1px),
                linear-gradient(90deg, rgba(48, 54, 61, 0.3) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);
        }

        /* Card */
        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
            position: relative;
            z-index: 10;
            animation: fadeUp .5s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo top */
        .logo-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 28px;
        }

        .logo-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-blue));
            border-radius: 14px;
            display: grid;
            place-items: center;
            font-size: 26px;
            margin-bottom: 12px;
            box-shadow: 0 0 30px rgba(57, 208, 200, 0.25);
        }

        .logo-title {
            font-family: 'Sora', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.4px;
        }

        .logo-sub {
            font-size: 11px;
            color: var(--text-muted);
            letter-spacing: 1.8px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* Card box */
        .login-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 30px 28px;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent-teal), var(--accent-blue));
        }

        .card-heading {
            margin-bottom: 24px;
        }

        .card-heading h1 {
            font-family: 'Sora', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .card-heading p {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Error alert */
        .alert-error {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: rgba(248, 81, 73, 0.1);
            border: 1px solid rgba(248, 81, 73, 0.3);
            border-radius: 8px;
            padding: 11px 13px;
            margin-bottom: 20px;
            font-size: 13px;
            color: var(--accent-red);
            animation: fadeUp .3s ease both;
        }

        .alert-icon {
            font-size: 15px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Form */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: var(--text-secondary);
            margin-bottom: 7px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: var(--text-muted);
            pointer-events: none;
            transition: color .2s;
        }

        .form-input {
            width: 100%;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 11px 14px 11px 40px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: var(--text-primary);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        .form-input:focus {
            border-color: var(--accent-teal);
            box-shadow: 0 0 0 3px rgba(57, 208, 200, 0.1);
        }

        .form-input:focus+.input-icon,
        .input-wrap:focus-within .input-icon {
            color: var(--accent-teal);
        }

        /* Password toggle */
        .toggle-pw {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 16px;
            padding: 0;
            line-height: 1;
            transition: color .18s;
        }

        .toggle-pw:hover {
            color: var(--text-secondary);
        }

        /* Remember row */
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-secondary);
            cursor: pointer;
            user-select: none;
        }

        .remember-label input[type="checkbox"] {
            appearance: none;
            width: 16px;
            height: 16px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: all .15s;
            flex-shrink: 0;
        }

        .remember-label input[type="checkbox"]:checked {
            background: var(--accent-teal);
            border-color: var(--accent-teal);
        }

        .remember-label input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 10px;
            font-weight: 700;
            color: #0d1117;
        }

        .forgot-link {
            font-size: 12.5px;
            color: var(--accent-teal);
            text-decoration: none;
            font-weight: 500;
            transition: opacity .15s;
        }

        .forgot-link:hover {
            opacity: .75;
        }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-blue));
            border: none;
            border-radius: 9px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #0d1117;
            cursor: pointer;
            transition: opacity .2s, transform .15s, box-shadow .2s;
            letter-spacing: .3px;
            box-shadow: 0 4px 20px rgba(57, 208, 200, 0.2);
        }

        .btn-login:hover {
            opacity: .9;
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(57, 208, 200, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Footer note */
        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 11.5px;
            color: var(--text-muted);
        }

        .login-footer span {
            display: inline-block;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 5px 14px;
        }
    </style>
</head>

<body>

    <div class="grid-bg"></div>

    <div class="login-wrapper">

        <!-- Logo -->
        <div class="logo-area">
            <div class="logo-icon">⛰️</div>
            <div class="logo-title">SummitAdmin</div>
            <div class="logo-sub">Manajemen Pendakian</div>
        </div>

        <!-- Card -->
        <div class="login-card">

            <div class="card-heading">
                <h1>Masuk ke Dashboard</h1>
                <p>Silakan masukkan kredensial admin Anda</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <span class="alert-icon">⚠️</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <!-- Username -->
                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <div class="input-wrap">
                        <span class="input-icon">👤</span>
                        <input class="form-input" type="text" id="username" name="username"
                            placeholder="Masukkan username" value="{{ old('username') }}" autocomplete="username"
                            autofocus>
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">🔒</span>
                        <input class="form-input" type="password" id="password" name="password"
                            placeholder="Masukkan password" autocomplete="current-password"
                            style="padding-right: 42px;">
                        <button type="button" class="toggle-pw" id="togglePw" title="Tampilkan password">👁️</button>
                    </div>
                </div>

                <!-- Remember + Forgot -->
                <div class="form-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember">
                        Ingat saya
                    </label>
                    <a href="#" class="forgot-link">Lupa password?</a>
                </div>

                <button type="submit" class="btn-login">Masuk</button>

            </form>
        </div>

        <div class="login-footer">
            <span>🔐 Akses terbatas untuk administrator</span>
        </div>

    </div>

    <script>
        // Password toggle
        const toggleBtn = document.getElementById('togglePw');
        const pwInput = document.getElementById('password');

        toggleBtn.addEventListener('click', () => {
            const isHidden = pwInput.type === 'password';
            pwInput.type = isHidden ? 'text' : 'password';
            toggleBtn.textContent = isHidden ? '🙈' : '👁️';
        });
    </script>

</body>

</html>
