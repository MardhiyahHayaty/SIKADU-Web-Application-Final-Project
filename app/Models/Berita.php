<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul_berita',
        'isi_berita',
        'foto_berita',
        'tgl_terbit_berita',
        'id_petugas',
    ];

    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'id', 'id_petugas');
    }
}
