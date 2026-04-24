<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('jenis')->nullable();
            $table->string('nama_pengguna');
            $table->string('no_tlp_pengguna');
            $table->string('email_pengguna');
            $table->string('username_pengguna')->nullable();
            $table->date('tanggal_mulai_reservasi');
            $table->date('tanggal_selesai_reservasi');
            $table->text('keperluan')->nullable();
            $table->integer('total_peminjaman')->default(1);
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->enum('status_reservasi', ['Menunggu', 'Disetujui', 'Ditolak', 'Batal'])->default('Menunggu');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
