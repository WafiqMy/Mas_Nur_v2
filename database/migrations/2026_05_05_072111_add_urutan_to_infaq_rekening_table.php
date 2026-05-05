<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('infaq_rekening', function (Blueprint $table) {
        // Menambahkan kolom 'urutan' dengan tipe integer, default 0
        $table->integer('urutan')->default(0)->after('id');
    });
}

public function down(): void
{
    Schema::table('infaq_rekening', function (Blueprint $table) {
        // Menghapus kolom jika migration di-rollback
        $table->dropColumn('urutan');
    });
}
};
