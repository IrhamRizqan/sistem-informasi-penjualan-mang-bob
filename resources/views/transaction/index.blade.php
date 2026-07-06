@extends('layouts.app')

@section('content')
<div class="topbar">
    <h1>Transaksi Baru</h1>
</div>

<div class="row g-4" style="min-height: calc(100vh - 140px);">
    <div class="col-lg-7">
        <div class="card" style="height:100%; display:flex; flex-direction:column;">
            <div class="card-body" style="display:flex; flex-direction:column; flex:1;">
                <div style="padding:0 0 12px; display:flex; align-items:center; gap:10px; border-bottom:1px solid var(--color-rule); margin-bottom:16px;">
                    <span style="font-weight:600; font-size:0.875rem;">Menu</span>
                    <div style="flex:1; max-width:240px; margin-left:auto;">
                        <input type="text" class="form-control" id="searchMenu" placeholder="Cari menu..." onkeyup="filterMenu()" style="padding:6px 10px; font-size:0.8rem;">
                    </div>
                </div>
                <div style="flex:1; overflow-y: auto; margin: -4px;">
                    <div class="row g-2" id="menuList">
                        @foreach($menus as $menu)
                            <div class="col-6 col-md-4 col-lg-3 menu-item" data-nama="{{ strtolower($menu->nama) }}">
                                <div class="pos-card" onclick="addMenu({{ $menu->id }}, '{{ $menu->nama }}', {{ $menu->harga }}, {{ $menu->stok }})">
                                    <div class="pos-card-bg"></div>
                                    <div class="pos-card-icon">
                                        <i class="bi bi-bowl-hot"></i>
                                    </div>
                                    <div class="pos-card-name">{{ $menu->nama }}</div>
                                    <div class="pos-card-price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                                    <div class="pos-card-stock">
                                        <span class="badge {{ $menu->stok <= 5 ? 'badge-danger' : 'badge-success' }}">{{ $menu->stok }} stok</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card" style="height:100%; display:flex; flex-direction:column;">
            <div style="padding:14px 20px; border-bottom:1px solid var(--color-rule); display:flex; align-items:center; gap:8px;">
                <i class="bi bi-cart3" style="color:var(--color-muted);"></i>
                <span style="font-weight:600; font-size:0.875rem;">Pesanan</span>
            </div>

            <div id="orderList" style="flex:1; overflow-y: auto; padding:10px 20px;">
                <div class="empty-cart" id="emptyOrder">
                    <i class="bi bi-cart3" style="font-size:2.5rem; color:var(--color-rule);"></i>
                    <p>Pilih menu untuk memulai transaksi</p>
                </div>
            </div>

            <div style="border-top:1px solid var(--color-rule); padding:16px 20px; background:var(--color-bg);">
                <div style="display:flex; justify-content:space-between; align-items:baseline; margin-bottom:12px;">
                    <span style="font-size:0.8125rem; color:var(--color-muted);">Total</span>
                    <span style="font-size:1.25rem; font-weight:700; color:var(--color-ink);" id="subtotal">Rp 0</span>
                </div>

                <form id="transactionForm" method="POST" action="{{ route('transaction.store') }}">
                    @csrf
                    <div id="itemsContainer"></div>

                    <div style="margin-bottom:8px;">
                        <label style="font-size:0.75rem; font-weight:600; color:var(--color-ink-2); margin-bottom:4px; display:block;">Jumlah Bayar</label>
                        <input type="number" class="form-control" id="bayar" name="bayar" min="0" oninput="calculateChange()" placeholder="0" required>
                    </div>

                    <div style="display:flex; justify-content:space-between; margin-bottom:14px;">
                        <span style="font-size:0.8125rem; color:var(--color-muted);">Kembalian</span>
                        <span style="font-weight:700; font-size:0.9375rem;" id="kembalian">Rp 0</span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="btnBayar" disabled style="padding:12px; font-size:0.875rem;">
                        <i class="bi bi-check-lg me-1"></i> Bayar Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .pos-card {
        cursor: pointer;
        border: 1px solid var(--color-rule);
        border-radius: var(--radius);
        padding: 14px 10px;
        background: var(--color-surface);
        transition: border-color 0.15s, box-shadow 0.15s, transform 0.1s;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .pos-card:hover {
        border-color: var(--color-accent);
        box-shadow: 0 0 0 1px var(--color-accent);
        transform: translateY(-1px);
    }

    .pos-card:active {
        transform: scale(0.97);
    }

    .pos-card-bg {
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: var(--color-accent);
        opacity: 0;
        transition: opacity 0.15s;
    }

    .pos-card:hover .pos-card-bg {
        opacity: 1;
    }

    .pos-card-icon {
        font-size: 1.5rem;
        color: var(--color-accent);
        margin-bottom: 6px;
    }

    .pos-card-name {
        font-weight: 600;
        font-size: 0.8125rem;
        color: var(--color-ink);
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pos-card-price {
        font-weight: 700;
        font-size: 0.8125rem;
        color: var(--color-ink);
        margin-bottom: 6px;
    }

    .pos-card-stock .badge {
        font-size: 0.65rem;
        padding: 1px 6px;
    }

    .empty-cart {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        min-height: 200px;
        color: var(--color-muted);
        gap: 12px;
    }

    .empty-cart p {
        font-size: 0.8125rem;
        margin: 0;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid var(--color-rule);
    }

    .order-item:last-child { border-bottom: none; }

    .order-item-left { flex: 1; min-width: 0; }

    .order-item-name {
        font-weight: 600;
        font-size: 0.8125rem;
        color: var(--color-ink);
    }

    .order-item-detail {
        font-size: 0.7rem;
        color: var(--color-muted);
        margin-top: 1px;
    }

    .order-item-controls {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .qty-btn {
        width: 26px; height: 26px;
        border-radius: 6px;
        border: 1px solid var(--color-rule);
        background: var(--color-surface);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem;
        color: var(--color-ink-2);
        cursor: pointer;
        transition: background 0.1s;
        line-height: 1;
    }

    .qty-btn:hover { background: var(--color-bg); }

    .qty-value {
        font-weight: 600;
        font-size: 0.8125rem;
        min-width: 20px;
        text-align: center;
    }

    .order-item-total {
        font-weight: 600;
        font-size: 0.8125rem;
        color: var(--color-ink);
        min-width: 70px;
        text-align: right;
        font-variant-numeric: tabular-nums;
    }

    .text-success { color: oklch(45% 0.15 155) !important; }
    .text-danger { color: oklch(55% 0.20 25) !important; }
</style>
@endpush

@push('scripts')
<script>
    let orders = [];

    function filterMenu() {
        const q = document.getElementById('searchMenu').value.toLowerCase();
        document.querySelectorAll('.menu-item').forEach(e => {
            e.style.display = e.dataset.nama.includes(q) ? '' : 'none';
        });
    }

    function addMenu(id, nama, harga, stok) {
        const ex = orders.find(o => o.menu_id === id);
        if (ex) { if (ex.jumlah < stok) ex.jumlah++; }
        else { orders.push({ menu_id: id, nama, harga, jumlah: 1, stok }); }
        renderOrders();
    }

    function updateQty(i, d) {
        const o = orders[i];
        const n = o.jumlah + d;
        if (n > 0 && n <= o.stok) { o.jumlah = n; }
        else if (n <= 0) { orders.splice(i, 1); }
        renderOrders();
    }

    function renderOrders() {
        const c = document.getElementById('orderList');
        if (orders.length === 0) {
            c.innerHTML = '<div class="empty-cart" id="emptyOrder"><i class="bi bi-cart3" style="font-size:2.5rem;color:var(--color-rule);"></i><p>Pilih menu untuk memulai transaksi</p></div>';
            document.getElementById('subtotal').textContent = 'Rp 0';
            document.getElementById('btnBayar').disabled = true;
            return;
        }

        let html = '', total = 0;
        orders.forEach((o, i) => {
            const s = o.harga * o.jumlah;
            total += s;
            html += '<div class="order-item"><div class="order-item-left"><div class="order-item-name">' + o.nama + '</div><div class="order-item-detail">Rp ' + o.harga.toLocaleString('id-ID') + ' x ' + o.jumlah + '</div></div><div class="order-item-controls"><div style="display:flex;align-items:center;gap:4px;"><button class="qty-btn" onclick="updateQty(' + i + ',-1)">-</button><span class="qty-value">' + o.jumlah + '</span><button class="qty-btn" onclick="updateQty(' + i + ',1)">+</button></div><span class="order-item-total">Rp ' + s.toLocaleString('id-ID') + '</span></div></div>';
        });

        c.innerHTML = html;
        document.getElementById('subtotal').textContent = 'Rp ' + total.toLocaleString('id-ID');

        const ic = document.getElementById('itemsContainer');
        ic.innerHTML = '';
        orders.forEach((o, i) => {
            let m = document.createElement('input'); m.type = 'hidden'; m.name = 'items[' + i + '][menu_id]'; m.value = o.menu_id; ic.appendChild(m);
            let j = document.createElement('input'); j.type = 'hidden'; j.name = 'items[' + i + '][jumlah]'; j.value = o.jumlah; ic.appendChild(j);
        });

        document.getElementById('btnBayar').disabled = false;
        calculateChange();
    }

    function calculateChange() {
        const total = orders.reduce((s, o) => s + o.harga * o.jumlah, 0);
        const bayar = parseInt(document.getElementById('bayar').value) || 0;
        const ch = bayar - total;
        const el = document.getElementById('kembalian');
        el.textContent = 'Rp ' + Math.max(0, ch).toLocaleString('id-ID');
        el.style.color = ch >= 0 ? 'oklch(45% 0.15 155)' : 'oklch(55% 0.20 25)';
        el.style.fontWeight = '700';
        el.style.fontSize = '0.9375rem';
    }

    document.getElementById('transactionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const total = orders.reduce((s, o) => s + o.harga * o.jumlah, 0);
        const bayar = parseInt(document.getElementById('bayar').value) || 0;
        if (bayar < total) { alert('Jumlah bayar kurang!'); return; }
        this.submit();
    });
</script>
@endpush
@endsection
