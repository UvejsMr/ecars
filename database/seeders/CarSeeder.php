<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Car::factory(10)->create(['user_id' => 3]);
        \App\Models\Car::factory(10)->create(['user_id' => 8]);
        \App\Models\Car::factory(10)->create(['user_id' => 9]);
    }
}
