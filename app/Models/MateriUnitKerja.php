<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriUnitKerja extends Model
{
    use HasFactory;

    protected $primaryKey = 'materi_unit_kerja_id';

    protected $fillable = [
        'unit_kerja_id',
        'materi_id',
    ];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'unit_kerja_id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id', 'materi_id');
    }
}
