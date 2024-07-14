<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Razia extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul_razia',
        'tgl_mulai_razia',
        'tgl_selesai_razia',
        'jam_mulai_razia',
        'jam_selesai_razia',
        'lokasi_awal_razia',
        'lokasi_akhir_razia',
        'status_razia',
        'id_petugas',
    ];

    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'id', 'id_petugas');
    }
}
