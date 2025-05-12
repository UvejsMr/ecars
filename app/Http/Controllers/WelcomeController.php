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
        $carsQuery = Car::with(['user', 'images']);

        // Filter by make if selected
        if ($make && $make !== 'all') {
            $carsQuery->where('make', $make);
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

        return view('welcome', compact('cars', 'sort_price', 'sort_year', 'make', 'makes'));
    }
} 