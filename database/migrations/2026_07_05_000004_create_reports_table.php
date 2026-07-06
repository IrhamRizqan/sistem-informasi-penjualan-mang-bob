<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->integer('total_transaksi');
            $table->decimal('total_pendapatan', 12, 2);
            $table->foreignId('generated_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique('tanggal');
            $table->index('generated_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
