<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
                'Super Admin',
                'Admin',
                'Teacher',
                'Karyawan',
        ];

        foreach ($data as $role) {
            Role::updateOrInsert(
                ['role' => $role],
                ['role' => $role]
            );
        }
    }
}
