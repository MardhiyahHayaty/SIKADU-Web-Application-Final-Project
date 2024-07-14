<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\PengaduanBaru;

class Pengaduan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nik',
        'tgl_pengaduan',
        'jenis_pengaduan',
        'id_jenis_aduan',
        'permasalahan',
        'keterangan',
        'lokasi_pengaduan',
        'foto_pengaduan',
        'status_pengaduan',
    ];

    public function masyarakat()
    {
        return $this->hasOne(Masyarakat::class, 'nik', 'nik');
    }

    public function jenis()
    {
        return $this->hasOne(Jenis::class, 'id', 'id_jenis_aduan');
    }

    /*protected $dispatchesEvents = [
        'created' => PengaduanBaru::class,
    ];*/
}
