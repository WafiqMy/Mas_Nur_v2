<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->string('nama_event');
            $table->string('gambar_event')->nullable();
            $table->text('deskripsi_event')->nullable();
            $table->string('lokasi_event')->nullable();
            $table->dateTime('tanggal_event')->nullable();
            $table->text('dokumentasi')->nullable(); // comma-separated filenames
            $table->json('video_urls')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};
