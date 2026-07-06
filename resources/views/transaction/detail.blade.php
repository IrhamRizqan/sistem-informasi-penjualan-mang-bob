@extends('layouts.app')

@section('content')
<div class="topbar">
    <h1>Detail Transaksi</h1>
    <a href="{{ route('history') }}" class="btn btn-sm" style="color:var(--color-muted);border:1px solid var(--color-rule);">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40px;">No</th>
                                <th>Menu</th>
                                <th>Harga</th>
                                <th style="width:80px;">Jumlah</th>
                                <th style="width:120px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->items as $item)
                                <tr>
                                    <td style="color:var(--color-muted);">{{ $loop->iteration }}</td>
                                    <td style="font-weight:500; color:var(--color-ink);">{{ $item->menu->nama }}</td>
                                    <td class="table-num">Rp {{ number_format($item->menu->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td style="font-weight:600;" class="table-num">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="card-body-inset">
                    <div style="margin-bottom:16px;">
                        <div style="font-size:0.7rem; color:var(--color-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:4px;">No. Transaksi</div>
                        <div style="font-weight:700; color:var(--color-ink);">{{ $transaction->nomor_transaksi }}</div>
                    </div>
                    <div style="margin-bottom:16px;">
                        <div style="font-size:0.7rem; color:var(--color-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:4px;">Tanggal</div>
                        <div style="font-weight:700; color:var(--color-ink);">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div style="margin-bottom:16px;">
                        <div style="font-size:0.7rem; color:var(--color-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:4px;">Kasir</div>
                        <div style="font-weight:700; color:var(--color-ink);">{{ $transaction->user->name }}</div>
                    </div>
                    <hr style="border:none; border-top:1px solid var(--color-rule); margin:16px 0;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                        <span style="color:var(--color-ink-2);">Total:</span>
                        <span style="font-weight:700; color:var(--color-ink);">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                        <span style="color:var(--color-ink-2);">Tunai:</span>
                        <span style="font-weight:700; color:var(--color-ink);">Rp {{ number_format($transaction->bayar, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:var(--color-ink-2);">Kembali:</span>
                        <span style="font-weight:700; color:oklch(45% 0.15 155);">Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('transaction.receipt', $transaction) }}" class="btn btn-primary w-100" style="margin-top:16px; padding:12px;">
            <i class="bi bi-printer me-1"></i> Cetak Struk
        </a>
    </div>
</div>
@endsection
