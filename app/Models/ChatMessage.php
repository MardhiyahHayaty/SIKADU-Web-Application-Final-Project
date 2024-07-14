<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatMessage extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari konvensi penamaan Laravel
    protected $table = 'ch_messages';

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = ['from_id', 'to_id', 'body', 'attachment', 'seen'];

    // Tentukan bahwa primary key adalah UUID
    protected $keyType = 'string';
    public $incrementing = false;

    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    // Relasi dengan model User (untuk pengguna yang mengirim pesan)
    public function fromUser()
    {
        return $this->belongsTo(Petugas::class, 'id', 'from_id');
    }

    // Relasi dengan model User (untuk pengguna yang menerima pesan)
    public function toUser()
    {
        return $this->belongsTo(Masyarakat::class, 'id', 'to_id');
    }
}
