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
        Schema::table('masyarakats', function (Blueprint $table) {
            $table->date('tgl_lahir_masyarakat')->nullable();
            $table->enum('jenis_kelamin_masyarakat', ['laki-laki', 'perempuan'])->nullable();
            $table->string('alamat_masyarakat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('masyarakats', function (Blueprint $table) {
            $table->dropColumn(['tgl_lahir', 'gender', 'alamat']);
        });
    }
};
