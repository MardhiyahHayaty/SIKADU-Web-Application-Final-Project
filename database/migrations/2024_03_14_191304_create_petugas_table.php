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
        Schema::create('petugas', function (Blueprint $table) {
            $table->id();
            $table->string('nip_petugas');
            $table->string('nama_petugas');
            $table->string('email_petugas');
            $table->string('telp_petugas', 13);
            $table->unsignedBigInteger('id_opd');
            $table->string('kata_sandi_petugas');
            $table->string('foto_petugas');
            $table->enum('level', ['admin', 'satgas']);
            $table->timestamps();
            $table->foreign('id_opd')->references('id')->on('opds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};
