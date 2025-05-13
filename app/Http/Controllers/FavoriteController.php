<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Car $car)
    {
        $user = auth()->user();
        
        if ($car->isFavoritedBy($user)) {
            $car->favorites()->where('user_id', $user->id)->delete();
            return back()->with('success', 'Car removed from watchlist');
        }
        
        $car->favorites()->create(['user_id' => $user->id]);
        return back()->with('success', 'Car added to watchlist');
    }

    public function index()
    {
        $favorites = auth()->user()->favorites()->with('car')->get();
        return view('user.watchlist', compact('favorites'));
    }
} 