<?php

namespace App\Services;

use App\Models\Report;
use App\Models\Transaction;

class ReportService
{
    public function generate(string $tanggal, int $userId): Report
    {
        $transactions = Transaction::whereDate('tanggal', $tanggal)->get();

        $totalTransaksi = $transactions->count();
        $totalPendapatan = $transactions->sum('total');

        $report = Report::updateOrCreate(
            ['tanggal' => $tanggal],
            [
                'total_transaksi' => $totalTransaksi,
                'total_pendapatan' => $totalPendapatan,
                'generated_by' => $userId,
            ]
        );

        return $report;
    }
}
