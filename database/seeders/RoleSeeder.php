<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin role first
        $adminRole = Role::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Administrator',
                'slug' => 'admin'
            ]
        );

        Log::info('Admin role created/updated:', ['role' => $adminRole->toArray()]);

        Role::firstOrCreate(
            ['id' => 2],
            [
                'name' => 'User',
                'slug' => 'user'
            ]
        );

        Role::firstOrCreate(
            ['id' => 3],
            [
                'name' => 'Servicer',
                'slug' => 'servicer'
            ]
        );
    }
} 