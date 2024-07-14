<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tanggapans', function (Blueprint $table) {
            $table->enum('status_tanggapan', ['0', 'proses', 'selesai'])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tanggapans', function (Blueprint $table) {
            $table->dropColumn('status_tanggapan');
        });
    }
};
