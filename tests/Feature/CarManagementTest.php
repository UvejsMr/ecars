<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CarManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $validCarData;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test user
        $this->user = User::factory()->create([
            'role_id' => 2 // Regular user role
        ]);

        // Prepare valid car data
        $this->validCarData = [
            'make' => 'Toyota',
            'model' => 'Camry',
            'year' => 2020,
            'power' => 200,
            'mileage' => 50000,
            'gearbox' => 'Automatic',
            'fuel' => 'Petrol',
            'engine_size' => 2.5,
            'equipment' => ['GPS', 'Leather Seats'],
            'description' => 'Excellent condition',
            'location' => 'Skopje',
            'price' => 25000,
            'images' => [
                UploadedFile::fake()->create('car1.jpg', 100),
                UploadedFile::fake()->create('car2.jpg', 100)
            ]
        ];
    }

    #[Test]
    public function user_can_create_a_car()
    {
        Storage::fake('public');

        $response = $this->actingAs($this->user)
            ->post(route('user.cars.store'), $this->validCarData);

        $response->assertRedirect(route('user.cars.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('cars', [
            'make' => 'Toyota',
            'model' => 'Camry',
            'user_id' => $this->user->id
        ]);

        // Assert images were stored
        $car = Car::where('make', 'Toyota')->first();
        $this->assertCount(2, $car->images);
        Storage::disk('public')->assertExists($car->images[0]->image_path);
    }

    #[Test]
    public function car_creation_validates_required_fields()
    {
        $response = $this->actingAs($this->user)
            ->post(route('user.cars.store'), []);

        $response->assertSessionHasErrors([
            'make', 'model', 'year', 'power', 'mileage', 
            'gearbox', 'fuel', 'engine_size', 'description', 
            'location', 'price', 'images'
        ]);
    }

    #[Test]
    public function user_can_update_their_car()
    {
        Storage::fake('public');

        // Create a car first
        $car = Car::factory()->create([
            'user_id' => $this->user->id
        ]);

        // Add some images
        $car->images()->create([
            'image_path' => 'car-images/test1.jpg'
        ]);

        $updateData = [
            'make' => 'Honda',
            'model' => 'Civic',
            'year' => 2021,
            'power' => 180,
            'mileage' => 30000,
            'gearbox' => 'Manual',
            'fuel' => 'Petrol',
            'engine_size' => 1.8,
            'equipment' => ['Bluetooth', 'Sunroof'],
            'description' => 'Updated description',
            'location' => 'Bitola',
            'price' => 20000,
            'images' => [
                UploadedFile::fake()->create('newcar.jpg', 100)
            ]
        ];

        $response = $this->actingAs($this->user)
            ->put(route('user.cars.update', $car), $updateData);

        $response->assertRedirect(route('user.cars.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('cars', [
            'id' => $car->id,
            'make' => 'Honda',
            'model' => 'Civic'
        ]);

        // Assert new image was stored
        $updatedCar = Car::find($car->id);
        $this->assertCount(2, $updatedCar->images);
    }

    #[Test]
    public function user_cannot_update_another_users_car()
    {
        $otherUser = User::factory()->create();
        $car = Car::factory()->create([
            'user_id' => $otherUser->id
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('user.cars.update', $car), $this->validCarData);

        $response->assertStatus(403);
    }

    #[Test]
    public function user_can_delete_their_car()
    {
        Storage::fake('public');

        // Create a car with images
        $car = Car::factory()->create([
            'user_id' => $this->user->id
        ]);

        $image = $car->images()->create([
            'image_path' => 'car-images/test.jpg'
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('user.cars.destroy', $car));

        $response->assertRedirect(route('user.cars.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('cars', ['id' => $car->id]);
        $this->assertDatabaseMissing('car_images', ['id' => $image->id]);
        Storage::disk('public')->assertMissing($image->image_path);
    }

    #[Test]
    public function user_cannot_delete_another_users_car()
    {
        $otherUser = User::factory()->create();
        $car = Car::factory()->create([
            'user_id' => $otherUser->id
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('user.cars.destroy', $car));

        $response->assertStatus(403);
    }

    #[Test]
    public function user_can_delete_car_image()
    {
        Storage::fake('public');

        // Create a car with images
        $car = Car::factory()->create([
            'user_id' => $this->user->id
        ]);

        $image = $car->images()->create([
            'image_path' => 'car-images/test.jpg'
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('user.cars.images.destroy', $image));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('car_images', ['id' => $image->id]);
        Storage::disk('public')->assertMissing($image->image_path);
    }

    #[Test]
    public function car_creation_validates_image_requirements()
    {
        $invalidData = $this->validCarData;
        $invalidData['images'] = [
            UploadedFile::fake()->create('car.jpg', 3000), // Too large
            UploadedFile::fake()->create('document.pdf', 100) // Wrong file type
        ];

        $response = $this->actingAs($this->user)
            ->post(route('user.cars.store'), $invalidData);

        $response->assertSessionHasErrors(['images.0', 'images.1']);
    }
} 