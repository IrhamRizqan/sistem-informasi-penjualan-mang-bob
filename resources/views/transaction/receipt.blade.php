<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk - {{ $transaction->nomor_transaksi }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #fff; }
            .receipt-card { box-shadow: none !important; border: none !important; }
        }

        body {
            background: #f8f9fa;
            font-family: 'Courier New', monospace;
        }

        .receipt-card {
            max-width: 400px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 24px;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 2px dashed #dee2e6;
            padding-bottom: 16px;
            margin-bottom: 16px;
        }

        .receipt-header h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
        }

        .receipt-header p {
            font-size: 0.8rem;
            color: #6c757d;
            margin: 4px 0 0;
        }

        .receipt-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 0.9rem;
        }

        .receipt-total {
            border-top: 2px dashed #dee2e6;
            padding-top: 12px;
            margin-top: 12px;
        }

        .receipt-total .row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            font-weight: 600;
        }

        .receipt-footer {
            text-align: center;
            border-top: 2px dashed #dee2e6;
            padding-top: 16px;
            margin-top: 16px;
            font-size: 0.8rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="no-print text-center mt-3">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer me-2"></i> Cetak Struk
        </button>
        <a href="{{ route('transaction.index') }}" class="btn btn-secondary ms-2">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="receipt-card">
        <div class="receipt-header">
            <h3>MANG BOB</h3>
            <p>Mie Ayam Bangka</p>
            <p>Jl. Tubagus Ismail No. 6, Bandung</p>
        </div>

        <div class="receipt-info mb-3">
            <div class="receipt-item">
                <span>No. Transaksi</span>
                <span>{{ $transaction->nomor_transaksi }}</span>
            </div>
            <div class="receipt-item">
                <span>Tanggal</span>
                <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="receipt-item">
                <span>Kasir</span>
                <span>{{ $transaction->user->name }}</span>
            </div>
        </div>

        <div class="receipt-items mb-3">
            @foreach($transaction->items as $item)
                <div class="receipt-item">
                    <span>{{ $item->menu->nama }} x{{ $item->jumlah }}</span>
                    <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div class="receipt-total">
            <div class="row">
                <span>Total</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
            <div class="row">
                <span>Tunai</span>
                <span>Rp {{ number_format($transaction->bayar, 0, ',', '.') }}</span>
            </div>
            <div class="row">
                <span>Kembali</span>
                <span>Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="receipt-footer">
            <p>Terima kasih atas kunjungan Anda</p>
            <p>Selamat menikmati</p>
        </div>
    </div>
</body>
</html>
