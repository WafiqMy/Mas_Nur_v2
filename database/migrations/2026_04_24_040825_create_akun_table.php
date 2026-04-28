<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akun', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_telpon')->nullable();
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->enum('status', ['pending', 'aktif'])->default('pending');
            $table->string('gambar')->nullable();
            $table->string('otp', 10)->nullable();
            $table->timestamp('otp_expired')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
};
