<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_masjid', function (Blueprint $table) {
            $table->id();
            $table->string('nama_masjid')->default('Masjid Nurul Huda');
            $table->text('deskripsi')->nullable();
            $table->text('sejarah_masjid')->nullable();
            $table->string('gambar_sampul')->nullable();
            $table->string('gambar_sejarah_masjid')->nullable();
            $table->string('gambar_struktur_remas')->nullable();
            $table->text('deskripsi_remas')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_masjid');
    }
};
