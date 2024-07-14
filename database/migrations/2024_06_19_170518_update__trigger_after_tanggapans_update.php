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
                DECLARE status_pengaduan_old VARCHAR(255);

                -- Capture the old status_pengaduan before it changes
                SELECT status_pengaduan INTO status_pengaduan_old FROM pengaduans WHERE id = OLD.id_pengaduan;

                IF OLD.isi_tanggapan <> NEW.isi_tanggapan OR OLD.foto_tanggapan <> NEW.foto_tanggapan OR OLD.status_tanggapan <> NEW.status_tanggapan THEN
                    -- Masukkan data lama ke log_tanggapan
                    INSERT INTO log_tanggapan (id_tanggapan, id_pengaduan, id_petugas, tgl_tanggapan, isi_tanggapan, foto_tanggapan, status_pengaduan, created_at, updated_at)
                    VALUES (OLD.id, OLD.id_pengaduan, OLD.id_petugas, OLD.tgl_tanggapan, OLD.isi_tanggapan, OLD.foto_tanggapan, OLD.status_tanggapan, OLD.created_at, OLD.updated_at);

                    -- Update the status_pengaduan in pengaduans table
                    UPDATE pengaduans SET status_pengaduan = NEW.status_tanggapan WHERE id = NEW.id_pengaduan;
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_tanggapans_update');
    }
};
