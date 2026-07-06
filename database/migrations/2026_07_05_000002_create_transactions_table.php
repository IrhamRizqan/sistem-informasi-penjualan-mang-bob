<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nomor_transaksi', 20)->unique();
            $table->date('tanggal');
            $table->decimal('total', 12, 2);
            $table->decimal('bayar', 12, 2);
            $table->decimal('kembalian', 12, 2);
            $table->timestamps();

            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
