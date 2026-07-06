<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::where('role', 'owner')->first();

        for ($day = 1; $day <= 7; $day++) {
            $date = now()->subDays($day);
            $transactions = Transaction::whereDate('tanggal', $date)->get();

            if ($transactions->isNotEmpty()) {
                Report::create([
                    'tanggal' => $date->toDateString(),
                    'total_transaksi' => $transactions->count(),
                    'total_pendapatan' => $transactions->sum('total'),
                    'generated_by' => $owner->id,
                ]);
            }
        }
    }
}
