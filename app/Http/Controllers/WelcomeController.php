<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $sort_price = $request->query('sort_price', 'default');
        $sort_year = $request->query('sort_year', 'default');
        $make = $request->query('make', 'all');
        $fuel = $request->query('fuel', 'all');
        $location = $request->query('location', 'all');
        $gearbox = $request->query('gearbox', 'all');
        $mileage_min = $request->query('mileage_min');
        $mileage_max = $request->query('mileage_max');
        $carsQuery = Car::with(['user', 'images']);

        // Filter by make if selected
        if ($make && $make !== 'all') {
            $carsQuery->where('make', $make);
        }

        // Filter by fuel if selected
        if ($fuel && $fuel !== 'all') {
            $carsQuery->where('fuel', $fuel);
        }

        // Filter by location if selected
        if ($location && $location !== 'all') {
            $carsQuery->where('location', $location);
        }

        // Filter by gearbox if selected
        if ($gearbox && $gearbox !== 'all') {
            $carsQuery->where('gearbox', $gearbox);
        }

        // Filter by mileage range if set
        if ($mileage_min !== null && $mileage_min !== '') {
            $carsQuery->where('mileage', '>=', (int)$mileage_min);
        }
        if ($mileage_max !== null && $mileage_max !== '') {
            $carsQuery->where('mileage', '<=', (int)$mileage_max);
        }

        // Apply year sort first if set, then price sort
        if ($sort_year === 'year_asc') {
            $carsQuery->orderBy('year', 'asc');
        } elseif ($sort_year === 'year_desc') {
            $carsQuery->orderBy('year', 'desc');
        }

        if ($sort_price === 'price_asc') {
            $carsQuery->orderBy('price', 'asc');
        } elseif ($sort_price === 'price_desc') {
            $carsQuery->orderBy('price', 'desc');
        }

        if ($sort_price === 'default' && $sort_year === 'default') {
            $carsQuery->latest();
        }

        $cars = $carsQuery->paginate(9)->withQueryString();
        $makes = Car::select('make')->distinct()->orderBy('make')->pluck('make');
        $fuels = Car::select('fuel')->distinct()->orderBy('fuel')->pluck('fuel');
        $locations = Car::select('location')->distinct()->orderBy('location')->pluck('location');
        $gearboxes = Car::select('gearbox')->distinct()->orderBy('gearbox')->pluck('gearbox');

        return view('welcome', compact('cars', 'sort_price', 'sort_year', 'make', 'makes', 'fuel', 'fuels', 'location', 'locations', 'gearbox', 'gearboxes', 'mileage_min', 'mileage_max'));
    }
} 