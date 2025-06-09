<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Servicer;
use App\Models\Appointment;
use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ServicerControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $servicerUser;
    protected $servicer;
    protected $regularUser;
    protected $car;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a servicer user and profile
        $this->servicerUser = User::factory()->create([
            'role_id' => 3 // Servicer role
        ]);
        
        $this->servicer = Servicer::create([
            'user_id' => $this->servicerUser->id,
            'company_name' => 'Test Auto Service',
            'phone_number' => '1234567890',
            'address' => '123 Test St',
            'is_verified' => true
        ]);

        // Create a regular user and car for testing appointments
        $this->regularUser = User::factory()->create([
            'role_id' => 2 // Regular user role
        ]);

        $this->car = Car::factory()->create([
            'user_id' => $this->regularUser->id
        ]);
    }

    #[Test]
    public function servicer_can_view_dashboard()
    {
        $response = $this->actingAs($this->servicerUser)
            ->get(route('servicer.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('servicer.dashboard');
        $response->assertViewHas('appointments');
    }

    #[Test]
    public function servicer_with_incomplete_profile_is_redirected_to_edit()
    {
        // Create a servicer with incomplete profile
        $incompleteServicer = Servicer::create([
            'user_id' => User::factory()->create(['role_id' => 3])->id,
            'company_name' => 'Incomplete Service',
            'phone_number' => 'To be updated',
            'address' => 'To be updated',
            'is_verified' => false
        ]);

        $response = $this->actingAs($incompleteServicer->user)
            ->get(route('servicer.dashboard'));

        $response->assertRedirect(route('servicer.edit'));
        $response->assertSessionHas('warning');
    }

    #[Test]
    public function servicer_can_view_edit_profile_page()
    {
        $response = $this->actingAs($this->servicerUser)
            ->get(route('servicer.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('servicer.edit');
        $response->assertViewHas('servicer');
    }

    #[Test]
    public function servicer_can_update_profile()
    {
        $newData = [
            'company_name' => 'Updated Auto Service',
            'phone_number' => '9876543210',
            'address' => '456 New St'
        ];

        $response = $this->actingAs($this->servicerUser)
            ->put(route('servicer.update'), $newData);

        $response->assertRedirect(route('servicer.dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('servicers', [
            'id' => $this->servicer->id,
            'company_name' => $newData['company_name'],
            'phone_number' => $newData['phone_number'],
            'address' => $newData['address']
        ]);
    }

    #[Test]
    public function profile_update_validates_required_fields()
    {
        $response = $this->actingAs($this->servicerUser)
            ->put(route('servicer.update'), []);

        $response->assertSessionHasErrors([
            'company_name',
            'phone_number',
            'address'
        ]);
    }

    #[Test]
    public function servicer_can_update_appointment_status()
    {
        $appointment = Appointment::create([
            'user_id' => $this->regularUser->id,
            'servicer_id' => $this->servicer->id,
            'car_id' => $this->car->id,
            'appointment_date' => now()->addDay()->format('Y-m-d'),
            'start_time' => '09:00',
            'end_time' => '10:00',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->servicerUser)
            ->put(route('servicer.appointments.status', $appointment->id), [
                'status' => 'confirmed'
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'confirmed'
        ]);
    }

    #[Test]
    public function appointment_status_update_validates_status()
    {
        $appointment = Appointment::create([
            'user_id' => $this->regularUser->id,
            'servicer_id' => $this->servicer->id,
            'car_id' => $this->car->id,
            'appointment_date' => now()->addDay()->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '11:00',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->servicerUser)
            ->put(route('servicer.appointments.status', $appointment->id), [
                'status' => 'invalid_status'
            ]);

        $response->assertSessionHasErrors(['status']);
    }
} 