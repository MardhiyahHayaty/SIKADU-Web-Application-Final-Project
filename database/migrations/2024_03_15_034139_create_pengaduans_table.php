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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->char('nik');
            $table->dateTime('tgl_pengaduan');
            $table->enum('jenis_pengaduan', ['public', 'private']);
            $table->unsignedBigInteger('id_jenis_aduan');
            $table->string('permasalahan');
            $table->text('keterangan');
            $table->string('lokasi_pengaduan');
            $table->string('foto_pengaduan');
            $table->enum('status_pengaduan', ['0', 'proses', 'selesai']);
            $table->timestamps();
            $table->foreign('nik')->references('nik')->on('masyarakats');
            $table->foreign('id_jenis_aduan')->references('id')->on('jenis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
