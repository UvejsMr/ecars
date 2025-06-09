<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class WelcomeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $cars;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a user
        $this->user = User::factory()->create();

        // Create test cars with different attributes
        $this->cars = [
            Car::factory()->create([
                'user_id' => $this->user->id,
                'make' => 'Toyota',
                'model' => 'Camry',
                'year' => 2020,
                'price' => 25000,
                'fuel' => 'Petrol',
                'location' => 'New York',
                'gearbox' => 'Automatic',
                'mileage' => 50000
            ]),
            Car::factory()->create([
                'user_id' => $this->user->id,
                'make' => 'Honda',
                'model' => 'Civic',
                'year' => 2019,
                'price' => 20000,
                'fuel' => 'Diesel',
                'location' => 'Los Angeles',
                'gearbox' => 'Manual',
                'mileage' => 75000
            ]),
            Car::factory()->create([
                'user_id' => $this->user->id,
                'make' => 'Ford',
                'model' => 'Mustang',
                'year' => 2021,
                'price' => 35000,
                'fuel' => 'Petrol',
                'location' => 'Chicago',
                'gearbox' => 'Automatic',
                'mileage' => 25000
            ])
        ];
    }

    #[Test]
    public function welcome_page_loads_successfully()
    {
        $response = $this->get(route('welcome'));

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertViewHas(['cars', 'makes', 'fuels', 'locations', 'gearboxes']);
    }

    #[Test]
    public function cars_are_paginated()
    {
        // Create more cars to test pagination
        Car::factory()->count(10)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->get(route('welcome'));

        $response->assertStatus(200);
        $response->assertViewHas('cars');
        $this->assertCount(9, $response->viewData('cars')); // Default pagination is 9
    }

    #[Test]
    public function can_filter_cars_by_make()
    {
        $response = $this->get(route('welcome', ['make' => 'Toyota']));

        $response->assertStatus(200);
        $cars = $response->viewData('cars');
        $this->assertTrue($cars->every(fn($car) => $car->make === 'Toyota'));
    }

    #[Test]
    public function can_filter_cars_by_fuel()
    {
        $response = $this->get(route('welcome', ['fuel' => 'Petrol']));

        $response->assertStatus(200);
        $cars = $response->viewData('cars');
        $this->assertTrue($cars->every(fn($car) => $car->fuel === 'Petrol'));
    }

    #[Test]
    public function can_filter_cars_by_location()
    {
        $response = $this->get(route('welcome', ['location' => 'New York']));

        $response->assertStatus(200);
        $cars = $response->viewData('cars');
        $this->assertTrue($cars->every(fn($car) => $car->location === 'New York'));
    }

    #[Test]
    public function can_filter_cars_by_gearbox()
    {
        $response = $this->get(route('welcome', ['gearbox' => 'Automatic']));

        $response->assertStatus(200);
        $cars = $response->viewData('cars');
        $this->assertTrue($cars->every(fn($car) => $car->gearbox === 'Automatic'));
    }

    #[Test]
    public function can_filter_cars_by_mileage_range()
    {
        $response = $this->get(route('welcome', [
            'mileage_min' => 40000,
            'mileage_max' => 60000
        ]));

        $response->assertStatus(200);
        $cars = $response->viewData('cars');
        $this->assertTrue($cars->every(fn($car) => 
            $car->mileage >= 40000 && $car->mileage <= 60000
        ));
    }

    #[Test]
    public function can_sort_cars_by_price_ascending()
    {
        $response = $this->get(route('welcome', ['sort_price' => 'price_asc']));

        $response->assertStatus(200);
        $cars = $response->viewData('cars');
        $prices = $cars->pluck('price')->toArray();
        $sorted = $prices;
        sort($sorted);
        $this->assertEquals($sorted, $prices);
    }

    #[Test]
    public function can_sort_cars_by_price_descending()
    {
        $response = $this->get(route('welcome', ['sort_price' => 'price_desc']));

        $response->assertStatus(200);
        $cars = $response->viewData('cars');
        $prices = $cars->pluck('price')->toArray();
        $sorted = $prices;
        rsort($sorted);
        $this->assertEquals($sorted, $prices);
    }

    #[Test]
    public function can_sort_cars_by_year_ascending()
    {
        $response = $this->get(route('welcome', ['sort_year' => 'year_asc']));

        $response->assertStatus(200);
        $cars = $response->viewData('cars');
        $years = $cars->pluck('year')->toArray();
        $sorted = $years;
        sort($sorted);
        $this->assertEquals($sorted, $years);
    }

    #[Test]
    public function can_sort_cars_by_year_descending()
    {
        $response = $this->get(route('welcome', ['sort_year' => 'year_desc']));

        $response->assertStatus(200);
        $cars = $response->viewData('cars');
        $years = $cars->pluck('year')->toArray();
        $sorted = $years;
        rsort($sorted);
        $this->assertEquals($sorted, $years);
    }

    #[Test]
    public function can_search_cars_by_make_or_model()
    {
        $response = $this->get(route('welcome', ['search' => 'Camry']));

        $response->assertStatus(200);
        $cars = $response->viewData('cars');
        $this->assertTrue($cars->every(fn($car) => 
            str_contains(strtolower($car->make), 'camry') || 
            str_contains(strtolower($car->model), 'camry')
        ));
    }

    #[Test]
    public function filter_options_are_retrieved_correctly()
    {
        $response = $this->get(route('welcome'));

        $response->assertStatus(200);
        $response->assertViewHas('makes');
        $response->assertViewHas('fuels');
        $response->assertViewHas('locations');
        $response->assertViewHas('gearboxes');

        $makes = $response->viewData('makes');
        $fuels = $response->viewData('fuels');
        $locations = $response->viewData('locations');
        $gearboxes = $response->viewData('gearboxes');

        $this->assertContains('Toyota', $makes);
        $this->assertContains('Honda', $makes);
        $this->assertContains('Ford', $makes);
        $this->assertContains('Petrol', $fuels);
        $this->assertContains('Diesel', $fuels);
        $this->assertContains('New York', $locations);
        $this->assertContains('Los Angeles', $locations);
        $this->assertContains('Chicago', $locations);
        $this->assertContains('Automatic', $gearboxes);
        $this->assertContains('Manual', $gearboxes);
    }
} 