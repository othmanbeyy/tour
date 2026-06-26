<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'sharifbeyy@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => 'admin1234',
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
