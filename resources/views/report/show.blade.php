@extends('layouts.app')

@section('content')
<div class="topbar">
    <h1>Detail Laporan</h1>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('report.pdf', $report) }}" class="btn btn-sm" style="color:oklch(55% 0.20 25);border:1px solid oklch(90% 0.04 25);text-decoration:none;">
            <i class="bi bi-file-pdf me-1"></i> Export PDF
        </a>
        <a href="{{ route('report.index') }}" class="btn btn-sm" style="color:var(--color-muted);border:1px solid var(--color-rule);text-decoration:none;">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="stat-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon stat-icon--success"><i class="bi bi-currency-dollar"></i></div>
        </div>
        <div>
            <div class="stat-value">Rp {{ number_format($report->total_pendapatan, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pendapatan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon stat-icon--accent"><i class="bi bi-receipt"></i></div>
        </div>
        <div>
            <div class="stat-value">{{ $report->total_transaksi }}</div>
            <div class="stat-label">Total Transaksi</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon stat-icon--info"><i class="bi bi-calendar"></i></div>
        </div>
        <div>
            <div class="stat-value">{{ $report->tanggal->format('d M Y') }}</div>
            <div class="stat-label">Tanggal Laporan</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="card-body-inset" style="border-bottom:1px solid var(--color-rule);">
            <span style="font-weight:600; font-size:0.875rem;">Transaksi pada {{ $report->tanggal->format('d M Y') }}</span>
        </div>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:40px;">No</th>
                        <th>No. Transaksi</th>
                        <th>Waktu</th>
                        <th>Kasir</th>
                        <th style="width:120px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td style="color:var(--color-muted);">{{ $loop->iteration }}</td>
                            <td style="font-weight:500; color:var(--color-ink);" class="table-num">{{ $transaction->nomor_transaksi }}</td>
                            <td>{{ $transaction->created_at->format('H:i') }}</td>
                            <td>{{ $transaction->user->name }}</td>
                            <td style="font-weight:600;" class="table-num">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr class="table-empty">
                            <td colspan="5">Tidak ada transaksi pada tanggal ini</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
