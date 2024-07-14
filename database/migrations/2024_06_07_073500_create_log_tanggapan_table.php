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
        Schema::create('log_tanggapan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tanggapan')->constrained('tanggapans')->onDelete('cascade');
            $table->foreignId('id_pengaduan')->constrained('pengaduans')->onDelete('cascade');
            $table->foreignId('id_petugas')->constrained('petugasa')->onDelete('cascade'); // Assuming 'users' table for petugas
            $table->timestamp('tgl_tanggapan');
            $table->text('isi_tanggapan');
            $table->string('foto_tanggapan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_tanggapan');
    }
};
