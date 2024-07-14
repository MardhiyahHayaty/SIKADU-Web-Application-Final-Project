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
        Schema::create('razias', function (Blueprint $table) {
            $table->id();
            $table->string('judul_razia');
            $table->date('tgl_mulai_razia');
            $table->date('tgl_selesai_razia');
            $table->time('jam_mulai_razia');
            $table->time('jam_selesai_razia');
            $table->string('lokasi_awal_razia');
            $table->string('lokasi_akhir_razia');
            $table->string('status_razia');
            $table->unsignedBigInteger('id_petugas');
            $table->timestamps();
            $table->foreign('id_petugas')->references('id')->on('petugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('razias');
    }
};
