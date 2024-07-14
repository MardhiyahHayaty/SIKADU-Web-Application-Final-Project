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
        Schema::create('pemadamen', function (Blueprint $table) {
            $table->id();
            $table->string('judul_pemadaman');
            $table->date('tgl_mulai_pemadaman');
            $table->time('jam_mulai_pemadaman');
            $table->time('jam_selesai_pemadaman');
            $table->string('lokasi_pemadaman');
            $table->string('status_pemadaman');
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
        Schema::dropIfExists('pemadamen');
    }
};
