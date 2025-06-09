<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Car;
use App\Models\Servicer;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Carbon\Carbon;

class AppointmentSystemTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $servicer;
    protected $car;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test user
        $this->user = User::factory()->create([
            'role_id' => 2 // Regular user role
        ]);
        
        // Create servicer user and profile
        $servicerUser = User::factory()->create([
            'role_id' => 3 // Servicer role
        ]);
        
        $this->servicer = Servicer::create([
            'user_id' => $servicerUser->id,
            'company_name' => 'Test Auto Service',
            'phone_number' => '1234567890',
            'address' => '123 Test St',
            'is_verified' => true
        ]);

        // Create a test car
        $this->car = Car::factory()->create([
            'user_id' => $this->user->id
        ]);
    }

    #[Test]
    public function user_can_view_available_slots()
    {
        $date = Carbon::tomorrow()->format('Y-m-d');

        $response = $this->actingAs($this->user)
            ->get(route('appointments.slots', $this->servicer->user_id) . '?date=' . $date);

        $response->assertStatus(200);
        $slots = $response->json();
        $this->assertIsArray($slots);
        $this->assertNotEmpty($slots);
        $this->assertContains('08:00', $slots);
        $this->assertContains('16:00', $slots);
    }

    #[Test]
    public function user_can_create_appointment()
    {
        $date = Carbon::tomorrow()->format('Y-m-d');
        $time = '10:00';

        $response = $this->actingAs($this->user)
            ->post(route('appointments.store'), [
                'user_id' => $this->servicer->user_id,
                'car_id' => $this->car->id,
                'appointment_date' => $date,
                'start_time' => $time,
                'notes' => 'Test appointment'
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('appointments', [
            'user_id' => $this->user->id,
            'servicer_id' => $this->servicer->id,
            'car_id' => $this->car->id,
            'status' => 'pending'
        ]);
    }

    #[Test]
    public function appointment_creation_validates_required_fields()
    {
        $response = $this->actingAs($this->user)
            ->post(route('appointments.store'), []);

        $response->assertSessionHasErrors([
            'user_id', 'car_id', 'appointment_date', 'start_time'
        ]);
    }

    #[Test]
    public function servicer_can_update_appointment_status()
    {
        $appointment = Appointment::create([
            'user_id' => $this->user->id,
            'servicer_id' => $this->servicer->id,
            'car_id' => $this->car->id,
            'appointment_date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '13:00',
            'end_time' => '14:00',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->servicer->user)
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
    public function user_can_cancel_appointment()
    {
        $appointment = Appointment::create([
            'user_id' => $this->user->id,
            'servicer_id' => $this->servicer->id,
            'car_id' => $this->car->id,
            'appointment_date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '14:00',
            'end_time' => '15:00',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('appointments.cancel', $appointment));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'cancelled'
        ]);
    }

    #[Test]
    public function cannot_book_appointment_in_past()
    {
        $date = Carbon::yesterday()->format('Y-m-d');
        $time = '15:00';

        $response = $this->actingAs($this->user)
            ->post(route('appointments.store'), [
                'user_id' => $this->servicer->user_id,
                'car_id' => $this->car->id,
                'appointment_date' => $date,
                'start_time' => $time,
                'notes' => 'Test appointment'
            ]);

        $response->assertSessionHasErrors(['appointment_date']);
    }

    #[Test]
    public function servicer_cannot_update_appointment_with_invalid_status()
    {
        $appointment = Appointment::create([
            'user_id' => $this->user->id,
            'servicer_id' => $this->servicer->id,
            'car_id' => $this->car->id,
            'appointment_date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '16:00',
            'end_time' => '17:00',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->servicer->user)
            ->put(route('servicer.appointments.status', $appointment->id), [
                'status' => 'invalid_status'
            ]);

        $response->assertSessionHasErrors(['status']);
    }
} 