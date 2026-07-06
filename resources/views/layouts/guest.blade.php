<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Mang Bob POS') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --color-paper: oklch(98% 0.002 260);
            --color-ink: oklch(15% 0.005 260);
            --color-muted: oklch(50% 0.005 260);
            --color-rule: oklch(90% 0.004 260);
            --color-accent: oklch(55% 0.20 260);
            --color-accent-hover: oklch(48% 0.20 260);
            --font-body: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-body);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--color-paper);
            -webkit-font-smoothing: antialiased;
            font-size: 0.875rem;
        }

        :focus-visible {
            outline: 2px solid var(--color-accent);
            outline-offset: 2px;
        }

        /* Shared auth card styles */
        .login-container { width: 100%; max-width: 420px; padding: 20px; }
        .login-card { background: #fff; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); padding: 40px; }
        .login-brand { text-align: center; margin-bottom: 32px; }
        .login-brand .logo { width: 80px; height: 80px; background: var(--color-accent); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: #fff; font-size: 2rem; }
        .login-brand h1 { font-size: 1.5rem; font-weight: 700; color: var(--color-ink); margin: 0; }
        .login-brand p { color: var(--color-muted); font-size: 0.9rem; margin: 4px 0 0; }
        .form-label { font-weight: 500; color: var(--color-ink); font-size: 0.9rem; }
        .form-control { border-radius: 8px; padding: 12px 16px; border: 1px solid var(--color-rule); }
        .form-control:focus { border-color: var(--color-accent); box-shadow: 0 0 0 3px oklch(55% 0.20 260 / 0.15); }
        .btn-login { background: var(--color-accent); border: none; border-radius: 8px; padding: 12px; font-weight: 600; width: 100%; color: #fff; cursor: pointer; }
        .btn-login:hover { background: var(--color-accent-hover); color: #fff; }
        .alert { border-radius: 8px; font-size: 0.875rem; padding: 12px 16px; margin-bottom: 20px; border: none; }
        .alert-danger { background: oklch(96% 0.04 25); color: oklch(30% 0.10 25); }
        .alert-success { background: oklch(96% 0.04 155); color: oklch(30% 0.10 155); }
        .text-muted { color: var(--color-muted); }
        .text-center { text-align: center; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mt-3 { margin-top: 0.75rem; }
    </style>
</head>
<body>
    {{ $slot }}
</body>
</html>
