<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriJenisTenaga extends Model
{
    use HasFactory;

    protected $primaryKey = 'materi_jenis_tenaga_id';

    protected $fillable = [
        'jenis_tenaga_id',
        'materi_id',
    ];

    public function jenisTenaga()
    {
        return $this->belongsTo(JenisTenaga::class, 'jenis_tenaga_id', 'jenis_tenaga_id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id', 'materi_id');
    }
}
