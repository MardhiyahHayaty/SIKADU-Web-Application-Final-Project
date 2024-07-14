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
        Schema::create('aspirasis', function (Blueprint $table) {
            $table->id();
            $table->char('nik');
            $table->dateTime('tgl_aspirasi');
            $table->unsignedBigInteger('id_jenis_aduan');
            $table->string('judul_aspirasi');
            $table->text('isi_aspirasi');
            $table->timestamps();
            $table->foreign('nik')->references('nik')->on('masyarakats');
            $table->foreign('id_jenis_aduan')->references('id')->on('jenisa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspirasis');
    }
};
