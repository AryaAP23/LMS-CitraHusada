<?php

namespace Database\Seeders;

use App\Models\JenisTenaga;
use Illuminate\Database\Seeder;

class JenisTenagaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Dokter Umum',
            'Dokter Gigi',
            'Dokter Spesialis',
            'Dokter Gigi Spesialis',
            'Perawat',
            'Bidan',
            'Apoteker',
            'Tenaga Teknis Kefarmasian',
            'Analis Kesehatan',
            'Perekam Medis',
            'Radiografer',
            'Ahli Gizi',
            'Sanitarian',
            'ATEM',
            'Refraksionis Optisien',
            'Fisioterapis',
            'Psikolog',
            'Non Kesehatan',
        ];

        foreach ($data as $jenis) {
            JenisTenaga::updateOrInsert(
                ['jenis_tenaga' => $jenis],
                ['jenis_tenaga' => $jenis]
            );
        }
    }
}
