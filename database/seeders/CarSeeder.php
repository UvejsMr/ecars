<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CarSeeder extends Seeder
{
    private $brands = [
        'Audi' => ['A3', 'A4', 'A6', 'Q5', 'Q7'],
        'BMW' => ['3 Series', '5 Series', 'X3', 'X5', 'M4'],
        'Mercedes' => ['C-Class', 'E-Class', 'GLA', 'GLC', 'S-Class'],
        'Porsche' => ['911', 'Cayenne', 'Panamera', 'Macan', 'Taycan'],
        'Volkswagen' => ['Golf', 'Passat', 'Tiguan', 'Polo', 'Touareg'],
        'Toyota' => ['Corolla', 'Camry', 'RAV4', 'Yaris', 'Land Cruiser'],
        'Ford' => ['Focus', 'Fiesta', 'Mustang', 'Kuga', 'Mondeo'],
        'Honda' => ['Civic', 'Accord', 'CR-V', 'Jazz', 'HR-V'],
        'Hyundai' => ['i30', 'Tucson', 'Santa Fe', 'Elantra', 'Kona'],
        'Kia' => ['Ceed', 'Sportage', 'Sorento', 'Rio', 'Stinger'],
    ];

    private function getDefaultCarImage()
    {
        return 'car-images/default-car.jpg';
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean up existing cars and their images
        $existingCars = Car::with('images')->get();
        foreach ($existingCars as $car) {
            // Delete car images from storage
            foreach ($car->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
            // Delete the car (this will cascade delete the images from database)
            $car->delete();
        }
        
        // Get specific users (2, 3, and 4)
        $users = \App\Models\User::whereIn('id', [2, 3, 4])->get();
        
        // Create 10 cars for each user
        foreach ($users as $user) {
            for ($i = 0; $i < 10; $i++) {
                // Select a random make and model
                $make = array_rand($this->brands);
                $model = $this->brands[$make][array_rand($this->brands[$make])];
                
                // Create the car
                $car = Car::factory()->create([
                    'user_id' => $user->id,
                    'make' => $make,
                    'model' => $model
                ]);

                // Add 4-5 images for each car using default image
                $numImages = rand(4, 5);
                for ($j = 0; $j < $numImages; $j++) {
                    $car->images()->create([
                        'image_path' => $this->getDefaultCarImage(),
                        'order' => $j
                    ]);
                }
            }
        }
    }
}
