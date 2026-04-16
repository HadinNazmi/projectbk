<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sistem Jurnal Mengajar MTsN 3 Pekanbaru</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green-dark:  #0a4a2e;
            --green-mid:   #1a7a4a;
            --green-light: #2ecc71;
            --gold:        #c9a84c;
            --gold-light:  #f0d080;
            --white:       #ffffff;
            --gray-100:    #f5f5f0;
            --gray-300:    #d0cfc8;
            --gray-500:    #888880;
            --text-dark:   #1a1a18;
            --text-mid:    #4a4a45;
            --red:         #c0392b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--green-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Geometric background pattern */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(
                    60deg,
                    transparent,
                    transparent 80px,
                    rgba(255,255,255,0.03) 80px,
                    rgba(255,255,255,0.03) 81px
                ),
                repeating-linear-gradient(
                    -60deg,
                    transparent,
                    transparent 80px,
                    rgba(255,255,255,0.03) 80px,
                    rgba(255,255,255,0.03) 81px
                );
            pointer-events: none;
        }

        /* Gold accent blobs */
        body::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(201,168,76,0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            pointer-events: none;
        }

        .blob-bottom {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(46,204,113,0.12) 0%, transparent 70%);
            bottom: -100px;
            left: -50px;
            pointer-events: none;
        }

        /* Card */
        .card {
            position: relative;
            z-index: 10;
            background: var(--white);
            width: 100%;
            max-width: 440px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.08);
            animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(32px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Header strip */
        .card-header {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-mid) 100%);
            padding: 36px 40px 32px;
            display: flex;
            align-items: center;
            gap: 18px;
            position: relative;
            overflow: hidden;
        }

        .card-header::after {
            content: '';
            position: absolute;
            right: -30px;
            top: -30px;
            width: 120px;
            height: 120px;
            border: 2px solid rgba(201,168,76,0.3);
            border-radius: 50%;
        }

        .card-header::before {
            content: '';
            position: absolute;
            right: 10px;
            top: 10px;
            width: 70px;
            height: 70px;
            border: 2px solid rgba(201,168,76,0.2);
            border-radius: 50%;
        }

        .logo-wrap {
            width: 64px;
            height: 64px;
            border-radius: 14px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(201,168,76,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }

        .logo-wrap img {
            width: 52px;
            height: 52px;
            object-fit: contain;
        }

        /* Fallback icon jika logo tidak ada */
        .logo-icon {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon svg {
            width: 36px;
            height: 36px;
            fill: var(--gold-light);
        }

        .header-text { flex: 1; }

        .header-text h1 {
            font-size: 15px;
            font-weight: 700;
            color: var(--white);
            line-height: 1.3;
            letter-spacing: -0.2px;
        }

        .header-text p {
            font-size: 12px;
            color: rgba(255,255,255,0.6);
            margin-top: 3px;
            font-weight: 400;
        }

        .gold-divider {
            height: 3px;
            background: linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 50%, transparent 100%);
        }

        /* Body */
        .card-body {
            padding: 36px 40px 40px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }

        .section-sub {
            font-size: 13px;
            color: var(--gray-500);
            margin-top: 4px;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-mid);
            margin-bottom: 7px;
            letter-spacing: 0.1px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            pointer-events: none;
            display: flex;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid var(--gray-300);
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
            color: var(--text-dark);
            background: var(--gray-100);
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
            outline: none;
        }

        input:focus {
            border-color: var(--green-mid);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(26,122,74,0.1);
        }

        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gray-500);
            display: flex;
            padding: 2px;
            transition: color 0.2s;
        }
        .toggle-pw:hover { color: var(--green-mid); }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-mid) 100%);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            letter-spacing: 0.3px;
            margin-top: 8px;
            position: relative;
            overflow: hidden;
            transition: opacity 0.2s, transform 0.15s;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(201,168,76,0.2), transparent);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .btn-login:hover { opacity: 0.92; }
        .btn-login:hover::after { opacity: 1; }
        .btn-login:active { transform: scale(0.99); }

        /* Error */
        .alert-error {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff0ef;
            border: 1px solid #f5c6c2;
            border-left: 3px solid var(--red);
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 13px;
            color: var(--red);
            margin-top: 16px;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%      { transform: translateX(-6px); }
            60%      { transform: translateX(6px); }
        }

        /* Footer */
        .card-footer {
            text-align: center;
            padding: 14px 40px 20px;
            border-top: 1px solid var(--gray-100);
            font-size: 11.5px;
            color: var(--gray-500);
        }

        .card-footer span { color: var(--green-mid); font-weight: 600; }
    </style>
</head>
<body>
<div class="blob-bottom"></div>

<div class="card">
    <!-- Header -->
    <div class="card-header">
        <div class="logo-wrap">
            {{-- Ganti src dengan path logo asli jika ada --}}
            {{-- <img src="{{ asset('images/logo.png') }}" alt="Logo MTsN 3"> --}}
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
                </svg>
            </div>
        </div>
        <div class="header-text">
            <h1>MTsN 3 Pekanbaru</h1>
            <p>Madrasah Tsanawiyah Negeri 3 Pekanbaru</p>
        </div>
    </div>
    <div class="gold-divider"></div>

    <!-- Body -->
    <div class="card-body">
        <div class="section-title">Selamat Datang</div>
        <div class="section-sub">Masuk ke Sistem Jurnal Mengajar</div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </span>
                    <input type="text" id="username" name="username"
                           value="{{ old('username') }}"
                           placeholder="Masukkan username"
                           autocomplete="username">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                    <input type="password" id="password" name="password"
                           placeholder="Masukkan password"
                           autocomplete="current-password">
                    <button type="button" class="toggle-pw" onclick="togglePassword()" id="toggleBtn">
                        <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            @if(session('error'))
            <div class="alert-error">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif

            <button type="submit" class="btn-login">Masuk</button>
        </form>
    </div>

    <div class="card-footer">
        Sistem Jurnal Mengajar &copy; {{ date('Y') }} &nbsp;·&nbsp; <span>MTsN 3 Pekanbaru</span>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
}
</script>
</body>
</html>