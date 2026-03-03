<?php

namespace Database\Seeders;

use App\Models\LoginText;
use Illuminate\Database\Seeder;

class LoginTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $texts = [
            'Semangat belajar setiap hari!',
            'Selamat datang di LMS Citra Husada.',
            'Jaga kesehatan sambil menuntut ilmu.',
            'Mulai pelajaranmu sekarang.',
            'Ilmu bertambah, semangat membara.'
        ];

        foreach ($texts as $t) {
            LoginText::create(['text' => $t]);
        }
    }
}
