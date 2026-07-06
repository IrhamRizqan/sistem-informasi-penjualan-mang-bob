@extends('layouts.app')

@section('content')
<div class="topbar">
    <h1>Kelola Menu</h1>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#menuModal" onclick="resetForm()">
        <i class="bi bi-plus-lg me-1"></i> Tambah
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:40px;">No</th>
                        <th>Nama</th>
                        <th style="width:120px;">Harga</th>
                        <th style="width:80px;">Stok</th>
                        <th style="width:90px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $menu)
                        <tr>
                            <td style="color:var(--color-muted);">{{ $loop->iteration }}</td>
                            <td style="font-weight:500; color:var(--color-ink);">{{ $menu->nama }}</td>
                            <td class="table-num">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $menu->stok <= 5 ? 'badge-danger' : 'badge-success' }}">
                                    {{ $menu->stok }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex; gap:4px;">
                                    <button class="btn btn-sm" style="color:var(--color-muted); border:1px solid var(--color-rule);" onclick="editMenu({{ $menu }})">
                                        <i class="bi bi-pencil" style="font-size:0.75rem;"></i>
                                    </button>
                                    <button class="btn btn-sm" style="color:oklch(55% 0.20 25); border:1px solid oklch(90% 0.04 25);" onclick="deleteMenu({{ $menu->id }}, '{{ $menu->nama }}')">
                                        <i class="bi bi-trash" style="font-size:0.75rem;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="menuModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuModalTitle">Tambah Menu</h5>
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="modal"></button>
            </div>
            <form id="menuForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="menuId" name="_method" value="POST">
                    <div style="margin-bottom:16px;">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div style="margin-bottom:16px;">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control" id="harga" name="harga" min="0" required>
                    </div>
                    <div>
                        <label class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" style="color:var(--color-muted);border:1px solid var(--color-rule);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function resetForm() {
        document.getElementById('menuModalTitle').textContent = 'Tambah Menu';
        document.getElementById('menuForm').reset();
        document.getElementById('menuForm').action = '{{ route("menu.store") }}';
        document.querySelector('input[name="_method"]').value = 'POST';
    }

    function editMenu(m) {
        document.getElementById('menuModalTitle').textContent = 'Ubah Menu';
        document.getElementById('nama').value = m.nama;
        document.getElementById('harga').value = m.harga;
        document.getElementById('stok').value = m.stok;
        document.getElementById('menuForm').action = '{{ route("menu.update", ":id") }}'.replace(':id', m.id);
        document.querySelector('input[name="_method"]').value = 'PUT';
        new bootstrap.Modal(document.getElementById('menuModal')).show();
    }

    function deleteMenu(id, nama) {
        if (confirm('Hapus "' + nama + '"?')) {
            let f = document.createElement('form');
            f.method = 'POST';
            f.action = '{{ route("menu.destroy", ":id") }}'.replace(':id', id);
            f.innerHTML = '@csrf <input type="hidden" name="_method" value="DELETE">';
            document.body.appendChild(f);
            f.submit();
        }
    }
</script>
@endpush
