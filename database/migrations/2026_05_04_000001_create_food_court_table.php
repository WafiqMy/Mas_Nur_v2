<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_court', function (Blueprint $table) {
            $table->increments('id_food');
            $table->string('nama_menu', 50);
            $table->string('deskripsi', 50)->nullable();
            $table->string('gambar', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_court');
    }
};
