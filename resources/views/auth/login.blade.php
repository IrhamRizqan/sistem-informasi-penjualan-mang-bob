<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Mang Bob POS') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; overflow: hidden; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        :focus-visible {
            outline: 2px solid oklch(55% 0.20 260);
            outline-offset: 2px;
        }

        .split-layout {
            display: flex;
            height: 100vh;
        }

        /* ─── Left Panel ─── */
        .left-panel {
            flex: 1;
            background: oklch(18% 0.008 260);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 48px;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, oklch(35% 0.10 260 / 0.15), transparent 70%);
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, oklch(55% 0.20 260 / 0.06), transparent 70%);
        }

        .left-content {
            position: relative;
            z-index: 1;
            max-width: 480px;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: oklch(55% 0.20 260);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .brand-name {
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.02em;
        }

        .brand-tagline {
            color: oklch(65% 0.005 260);
            font-size: 0.8125rem;
            font-weight: 500;
        }

        .left-headline {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            line-height: 1.15;
            letter-spacing: -0.03em;
            margin-bottom: 16px;
        }

        .left-headline span {
            color: oklch(65% 0.20 260);
        }

        .left-description {
            font-size: 0.9375rem;
            color: oklch(55% 0.005 260);
            line-height: 1.6;
            max-width: 360px;
        }

        .left-footer {
            position: absolute;
            bottom: 32px;
            left: 48px;
            z-index: 1;
        }

        .left-footer p {
            color: oklch(40% 0.005 260);
            font-size: 0.75rem;
        }

        /* ─── Right Panel ─── */
        .right-panel {
            width: 480px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
        }

        .login-card {
            width: 100%;
            max-width: 360px;
        }

        .login-header {
            margin-bottom: 32px;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: oklch(15% 0.005 260);
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .login-header p {
            font-size: 0.875rem;
            color: oklch(50% 0.005 260);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: oklch(25% 0.005 260);
            margin-bottom: 6px;
        }

        .form-group .input-wrapper {
            position: relative;
        }

        .form-group .input-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: oklch(70% 0.005 260);
            font-size: 0.9375rem;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid oklch(88% 0.005 260);
            border-radius: 10px;
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            color: oklch(15% 0.005 260);
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            background: white;
        }

        .form-group input::placeholder {
            color: oklch(75% 0.005 260);
        }

        .form-group input:focus {
            outline: none;
            border-color: oklch(55% 0.20 260);
            box-shadow: 0 0 0 4px oklch(55% 0.20 260 / 0.10);
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: oklch(55% 0.20 260);
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.1s ease;
        }

        .btn-submit:hover {
            background: oklch(48% 0.20 260);
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        .alert {
            border-radius: 10px;
            font-size: 0.8125rem;
            padding: 12px 16px;
            margin-bottom: 20px;
            border: none;
        }

        .alert-danger {
            background: oklch(96% 0.04 25);
            color: oklch(30% 0.10 25);
        }

        .alert-success {
            background: oklch(96% 0.04 155);
            color: oklch(30% 0.10 155);
        }

        @media (max-width: 900px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="split-layout">
        <div class="left-panel">
            <div class="left-content">
                <div class="brand-badge">
                    <div class="brand-icon"><i class="bi bi-shop"></i></div>
                    <div>
                        <div class="brand-name">Mang Bob</div>
                        <div class="brand-tagline">Mie Ayam Bangka</div>
                    </div>
                </div>
                <div class="left-headline">
                    Kelola Penjualan<br>Jadi <span>Lebih Mudah</span>
                </div>
                <p class="left-description">
                    Sistem informasi penjualan modern untuk Mie Ayam Bangka Mang Bob.
                    Catat transaksi, kelola menu, dan lihat laporan penjualan dalam satu platform.
                </p>
            </div>
            <div class="left-footer">
                <p>&copy; {{ date('Y') }} Mang Bob POS. All rights reserved.</p>
            </div>
        </div>

        <div class="right-panel">
            <div class="login-card">
                <div class="login-header">
                    <h1>Selamat Datang</h1>
                    <p>Silakan masuk ke akun Anda</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope"></i>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   required autofocus autocomplete="username"
                                   placeholder="name@email.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock"></i>
                            <input type="password" id="password" name="password"
                                   required autocomplete="current-password"
                                   placeholder="Masukkan password">
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        Masuk ke Dashboard
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
