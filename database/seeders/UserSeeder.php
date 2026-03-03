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
        // ensure default admin exists (password will be hashed automatically because of cast)
        User::firstOrCreate(
            ['nik' => 'admin'],
            [
                'nama' => 'Administrator',
                'password' => 'password', // will be hashed by model
                'role_id' => 1,
                'status' => true,
            ]
        );

        // also fix any existing plain-text passwords stored earlier
        // this is safe to run repeatedly
        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                if (\Illuminate\Support\Facades\Hash::needsRehash($user->password)) {
                    $user->password = \Illuminate\Support\Facades\Hash::make($user->password);
                    $user->save();
                }
            }
        });
    }
}
