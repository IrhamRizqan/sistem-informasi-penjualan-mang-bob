<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Menu>
 */
class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition(): array
    {
        $menus = [
            ['nama' => 'Mie Ayam Bangka', 'harga' => 15000],
            ['nama' => 'Mie Ayam Spesial', 'harga' => 20000],
            ['nama' => 'Mie Ayam Ceker', 'harga' => 18000],
            ['nama' => 'Mie Pangsit', 'harga' => 15000],
            ['nama' => 'Mie Ayam Jamur', 'harga' => 18000],
            ['nama' => 'Es Teh Manis', 'harga' => 5000],
            ['nama' => 'Es Teh Tawar', 'harga' => 4000],
            ['nama' => 'Es Jeruk', 'harga' => 6000],
            ['nama' => 'Teh Hangat', 'harga' => 4000],
            ['nama' => 'Kerupuk', 'harga' => 3000],
        ];

        $menu = fake()->randomElement($menus);

        return [
            'nama' => $menu['nama'],
            'harga' => $menu['harga'],
            'stok' => fake()->numberBetween(10, 100),
        ];
    }
}
