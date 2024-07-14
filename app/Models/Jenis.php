<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory;
    protected $table = 'jenisa';
    protected $fillable = [
        'id_kategori',
        'nama_jenis_aduan',
        'id_opd',
        'foto_jenis_aduan',
    ];

    public function kategori()
    {
        return $this->hasOne(Kategori::class, 'id', 'id_kategori');
    }

    public function opd()
    {
        return $this->hasOne(Opd::class, 'id', 'id_opd');
    }
}
