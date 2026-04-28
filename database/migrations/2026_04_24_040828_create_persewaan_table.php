<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persewaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->enum('Jenis', ['Gedung', 'Alat Musik', 'Alat Multimedia'])->default('Gedung');
            $table->decimal('harga', 15, 2)->default(0);
            $table->integer('jumlah')->default(1);
            $table->text('deskripsi')->nullable();
            $table->text('spesifikasi')->nullable();
            $table->text('fasilitas')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persewaan');
    }
};
