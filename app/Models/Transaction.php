<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nomor_transaksi',
        'tanggal',
        'total',
        'bayar',
        'kembalian',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'total' => 'decimal:2',
            'bayar' => 'decimal:2',
            'kembalian' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public static function generateNomorTransaksi(): string
    {
        $today = now()->format('Ymd');
        $count = self::whereDate('created_at', now())->count() + 1;

        return 'MB-' . $today . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
