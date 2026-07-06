<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransactionItem>
 */
class TransactionItemFactory extends Factory
{
    protected $model = TransactionItem::class;

    public function definition(): array
    {
        $menu = Menu::inRandomOrder()->first() ?? Menu::factory()->create();
        $jumlah = fake()->numberBetween(1, 5);
        $subtotal = $menu->harga * $jumlah;

        return [
            'transaction_id' => Transaction::factory(),
            'menu_id' => $menu->id,
            'jumlah' => $jumlah,
            'subtotal' => $subtotal,
        ];
    }
}
