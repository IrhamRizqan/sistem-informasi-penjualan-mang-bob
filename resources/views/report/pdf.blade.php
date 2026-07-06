<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan - {{ $report->tanggal->format('d M Y') }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0 0 5px;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
            color: #666;
        }

        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 5px;
        }

        .summary-item {
            text-align: center;
        }

        .summary-item .label {
            font-size: 10px;
            color: #666;
            display: block;
        }

        .summary-item .value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #333;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .total-row {
            font-weight: bold;
            background: #e9ecef !important;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN HARIAN</h1>
        <p>Mie Ayam Bangka Mang Bob</p>
        <p>Jl. Tubagus Ismail No. 6, Sekeloa, Coblong, Bandung</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span class="label">Tanggal</span>
            <span class="value">{{ $report->tanggal->format('d/m/Y') }}</span>
        </div>
        <div class="summary-item">
            <span class="label">Total Transaksi</span>
            <span class="value">{{ $report->total_transaksi }}</span>
        </div>
        <div class="summary-item">
            <span class="label">Total Pendapatan</span>
            <span class="value">Rp {{ number_format($report->total_pendapatan, 0, ',', '.') }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Transaksi</th>
                <th>Waktu</th>
                <th>Kasir</th>
                <th>Item</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->nomor_transaksi }}</td>
                    <td>{{ $transaction->created_at->format('H:i') }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->items->pluck('menu.nama')->implode(', ') }}</td>
                    <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5">Total Pendapatan</td>
                <td>Rp {{ number_format($report->total_pendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
        <p>Sistem Informasi Penjualan Mie Ayam Mang Bob</p>
    </div>
</body>
</html>
