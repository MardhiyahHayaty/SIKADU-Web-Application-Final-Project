<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Petugas extends Authenticatable
{
    use HasFactory;

    protected $table = 'petugasa';
    protected $guard = 'admin';

    protected $fillable = [
        'nip_petugas',
        'nama_petugas',
        'email_petugas',
        'telp_petugas',
        'id_opd',
        'kata_sandi_petugas',
        'foto_petugas',
        'level',
    ];

    protected $hidden = [
        'kata_sandi_petugas', 'remember_token',
    ];

    public function opd()
    {
        return $this->hasOne(Opd::class, 'id', 'id_opd');
    }

    // Menggunakan kolom kata_sandi_petugas untuk autentikasi
    public function getAuthPassword()
    {
        return $this->kata_sandi_petugas;
    }
}
