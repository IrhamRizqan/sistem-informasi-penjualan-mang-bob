<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $kasir = User::where('role', 'kasir')->first();
        $menus = Menu::all();

        for ($day = 0; $day < 7; $day++) {
            $date = now()->subDays($day);
            $transactionCount = rand(5, 15);

            for ($i = 0; $i < $transactionCount; $i++) {
                $items = $menus->random(rand(1, 4));
                $total = 0;

                $transaction = Transaction::create([
                    'user_id' => $kasir->id,
                    'nomor_transaksi' => 'MB-' . $date->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'tanggal' => $date->toDateString(),
                    'total' => 0,
                    'bayar' => 0,
                    'kembalian' => 0,
                ]);

                foreach ($items as $menu) {
                    $jumlah = rand(1, 3);
                    $subtotal = $menu->harga * $jumlah;
                    $total += $subtotal;

                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'menu_id' => $menu->id,
                        'jumlah' => $jumlah,
                        'subtotal' => $subtotal,
                    ]);
                }

                $bayar = ceil($total / 10000) * 10000;
                $transaction->update([
                    'total' => $total,
                    'bayar' => $bayar,
                    'kembalian' => $bayar - $total,
                ]);
            }
        }
    }
}
