<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
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

    private $usedImageUrls = [];

    private function getCarImage($make, $model, $index)
    {
        try {
            // Add some variety to the search query
            $searchTerms = [
                "{$make} {$model} car",
                "{$make} {$model} exterior",
                "{$make} {$model} front view",
                "{$make} {$model} side view",
                "{$make} {$model} rear view"
            ];
            
            // Use different search terms for different images
            $query = $searchTerms[$index % count($searchTerms)];
            
            // Search for car images on Unsplash with a random page
            $page = rand(1, 5); // Unsplash allows up to 5 pages of results
            $response = Http::get('https://api.unsplash.com/search/photos', [
                'query' => $query,
                'per_page' => 1,
                'page' => $page,
                'orientation' => 'landscape',
                'client_id' => env('UNSPLASH_ACCESS_KEY')
            ]);

            // Log the API response
            \Log::info('Unsplash API Response:', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->json()
            ]);

            if ($response->status() === 403) {
                \Log::error('Unsplash API rate limit exceeded');
                return 'car-images/default-car.jpg';
            }

            if ($response->successful() && !empty($response->json()['results'])) {
                $imageUrl = $response->json()['results'][0]['urls']['regular'];
                
                // Check if we've already used this image URL
                if (in_array($imageUrl, $this->usedImageUrls)) {
                    // If we've used this URL, try again with a different page
                    return $this->getCarImage($make, $model, $index + 1);
                }
                
                // Add the URL to our used URLs list
                $this->usedImageUrls[] = $imageUrl;
                
                // Download the image
                $imageContent = file_get_contents($imageUrl);
                if ($imageContent) {
                    // Generate a unique filename
                    $filename = 'car-images/' . uniqid() . '.jpg';
                    
                    // Store the image
                    $stored = Storage::disk('public')->put($filename, $imageContent);
                    
                    if ($stored) {
                        \Log::info('Image stored successfully:', ['path' => $filename]);
                        return $filename;
                    } else {
                        \Log::error('Failed to store image:', ['path' => $filename]);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching car image: ' . $e->getMessage(), [
                'make' => $make,
                'model' => $model,
                'index' => $index
            ]);
        }

        // Fallback to a default car image if the API call fails
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

                // Add 4-5 images for each car
                $numImages = rand(4, 5);
                for ($j = 0; $j < $numImages; $j++) {
                    $imagePath = $this->getCarImage($make, $model, $j);
                    $car->images()->create([
                        'image_path' => $imagePath,
                        'order' => $j
                    ]);
                }
            }
        }
    }
}
