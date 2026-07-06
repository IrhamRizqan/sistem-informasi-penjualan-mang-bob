<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function create(int $userId, array $items, float $bayar): Transaction
    {
        return DB::transaction(function () use ($userId, $items, $bayar) {
            $menus = [];
            $total = 0;

            foreach ($items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);
                $subtotal = $menu->harga * $item['jumlah'];
                $total += $subtotal;
                $menus[$menu->id] = ['menu' => $menu, 'jumlah' => $item['jumlah'], 'subtotal' => $subtotal];
            }

            $transaction = Transaction::create([
                'user_id' => $userId,
                'nomor_transaksi' => Transaction::generateNomorTransaksi(),
                'tanggal' => now()->toDateString(),
                'total' => $total,
                'bayar' => $bayar,
                'kembalian' => $bayar - $total,
            ]);

            foreach ($menus as $menuId => $data) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'menu_id' => $menuId,
                    'jumlah' => $data['jumlah'],
                    'subtotal' => $data['subtotal'],
                ]);

                $data['menu']->decrement('stok', $data['jumlah']);
            }

            return $transaction;
        });
    }
}
