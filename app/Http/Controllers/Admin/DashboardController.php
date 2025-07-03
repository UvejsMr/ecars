<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Car;
use App\Models\Role;
use App\Models\Servicer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $usersQuery = User::with('role');
        if ($search !== '') {
            $usersQuery->where(function($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ;
            });
        }
        $users = $usersQuery->get();
        $cars = Car::with('user')->paginate(6)->withQueryString();
        $totalCars = Car::count();
        $unverifiedServicers = Servicer::where('is_verified', false)->with('user')->get();
        $totalUsers = User::count();
        
        // Debug
        foreach ($users as $user) {
            \Log::info('User role:', [
                'user_id' => $user->id,
                'role_id' => $user->role_id,
                'role' => $user->role
            ]);
        }
        
        return view('admin.dashboard', compact('users', 'cars', 'unverifiedServicers', 'search', 'totalCars', 'totalUsers'));
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
        $user->load(['role', 'cars.images']);
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

    public function verifyServicer(Servicer $servicer)
    {
        $servicer->update(['is_verified' => true]);
        return redirect()->back()->with('success', 'Servicer verified successfully!');
    }
}
