<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['nama' => 'Mie Ayam Bangka', 'harga' => 15000, 'stok' => 50],
            ['nama' => 'Mie Ayam Spesial', 'harga' => 20000, 'stok' => 50],
            ['nama' => 'Mie Ayam Ceker', 'harga' => 18000, 'stok' => 40],
            ['nama' => 'Mie Pangsit', 'harga' => 15000, 'stok' => 45],
            ['nama' => 'Mie Ayam Jamur', 'harga' => 18000, 'stok' => 35],
            ['nama' => 'Es Teh Manis', 'harga' => 5000, 'stok' => 100],
            ['nama' => 'Es Teh Tawar', 'harga' => 4000, 'stok' => 100],
            ['nama' => 'Es Jeruk', 'harga' => 6000, 'stok' => 80],
            ['nama' => 'Teh Hangat', 'harga' => 4000, 'stok' => 100],
            ['nama' => 'Kerupuk', 'harga' => 3000, 'stok' => 200],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
