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
        DB::unprepared('DROP TRIGGER IF EXISTS after_tanggapans_update');

        DB::unprepared('
            CREATE TRIGGER after_tanggapans_update
            AFTER UPDATE ON tanggapans
            FOR EACH ROW
            BEGIN
                DECLARE status_pengaduan_new VARCHAR(255);
                DECLARE status_pengaduan_old VARCHAR(255);
                DECLARE status_pengaduan_old_before_change VARCHAR(255);

                SELECT status_pengaduan INTO status_pengaduan_new FROM pengaduans WHERE id = NEW.id_pengaduan;
                SELECT status_pengaduan INTO status_pengaduan_old FROM pengaduans WHERE id = OLD.id_pengaduan;

                -- Save the status_pengaduan before change
                SET status_pengaduan_old_before_change = status_pengaduan_old;

                IF OLD.isi_tanggapan <> NEW.isi_tanggapan OR OLD.foto_tanggapan <> NEW.foto_tanggapan OR status_pengaduan_old <> status_pengaduan_new THEN
                    -- Use the saved previous status_pengaduan
                    INSERT INTO log_tanggapan (id_tanggapan, id_pengaduan, id_petugas, tgl_tanggapan, isi_tanggapan, foto_tanggapan, status_pengaduan, created_at, updated_at)
                    VALUES (OLD.id, OLD.id_pengaduan, OLD.id_petugas, OLD.tgl_tanggapan, OLD.isi_tanggapan, OLD.foto_tanggapan, status_pengaduan_old_before_change, OLD.created_at, OLD.updated_at);

                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tanggapans', function (Blueprint $table) {
            //
        });
    }
};
