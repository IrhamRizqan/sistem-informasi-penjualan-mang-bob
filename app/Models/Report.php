<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'total_transaksi',
        'total_pendapatan',
        'generated_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'total_transaksi' => 'integer',
            'total_pendapatan' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
