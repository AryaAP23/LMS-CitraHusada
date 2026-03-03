<?php

namespace Database\Seeders;

use App\Models\Role;
// use App\Models\JenisTenaga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed basic roles
        Role::firstOrCreate(['role_id' => 1], ['role' => 'Super admin']);
        Role::firstOrCreate(['role_id' => 2], ['role' => 'User']);

        // Call seeder untuk jenis tenaga
        $this->call(JenisTenagaSeeder::class);

        // Call seeder untuk unit kerja
        $this->call(UnitKerjaSeeder::class);

        // optional texts shown on login page
        $this->call(LoginTextSeeder::class);

        // create default admin user
        $this->call(UserSeeder::class);
    }
}
