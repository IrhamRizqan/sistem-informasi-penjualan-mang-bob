@extends('layouts.app')

@section('content')
<div class="topbar">
    <h1>Dashboard</h1>
    <span class="topbar-meta">{{ now()->format('l, d M Y') }}</span>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon stat-icon--accent"><i class="bi bi-currency-dollar"></i></div>
            <span class="stat-trend stat-trend--up">+12%</span>
        </div>
        <div>
            <div class="stat-value">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
            <div class="stat-label">Pendapatan Hari Ini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon stat-icon--info"><i class="bi bi-receipt"></i></div>
        </div>
        <div>
            <div class="stat-value">{{ $todayTransactions }}</div>
            <div class="stat-label">Transaksi Hari Ini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon stat-icon--success"><i class="bi bi-bookmark"></i></div>
        </div>
        <div>
            <div class="stat-value">{{ $menuCount }}</div>
            <div class="stat-label">Total Menu</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon stat-icon--warning"><i class="bi bi-exclamation-triangle"></i></div>
            @if($lowStock > 0)
                <span class="stat-trend stat-trend--down">{{ $lowStock }} butuh restock</span>
            @endif
        </div>
        <div>
            <div class="stat-value">{{ $lowStock }}</div>
            <div class="stat-label">Stok Menipis</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div style="padding:16px 20px; border-bottom:1px solid var(--color-rule); display:flex; align-items:center; justify-content:space-between;">
                    <span style="font-weight:600; font-size:0.875rem;">Penjualan 7 Hari Terakhir</span>
                </div>
                <div style="padding:16px 20px;">
                    <canvas id="salesChart" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card" style="height:100%;">
            <div class="card-body" style="display:flex; flex-direction:column;">
                <div style="padding:16px 20px; border-bottom:1px solid var(--color-rule);">
                    <span style="font-weight:600; font-size:0.875rem;">Transaksi Terakhir</span>
                </div>
                <div style="flex:1;">
                    @if($recentTransactions->isEmpty())
                        <div style="padding:32px 20px; text-align:center; color:var(--color-muted); font-size:0.8125rem;">
                            Belum ada transaksi hari ini
                        </div>
                    @else
                        @foreach($recentTransactions as $transaction)
                            <div style="padding:10px 20px; border-bottom:1px solid var(--color-rule); display:flex; justify-content:space-between; align-items:center;">
                                <div>
                                    <div style="font-weight:600; font-size:0.8125rem; color:var(--color-ink);">{{ $transaction->nomor_transaksi }}</div>
                                    <div style="font-size:0.7rem; color:var(--color-muted); margin-top:1px;">{{ $transaction->user->name }} · {{ $transaction->created_at->format('H:i') }}</div>
                                </div>
                                <div style="font-weight:600; font-size:0.8125rem; color:var(--color-ink);">Rp {{ number_format($transaction->total, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    fetch('/api/sales-chart')
        .then(r => r.json())
        .then(data => {
            const ctx = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: data.values,
                        backgroundColor: 'oklch(55% 0.20 260 / 0.70)',
                        borderRadius: 4,
                        maxBarThickness: 32
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Inter', size: 11 }, color: 'oklch(52% 0.005 260)' }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'oklch(91% 0.004 260)' },
                            border: { display: false },
                            ticks: {
                                font: { family: 'Inter', size: 11 },
                                color: 'oklch(52% 0.005 260)',
                                callback: v => 'Rp ' + v.toLocaleString('id-ID')
                            }
                        }
                    }
                }
            });
        });
</script>
@endpush
