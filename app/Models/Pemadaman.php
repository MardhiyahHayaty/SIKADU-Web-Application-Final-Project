<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemadaman extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul_pemadaman',
        'tgl_mulai_pemadaman',
        'jam_mulai_pemadaman',
        'jam_selesai_pemadaman',
        'lokasi_pemadaman',
        'status_pemadaman',
        'id_petugas',
    ];

    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'id', 'id_petugas');
    }
}
