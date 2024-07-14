<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nik',
        'tgl_aspirasi',
        'id_jenis_aduan',
        'judul_aspirasi',
        'isi_aspirasi',
    ];

    public function masyarakat()
    {
        return $this->hasOne(Masyarakat::class, 'nik', 'nik');
    }

    public function jenis()
    {
        return $this->hasOne(Jenis::class, 'id', 'id_jenis_aduan');
    }
}
