<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'tanggal' => fake()->dateTimeBetween('-30 days', 'now'),
            'total_transaksi' => fake()->numberBetween(10, 100),
            'total_pendapatan' => fake()->randomFloat(2, 100000, 2000000),
            'generated_by' => User::factory()->owner(),
        ];
    }
}
