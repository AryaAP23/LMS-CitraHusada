<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['nik' => 'admin'],
            [
                'nama' => 'Administrator',
                'password' => 'password', // hashed via cast
                'role_id' => 1,
                'status' => true,
            ]
        );
    }
}
