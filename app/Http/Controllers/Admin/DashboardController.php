<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        $cars = Car::with(['user', 'images'])->latest()->get();
        return view('admin.dashboard', compact('users', 'cars'));
    }

    public function approveUser(User $user)
    {
        $user->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'User approved successfully.');
    }

    public function rejectUser(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User rejected and removed.');
    }

    public function show(User $user)
    {
        $user->load(['cars' => function ($query) {
            $query->with('images');
        }]);
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        // Delete all associated cars and their images
        foreach ($user->cars as $car) {
            foreach ($car->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
            $car->delete();
        }
        
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    }

    public function showCar(Car $car)
    {
        $car->load(['user', 'images']);
        return view('admin.cars.show', compact('car'));
    }

    public function destroyCar(Car $car)
    {
        // Delete all associated images
        foreach ($car->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $car->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Car deleted successfully.');
    }
}
