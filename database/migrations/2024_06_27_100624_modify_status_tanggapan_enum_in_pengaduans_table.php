<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `tanggapans` MODIFY `status_tanggapan` ENUM('0', 'proses', 'selesai', 'tolak') NOT NULL DEFAULT '0'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert enum column
        DB::statement("ALTER TABLE `tanggapans` MODIFY `status_tanggapan` ENUM('0', 'proses', 'selesai') NOT NULL DEFAULT '0'");
    }
};
