<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTest extends Model
{
    use HasFactory;

    protected $primaryKey = 'post_test_id';

    protected $fillable = [
        'sub_materi_id',
        'status_pilihan',
        'soal',
        'pilihan_1',
        'pilihan_2',
        'pilihan_3',
        'pilihan_4',
        'pilihan_5',
        'jawaban_benar',
    ];

    public function subMateri()
    {
        return $this->belongsTo(SubMateri::class, 'sub_materi_id', 'sub_materi_id');
    }
}
