<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('infaq_pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->string('keperluan');           // Digunakan untuk apa
            $table->decimal('jumlah', 15, 2);      // Jumlah yang dikeluarkan
            $table->text('keterangan')->nullable(); // Keterangan tambahan
            $table->date('tanggal');               // Tanggal pengeluaran
            $table->timestamps();
            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('infaq_pengeluaran');
    }
};
