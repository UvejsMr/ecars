<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class CarImageSeeder extends Seeder
{
    public function run(): void
    {
        // Get all cars without images
        $cars = Car::whereDoesntHave('images')->get();
        
        // Sample car images URLs (you can replace these with your own image URLs)
        $sampleImages = [
            'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=800&q=80',
        ];

        foreach ($cars as $car) {
            // Add 3-5 random images for each car
            $numImages = rand(3, 5);
            $selectedImages = array_rand($sampleImages, $numImages);
            
            if (!is_array($selectedImages)) {
                $selectedImages = [$selectedImages];
            }

            foreach ($selectedImages as $index => $imageIndex) {
                try {
                    $imageUrl = $sampleImages[$imageIndex];
                    
                    // Use Laravel's HTTP client instead of file_get_contents
                    $response = Http::timeout(30)->get($imageUrl);
                    
                    if ($response->successful()) {
                        $filename = 'car-images/' . Str::random(40) . '.jpg';
                        Storage::disk('public')->put($filename, $response->body());
                        
                        CarImage::create([
                            'car_id' => $car->id,
                            'image_path' => $filename,
                            'order' => $index
                        ]);
                    } else {
                        \Log::warning("Failed to download image from {$imageUrl}: " . $response->status());
                    }
                } catch (\Exception $e) {
                    \Log::error("Error processing image for car {$car->id}: " . $e->getMessage());
                    continue;
                }
            }
        }
    }
} 