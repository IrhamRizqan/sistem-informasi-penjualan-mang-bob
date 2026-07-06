@extends('layouts.app')

@section('content')
<div class="topbar">
    <h1>Laporan Harian</h1>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#generateModal">
        <i class="bi bi-plus-lg me-1"></i> Generate
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:40px;">No</th>
                        <th>Tanggal</th>
                        <th style="width:90px;">Transaksi</th>
                        <th>Pendapatan</th>
                        <th>Dibuat Oleh</th>
                        <th style="width:80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $r)
                        <tr>
                            <td style="color:var(--color-muted);">{{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}</td>
                            <td style="font-weight:500; color:var(--color-ink);">{{ $r->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $r->total_transaksi }}</td>
                            <td style="font-weight:600;" class="table-num">Rp {{ number_format($r->total_pendapatan, 0, ',', '.') }}</td>
                            <td>{{ $r->user->name }}</td>
                            <td>
                                <div style="display:flex; gap:4px;">
                                    <a href="{{ route('report.show', $r) }}" class="btn btn-sm" style="color:var(--color-accent);border:1px solid var(--color-accent-soft);text-decoration:none;">
                                        <i class="bi bi-eye" style="font-size:0.75rem;"></i>
                                    </a>
                                    <a href="{{ route('report.pdf', $r) }}" class="btn btn-sm" style="color:oklch(55% 0.20 25);border:1px solid oklch(90% 0.04 25);text-decoration:none;">
                                        <i class="bi bi-file-pdf" style="font-size:0.75rem;"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:40px 20px !important; color:var(--color-muted);">
                                Belum ada laporan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reports->hasPages())
            <div style="border-top:1px solid var(--color-rule); padding:12px 20px; display:flex; justify-content:center;">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="generateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:380px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Laporan</h5>
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('report.generate') }}">
                @csrf
                <div class="modal-body">
                    <div>
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" max="{{ now()->format('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" style="color:var(--color-muted);border:1px solid var(--color-rule);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
