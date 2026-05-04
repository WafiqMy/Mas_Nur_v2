<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('food_court', function (Blueprint $table) {
            $table->string('nama_menu', 255)->change();
            $table->string('deskripsi', 255)->nullable()->change();
            $table->string('gambar', 255)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('food_court', function (Blueprint $table) {
            $table->string('nama_menu', 50)->change();
            $table->string('deskripsi', 50)->nullable()->change();
            $table->string('gambar', 50)->nullable()->change();
        });
    }
};
