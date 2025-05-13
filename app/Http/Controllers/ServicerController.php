<?php

namespace App\Http\Controllers;

use App\Models\Servicer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicerController extends Controller
{
    public function register()
    {
        return view('servicer.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string'
        ]);

        $servicer = Servicer::create([
            'user_id' => Auth::id(),
            'company_name' => $validated['company_name'],
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address']
        ]);

        return redirect()->route('servicer.dashboard')->with('success', 'Registration successful!');
    }

    public function edit()
    {
        $servicer = Auth::user()->servicer;
        return view('servicer.edit', compact('servicer'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string'
        ]);

        $servicer = Auth::user()->servicer;
        if (!$servicer) {
            $servicer = Servicer::create([
                'user_id' => Auth::id(),
                'company_name' => $validated['company_name'],
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
                'is_verified' => false
            ]);
        } else {
            $servicer->update($validated);
        }

        return redirect()->route('servicer.dashboard')->with('success', 'Profile updated successfully!');
    }

    public function dashboard()
    {
        $servicer = Auth::user()->servicer;
        
        // If servicer profile is not complete, redirect to edit
        if (!$servicer || $servicer->phone_number === 'To be updated') {
            return redirect()->route('servicer.edit')->with('warning', 'Please complete your servicer profile first.');
        }

        $appointments = $servicer->appointments()
            ->with(['user', 'car'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->get();

        return view('servicer.dashboard', compact('appointments'));
    }

    public function updateAppointmentStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled'
        ]);

        $appointment = Auth::user()->servicer->appointments()->findOrFail($id);
        $appointment->update($validated);

        return redirect()->back()->with('success', 'Appointment status updated!');
    }
} 