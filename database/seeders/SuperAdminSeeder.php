<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'adminroot@example.com'], // prevent duplicate runs
            [
                'name' => 'Super Admin',
                'password' => Hash::make(env('SUPER_ADMIN_PASSWORD', 'adminroot')), // use bcrypt/Hash
                'email_verified_at' => now(),
                // 'role' => 'superadmin', // optional: if you have roles
            ]
        );
    }
}
