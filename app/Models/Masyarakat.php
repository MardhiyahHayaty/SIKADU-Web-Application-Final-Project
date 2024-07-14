<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Masyarakat extends Authenticatable
{
    use HasApiTokens;
    
    protected $table = 'masyarakats';
    protected $primaryKey = 'nik'; // Menentukan 'nik' sebagai primary key
    
    use HasFactory;
    protected $fillable = [
        'nik',
        'nama_masyarakat',
        'email_masyarakat',
        'telp_masyarakat',
        'kata_sandi_masyarakat',
        'foto_masyarakat',
        'tgl_lahir_masyarakat',
        'jenis_kelamin_masyarakat',
        'alamat_masyarakat',
    ];

    protected $hidden = [
        'kata_sandi_masyarakat',
    ];
}
