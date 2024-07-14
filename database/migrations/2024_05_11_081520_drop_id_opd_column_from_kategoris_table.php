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
        // 5. Hapus Kolom 'id_opd' dari Tabel 'kategoris'
        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropForeign(['id_opd']); // Menghapus foreign key
            $table->dropColumn('id_opd'); // Menghapus kolom
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            $table->unsignedBigInteger('id_opd');
            $table->foreign('id_opd')->references('id')->on('opd');
        });
    }
};
