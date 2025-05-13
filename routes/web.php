<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    Route::get('/servicer/dashboard', function () {
        return view('servicer.dashboard');
    })->name('servicer.dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Car routes
    Route::prefix('user')->name('user.')->group(function () {
        Route::resource('cars', CarController::class);
        Route::delete('cars/images/{image}', [CarController::class, 'destroyImage'])->name('cars.images.destroy');
    });

    // Chat routes
    Route::get('/chat/start/{carId}', [ChatController::class, 'startChat'])->name('chat.start');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{carId}/{userId}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{carId}/{userId}', [ChatController::class, 'store'])->name('chat.store');
});

// Admin routes
Route::group(['middleware' => ['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users/{user}', [DashboardController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [DashboardController::class, 'destroy'])->name('users.destroy');
    
    // Admin car routes
    Route::get('/cars/{car}', [DashboardController::class, 'showCar'])->name('cars.show');
    Route::delete('/cars/{car}', [DashboardController::class, 'destroyCar'])->name('cars.destroy');
});

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = Auth::user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isServicer()) {
        return redirect()->route('servicer.dashboard');
    } else {
        return redirect()->route('user.dashboard');
    }
})->name('dashboard');

require __DIR__.'/auth.php';
