<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        $total = fake()->randomFloat(2, 10000, 100000);
        $bayar = ceil($total / 10000) * 10000;

        return [
            'user_id' => User::factory()->kasir(),
            'nomor_transaksi' => 'MB-' . now()->format('Ymd') . '-' . str_pad(fake()->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'tanggal' => now()->toDateString(),
            'total' => $total,
            'bayar' => $bayar,
            'kembalian' => $bayar - $total,
        ];
    }
}
