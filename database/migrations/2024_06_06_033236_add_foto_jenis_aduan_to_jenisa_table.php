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
        Schema::table('jenisa', function (Blueprint $table) {
            $table->string('foto_jenis_aduan')->nullable()->after('nama_jenis_aduan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenisa', function (Blueprint $table) {
            $table->dropColumn('foto_jenis_aduan');
        });
    }
};
