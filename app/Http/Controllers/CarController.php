<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class CarController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        // Only require auth and authorization for non-show methods
        $this->middleware('auth')->except(['show']);
        $this->authorizeResource(Car::class, 'car', ['except' => ['show']]);
    }

    public function index()
    {
        $cars = Auth::user()->cars()->with('images')->get();
        return view('user.cars.index', compact('cars'));
    }

    public function create()
    {
        return view('user.cars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'power' => 'required|integer|min:1',
            'mileage' => 'required|integer|min:0',
            'gearbox' => 'required|in:Manual,Automatic,Semi-automatic',
            'fuel' => 'required|in:Petrol,Diesel,Electric,Hybrid',
            'engine_size' => 'required|numeric|min:0.1',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'equipment' => 'array',
            'equipment.*' => 'string|max:255',
            'description' => 'required|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'images' => 'required|array|min:1|max:10',
        ]);

        $car = Auth::user()->cars()->create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('car-images', 'public');
                $car->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('user.cars.index')
            ->with('success', 'Car added successfully.');
    }

    public function edit(Car $car)
    {
        return view('user.cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        try {
            // Debug the incoming request
            \Log::info('Update request data:', [
                'all' => $request->all(),
                'method' => $request->method(),
                'hasFile' => $request->hasFile('images'),
                'car_id' => $car->id
            ]);

            $validated = $request->validate([
                'make' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
                'power' => 'required|integer|min:1',
                'mileage' => 'required|integer|min:0',
                'gearbox' => 'required|in:Manual,Automatic,Semi-automatic',
                'fuel' => 'required|in:Petrol,Diesel,Electric,Hybrid',
                'engine_size' => 'required|numeric|min:0.1',
                'price' => 'required|numeric|min:0',
                'location' => 'required|string|max:255',
                'equipment' => 'nullable|array',
                'equipment.*' => 'string|max:255',
                'description' => 'required|string',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            ]);

            // Debug the validated data
            \Log::info('Validated data:', $validated);

            // Handle equipment array
            $validated['equipment'] = $request->input('equipment', []);

            // Update the car
            $car->fill($validated);
            $car->save();

            // Debug the updated car
            \Log::info('Updated car:', $car->toArray());

            // Handle new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('car-images', 'public');
                    $car->images()->create(['image_path' => $path]);
                }
            }

            return redirect()->route('user.cars.index')
                ->with('success', 'Car updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Car update error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update car: ' . $e->getMessage()]);
        }
    }

    public function destroy(Car $car)
    {
        // Delete all associated images from storage
        foreach ($car->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $car->delete();

        return redirect()->route('user.cars.index')
            ->with('success', 'Car deleted successfully.');
    }

    public function destroyImage(CarImage $image)
    {
        $this->authorize('delete', $image->car);
        
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }

    public function show(Car $car)
    {
        $car->load(['user', 'images']);
        return view('cars.show', compact('car'));
    }
} 