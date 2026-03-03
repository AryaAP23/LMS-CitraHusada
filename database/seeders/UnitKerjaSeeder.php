<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'SPI',
            'Direksi',
            'Pemasaran',
            'IGD',
            'Pelayanan Medis',
            'Casemix',
            'Rawat Jalan',
            'K3',
            'Penunjang Medis',
            'Keperawatan',
            'PKRS',
            'PPI',
            'HD',
            'Rawat Inap',
            'ICU',
            'Perinatologi',
            'OK',
            'Mutu',
            'Farmasi',
            'VK',
            'Laboratorium',
            'Rekam Medis',
            'Radiologi',
            'Gizi',
            'Umum RT',
            'Umum Kepegawaian',
            'TPP',
            'Informasi & Pengelolaan Pelanggan',
            'Keuangan',
            'Akuntansi',
            'Perpajakan',
            'Sekretariat',
            'Kasir',
            'Transportasi',
            'Kebersihan',
            'CSSD',
            'Akunpuktur',
            'Kepegawaian Diklat',
            'Informasi & TIK',
            'TI',
            'Laundry',
            'Keamanan',
            'Default',
        ];

        foreach ($data as $unit) {
            UnitKerja::updateOrInsert(
                ['unit_kerja' => $unit],
                ['unit_kerja' => $unit]
            );
        }
    }
}
