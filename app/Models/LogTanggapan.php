<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTanggapan extends Model
{
    use HasFactory;
    protected $table = 'log_tanggapan';
    protected $fillable = [
        'id_tanggapan',
        'id_pengaduan',
        'id_petugas',
        'tgl_tanggapan',
        'isi_tanggapan',
        'foto_tanggapan',
        'status_tanggapan',
    ];

    public function tanggapan()
    {
        return $this->belongsTo(Tanggapan::class);
    }

    public function pengaduan()
    {
        return $this->hasOne(Pengaduan::class, 'id', 'id_pengaduan');
    }

    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'id', 'id_petugas');
    }
}
