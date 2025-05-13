<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Car;
use App\Models\Servicer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isServicer()) {
            $appointments = Appointment::where('servicer_id', $user->servicer->id)
                                    ->with(['user', 'car'])
                                    ->latest()
                                    ->get();
        } else {
            $appointments = $user->appointments()
                               ->with(['servicer', 'car'])
                               ->latest()
                               ->get();
        }
        
        return view('appointments.index', compact('appointments'));
    }

    public function selectServicer($carId)
    {
        $car = Car::findOrFail($carId);
        $servicers = Servicer::where('is_verified', true)->get();
        
        return view('appointments.select-servicer', compact('car', 'servicers'));
    }

    public function create($userId, $carId)
    {
        try {
            // Get the servicer by user_id
            $servicer = Servicer::where('user_id', $userId)
                              ->where('is_verified', true)
                              ->first();
            
            if (!$servicer) {
                abort(404, "Servicer not found or not verified.");
            }
            
            // Check if car exists
            $car = Car::where('id', $carId)->first();
            if (!$car) {
                abort(404, "Car not found.");
            }
            
            return view('appointments.create', compact('servicer', 'car'));
        } catch (\Exception $e) {
            abort(404, 'Error: ' . $e->getMessage());
        }
    }

    public function getAvailableSlots($userId)
    {
        try {
            $date = request('date');
            \Log::info('Getting available slots', ['date' => $date, 'userId' => $userId]);

            if (!$date) {
                \Log::info('No date provided for time slots');
                return response()->json([]);
            }

            // Get the servicer by user_id
            $servicer = Servicer::where('user_id', $userId)->first();
            
            if (!$servicer) {
                \Log::info('Servicer not found', ['user_id' => $userId]);
                return response()->json([]);
            }

            \Log::info('Found servicer', [
                'servicer_id' => $servicer->id,
                'is_verified' => $servicer->is_verified,
                'user_id' => $servicer->user_id
            ]);

            // Generate all possible time slots (8 AM to 4 PM)
            $allSlots = [];
            $startTime = strtotime('08:00');
            $endTime = strtotime('16:00');
            $interval = 60 * 60; // 1 hour in seconds

            for ($time = $startTime; $time <= $endTime; $time += $interval) {
                $allSlots[] = date('H:i', $time);
            }

            \Log::info('Generated all slots', ['slots' => $allSlots]);

            // Get booked appointments for this date
            $bookedSlots = Appointment::where('servicer_id', $servicer->id)
                ->whereDate('appointment_date', $date)
                ->where('status', '!=', 'cancelled')
                ->pluck('start_time')
                ->toArray();

            \Log::info('Found booked slots', ['booked_slots' => $bookedSlots]);

            // Filter out booked slots
            $availableSlots = array_diff($allSlots, $bookedSlots);
            $availableSlots = array_values($availableSlots);

            \Log::info('Returning available slots', ['available_slots' => $availableSlots]);

            // Force return some slots for testing
            if (empty($availableSlots)) {
                $availableSlots = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'];
            }

            return response()->json($availableSlots);
        } catch (\Exception $e) {
            \Log::error('Error in getAvailableSlots', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to get available slots: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|in:08:00,09:00,10:00,11:00,12:00,13:00,14:00,15:00,16:00',
            'notes' => 'nullable|string'
        ]);

        // Get the servicer by user_id
        $servicer = Servicer::where('user_id', $validated['user_id'])->firstOrFail();

        // Check if slot is available
        $isSlotAvailable = !Appointment::where('servicer_id', $servicer->id)
            ->where('appointment_date', $validated['appointment_date'])
            ->where('start_time', $validated['start_time'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if (!$isSlotAvailable) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_time' => 'This time slot is already booked. Please select another time.',
                    'appointment_date' => 'Selected date and time combination is not available.'
                ]);
        }

        // Calculate end time (1 hour after start time)
        $startTime = \Carbon\Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addHour();

        $appointment = Appointment::create([
            'user_id' => Auth::id(),
            'servicer_id' => $servicer->id,
            'car_id' => $validated['car_id'],
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $endTime->format('H:i'),
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending'
        ]);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment booked successfully!');
    }

    public function show(Appointment $appointment)
    {
        if (!auth()->user()->can('view', $appointment)) {
            abort(403);
        }
        return view('appointments.show', compact('appointment'));
    }

    public function cancel(Appointment $appointment)
    {
        if (!auth()->user()->can('update', $appointment)) {
            abort(403);
        }
        
        $appointment->update(['status' => 'cancelled']);
        
        return redirect()->back()->with('success', 'Appointment cancelled successfully!');
    }
} 