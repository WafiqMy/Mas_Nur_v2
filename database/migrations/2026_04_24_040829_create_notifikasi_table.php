<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('role')->default('user');
            $table->string('judul');
            $table->text('pesan');
            $table->string('link')->nullable();
            $table->string('status_badge')->default('Menunggu');
            $table->boolean('is_new')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
