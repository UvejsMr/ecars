<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@ecars.com',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
        ]);
    }
}
