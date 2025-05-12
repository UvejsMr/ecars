<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create or update admin user
        User::updateOrCreate(
            ['email' => 'admin@ecars.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role_id' => 1
            ]
        );
    }
} 