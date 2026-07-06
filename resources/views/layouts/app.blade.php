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
        /* Hallmark · macrostructure: Studio · tone: utilitarian · anchor hue: 260 (cool-blue) */
        :root {
            --color-bg: oklch(97% 0.002 260);
            --color-surface: white;
            --color-ink: oklch(12% 0.005 260);
            --color-ink-2: oklch(35% 0.005 260);
            --color-muted: oklch(52% 0.005 260);
            --color-rule: oklch(91% 0.004 260);
            --color-accent: oklch(55% 0.20 260);
            --color-accent-hover: oklch(48% 0.20 260);
            --color-accent-soft: oklch(96% 0.03 260);

            --sidebar-w: 240px;
            --sidebar-bg: oklch(16% 0.006 260);
            --sidebar-hover: oklch(100% 0 0 / 0.06);
            --sidebar-active: oklch(55% 0.20 260);
            --sidebar-text: oklch(65% 0.005 260);
            --sidebar-text-hover: white;
            --sidebar-rule: oklch(100% 0 0 / 0.06);

            --radius: 10px;
            --radius-sm: 6px;
            --shadow-sm: 0 1px 3px oklch(12% 0.005 260 / 0.04);
            --shadow-md: 0 4px 12px oklch(12% 0.005 260 / 0.06);
        }

        html, body { overflow-x: clip; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--color-bg);
            color: var(--color-ink);
            min-height: 100vh;
            font-size: 0.875rem;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        :focus-visible {
            outline: 2px solid var(--color-accent);
            outline-offset: 2px;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }

        /* ─── Sidebar ─── */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w); height: 100vh;
            background: var(--sidebar-bg);
            z-index: 200;
            display: flex; flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 20px 20px 16px;
            display: flex; align-items: center; gap: 12px;
        }

        .sidebar-brand-icon {
            width: 36px; height: 36px;
            border-radius: var(--radius-sm);
            background: var(--color-accent);
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1rem;
            flex-shrink: 0;
        }

        .sidebar-brand-text {
            font-weight: 700; font-size: 0.9375rem;
            color: oklch(92% 0.005 260);
            letter-spacing: -0.02em;
        }

        .sidebar-section {
            padding: 20px 20px 6px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: oklch(45% 0.005 260);
        }

        .sidebar-nav {
            flex: 1;
            padding: 4px 10px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px;
            margin: 1px 0;
            border-radius: var(--radius-sm);
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.8125rem;
            font-weight: 500;
            transition: background 0.12s, color 0.12s;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text-hover);
        }

        .nav-item.active {
            background: var(--sidebar-active);
            color: white;
            border-left-color: transparent;
        }

        .nav-item i {
            width: 16px;
            font-size: 0.875rem;
            opacity: 0.7;
            text-align: center;
        }

        .nav-item.active i { opacity: 1; }

        .sidebar-user {
            padding: 12px 16px;
            border-top: 1px solid var(--sidebar-rule);
            display: flex; align-items: center; gap: 10px;
        }

        .sidebar-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: oklch(35% 0.01 260);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 600;
            color: oklch(80% 0.005 260);
            flex-shrink: 0;
        }

        .sidebar-user-info { flex: 1; min-width: 0; }

        .sidebar-user-name {
            font-size: 0.8125rem; font-weight: 500;
            color: oklch(85% 0.005 260);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 0.65rem;
            color: oklch(50% 0.005 260);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar-logout {
            display: flex; align-items: center; justify-content: center; gap: 4px;
            width: 100%; margin-top: 8px;
            padding: 5px;
            border: none; border-radius: var(--radius-sm);
            background: oklch(100% 0 0 / 0.04);
            color: oklch(55% 0.005 260);
            font-size: 0.7rem; font-weight: 500;
            cursor: pointer;
            transition: background 0.12s, color 0.12s;
            font-family: 'Inter', sans-serif;
        }

        .sidebar-logout:hover {
            background: oklch(100% 0 0 / 0.08);
            color: oklch(80% 0.005 260);
        }

        /* ─── Main ─── */
        .main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        .topbar {
            position: sticky; top: 0; z-index: 100;
            background: var(--color-surface);
            border-bottom: 1px solid var(--color-rule);
            padding: 16px 32px;
            display: flex; align-items: center; justify-content: space-between;
        }

        .topbar h1 {
            font-size: 1.125rem; font-weight: 600;
            color: var(--color-ink);
            margin: 0;
        }

        .topbar-meta {
            font-size: 0.8rem; color: var(--color-muted);
        }

        .page-content {
            padding: 28px 32px;
            flex: 1;
        }

        /* ─── Cards ─── */
        .card {
            border: 1px solid var(--color-rule);
            border-radius: var(--radius);
            background: var(--color-surface);
            box-shadow: var(--shadow-sm);
        }

        .card-body { padding: 0; }
        .card-body-inset { padding: 20px; }

        /* ─── Stat Grid ─── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--color-surface);
            border: 1px solid var(--color-rule);
            border-radius: var(--radius);
            padding: 20px;
            display: flex; flex-direction: column;
            gap: 12px;
        }

        .stat-card-top { display: flex; align-items: center; justify-content: space-between; }

        .stat-icon {
            width: 40px; height: 40px;
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }

        .stat-icon--accent { background: var(--color-accent-soft); color: var(--color-accent); }
        .stat-icon--success { background: oklch(96% 0.04 155); color: oklch(45% 0.15 155); }
        .stat-icon--warning { background: oklch(96% 0.05 75); color: oklch(55% 0.16 75); }
        .stat-icon--info { background: oklch(96% 0.03 250); color: oklch(45% 0.12 250); }

        .stat-trend {
            font-size: 0.7rem; font-weight: 600;
            padding: 2px 8px; border-radius: 20px;
        }

        .stat-trend--up { background: oklch(96% 0.04 155); color: oklch(45% 0.15 155); }
        .stat-trend--down { background: oklch(96% 0.04 25); color: oklch(45% 0.15 25); }

        .stat-label {
            font-size: 0.75rem; color: var(--color-muted);
            font-weight: 500;
        }

        .stat-value {
            font-size: 1.375rem; font-weight: 700;
            color: var(--color-ink);
            letter-spacing: -0.03em;
            line-height: 1.1;
        }

        /* ─── Tables ─── */
        .table-wrap {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8125rem;
        }

        .table thead th {
            text-align: left;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--color-muted);
            padding: 12px 20px;
            background: var(--color-bg);
            border-bottom: 1px solid var(--color-rule);
            white-space: nowrap;
        }

        .table tbody td {
            padding: 12px 20px;
            border-bottom: 1px solid var(--color-rule);
            color: var(--color-ink-2);
            vertical-align: middle;
        }

        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover td { background: oklch(98% 0.002 260); }

        .table-num {
            font-variant-numeric: tabular-nums;
        }

        .table-empty td {
            text-align: center;
            padding: 40px 20px !important;
            color: var(--color-muted) !important;
        }

        /* ─── Buttons ─── */
        .btn {
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-weight: 500;
            font-size: 0.8125rem;
            transition: all 0.12s;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary {
            background: var(--color-accent);
            border-color: var(--color-accent);
            color: white;
        }

        .btn-primary:hover {
            background: var(--color-accent-hover);
            border-color: var(--color-accent-hover);
            color: white;
        }

        .btn-sm {
            padding: 4px 10px;
            font-size: 0.75rem;
        }

        /* ─── Badges ─── */
        .badge {
            font-weight: 500;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 4px;
        }

        .badge-success { background: oklch(96% 0.04 155); color: oklch(35% 0.12 155); }
        .badge-danger { background: oklch(96% 0.04 25); color: oklch(35% 0.12 25); }

        /* ─── Forms ─── */
        .form-control {
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--color-rule);
            font-size: 0.8125rem;
            padding: 9px 12px;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            border-color: var(--color-accent);
            box-shadow: 0 0 0 3px oklch(55% 0.20 260 / 0.10);
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--color-ink-2);
            margin-bottom: 4px;
        }

        /* ─── Alert ─── */
        .alert {
            border: none;
            border-radius: var(--radius-sm);
            font-size: 0.8125rem;
            padding: 10px 16px;
            margin-bottom: 20px;
        }

        .alert-success { background: oklch(96% 0.04 155); color: oklch(30% 0.10 155); }
        .alert-danger { background: oklch(96% 0.04 25); color: oklch(30% 0.10 25); }

        /* ─── Modal ─── */
        .modal-content {
            border: 1px solid var(--color-rule);
            border-radius: var(--radius);
            box-shadow: 0 10px 40px oklch(12% 0.005 260 / 0.12);
        }

        .modal-header {
            border-bottom: 1px solid var(--color-rule);
            padding: 16px 20px;
        }

        .modal-body { padding: 20px; }

        .modal-footer {
            border-top: 1px solid var(--color-rule);
            padding: 12px 20px;
        }

        /* ─── Pagination ─── */
        .pagination { gap: 4px; }

        .page-link {
            border-radius: var(--radius-sm);
            border: 1px solid var(--color-rule);
            color: var(--color-ink-2);
            font-size: 0.8125rem;
            padding: 6px 12px;
        }

        .page-link:hover {
            background: var(--color-bg);
            border-color: var(--color-rule);
        }

        .page-item.active .page-link {
            background: var(--color-accent);
            border-color: var(--color-accent);
            color: white;
        }

        /* ─── Mobile ─── */
        .mobile-header {
            display: none;
            position: fixed; top: 0; left: 0; right: 0;
            height: 52px;
            background: var(--color-surface);
            border-bottom: 1px solid var(--color-rule);
            align-items: center;
            padding: 0 16px;
            gap: 10px;
            z-index: 150;
        }

        .mobile-header-brand { font-weight: 600; font-size: 0.875rem; }

        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.2s ease;
            }

            .sidebar.show { transform: translateX(0); }

            .main { margin-left: 0; }

            .topbar { display: none; }

            .page-content { padding: 20px 16px; padding-top: calc(52px + 20px); }

            .mobile-header { display: flex; }

            .sidebar-overlay {
                display: none;
                position: fixed; inset: 0;
                background: oklch(0% 0 0 / 0.4);
                z-index: 199;
            }

            .sidebar-overlay.show { display: block; }

            .stat-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 575px) {
            .stat-grid { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon"><i class="bi bi-shop"></i></div>
            <span class="sidebar-brand-text">Mang Bob</span>
        </div>

        <div class="sidebar-section">Menu Utama</div>

        <nav class="sidebar-nav">
            @if(Auth::user()->isOwner())
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
                <a href="{{ route('menu.index') }}" class="nav-item {{ request()->routeIs('menu.*') ? 'active' : '' }}">
                    <i class="bi bi-bookmark-fill"></i> Menu
                </a>
            @endif

            @if(Auth::user()->isKasir())
                <a href="{{ route('transaction.index') }}" class="nav-item {{ request()->routeIs('transaction.index') ? 'active' : '' }}">
                    <i class="bi bi-cart-fill"></i> Transaksi
                </a>
            @endif

            <div class="sidebar-section">Data</div>

            <a href="{{ route('history') }}" class="nav-item {{ request()->routeIs('history*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>

            @if(Auth::user()->isOwner())
                <a href="{{ route('report.index') }}" class="nav-item {{ request()->routeIs('report.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill"></i> Laporan
                </a>
            @endif
        </nav>

        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                <div class="sidebar-user-role">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display:contents;">
                @csrf
                <button type="submit" style="background:none; border:none; color:oklch(50% 0.005 260); cursor:pointer; padding:4px; font-size:0.9rem;" title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </aside>

    <div class="main">
        <header class="mobile-header">
            <button class="btn p-1" id="sidebarToggle" aria-label="Toggle menu" style="border:none; font-size:1.25rem;">
                <i class="bi bi-list"></i>
            </button>
            <span class="mobile-header-brand">Mang Bob</span>
        </header>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('sidebarToggle');

        if (toggle) {
            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
