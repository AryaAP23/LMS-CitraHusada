<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMateri extends Model
{
    use HasFactory;

    protected $primaryKey = 'sub_materi_id';

    protected $fillable = [
        'materi_id',
        'judul',
        'file_materi',
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id', 'materi_id');
    }

    public function postTests()
    {
        return $this->hasMany(PostTest::class, 'sub_materi_id', 'sub_materi_id');
    }
}
