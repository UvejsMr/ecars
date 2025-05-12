<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = [
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
        $make = $this->faker->randomElement(array_keys($brands));
        $model = $this->faker->randomElement($brands[$make]);

        return [
            'make' => $make,
            'model' => $model,
            'year' => $this->faker->year,
            'power' => $this->faker->numberBetween(70, 400),
            'mileage' => $this->faker->numberBetween(0, 200000),
            'gearbox' => $this->faker->randomElement(['Manual', 'Automatic']),
            'fuel' => $this->faker->randomElement(['Petrol', 'Diesel', 'Electric', 'Hybrid']),
            'engine_size' => $this->faker->randomFloat(1, 1.0, 5.0),
            'equipment' => [],
            'description' => $this->faker->paragraph,
            'location' => $this->faker->city,
            'user_id' => 3,
            'price' => $this->faker->randomFloat(2, 1000, 50000),
            'status' => 'available'
        ];
    }
}
