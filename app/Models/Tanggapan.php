<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanggapan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_pengaduan',
        'id_petugas',
        'tgl_tanggapan',
        'isi_tanggapan',
        'foto_tanggapan',
        'status_tanggapan',
    ];

    public function pengaduan()
    {
        return $this->hasOne(Pengaduan::class, 'id', 'id_pengaduan');
    }

    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'id', 'id_petugas');
    }
}
