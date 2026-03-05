<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $primaryKey = 'materi_id';

    protected $fillable = [
        'judul',
        'image_path',
        'tanggal_upload',
        'tanggal_selesai',
        'jam_pelajaran',
    ];

    public function subMateris()
    {
        return $this->hasMany(SubMateri::class, 'materi_id', 'materi_id');
    }

    public function jenisTenagas()
    {
        return $this->belongsToMany(JenisTenaga::class, 'materi_jenis_tenagas', 'materi_id', 'jenis_tenaga_id');
    }
}
