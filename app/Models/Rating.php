<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_pengaduan',
        'nilai',
        'pesan',
    ];

    public function pengaduan()
    {
        return $this->hasOne(Pengaduan::class, 'id', 'id_pengaduan');
    }
}
