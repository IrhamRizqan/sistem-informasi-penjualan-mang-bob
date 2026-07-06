@extends('layouts.app')

@section('content')
<div class="topbar">
    <h1>Riwayat Transaksi</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:40px;">No</th>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th style="width:120px;">Total</th>
                        <th style="width:60px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                        <tr>
                            <td style="color:var(--color-muted);">{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</td>
                            <td style="font-weight:500; color:var(--color-ink);" class="table-num">{{ $t->nomor_transaksi }}</td>
                            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $t->user->name }}</td>
                            <td style="font-weight:600;" class="table-num">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('detail', $t) }}" class="btn btn-sm" style="color:var(--color-accent);border:1px solid var(--color-accent-soft);text-decoration:none;">
                                    <i class="bi bi-eye" style="font-size:0.75rem;"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:40px 20px !important; color:var(--color-muted);">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div style="border-top:1px solid var(--color-rule); padding:12px 20px; display:flex; justify-content:center;">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
