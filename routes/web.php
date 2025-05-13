<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ServicerController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');

Route::middleware(['auth', 'verified'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User routes
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', function () {
            return view('user.dashboard');
        })->name('dashboard');
        Route::resource('cars', CarController::class);
        Route::delete('cars/images/{image}', [CarController::class, 'destroyImage'])->name('cars.images.destroy');
    });

    // Servicer routes
    Route::prefix('servicer')->name('servicer.')->group(function () {
        Route::get('/dashboard', [ServicerController::class, 'dashboard'])->name('dashboard');
        Route::get('/edit', [ServicerController::class, 'edit'])->name('edit');
        Route::put('/update', [ServicerController::class, 'update'])->name('update');
        Route::put('/appointments/{id}/status', [ServicerController::class, 'updateAppointmentStatus'])->name('appointments.status');
    });

    // Chat routes
    Route::get('/chat/start/{carId}', [ChatController::class, 'startChat'])->name('chat.start');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{carId}/{userId}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{carId}/{userId}', [ChatController::class, 'store'])->name('chat.store');

    // Appointment routes
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/select-servicer/{carId}', [AppointmentController::class, 'selectServicer'])->name('appointments.select-servicer');
    Route::get('/appointments/create/{userId}/{carId}', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::get('/appointments/slots/{userId}', [AppointmentController::class, 'getAvailableSlots'])->name('appointments.slots');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // Favorites routes
    Route::middleware(['auth'])->group(function () {
        Route::post('/favorites/{car}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
        Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    });
});

// Admin routes
Route::group(['middleware' => ['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users/{user}', [DashboardController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [DashboardController::class, 'destroy'])->name('users.destroy');
    
    // Admin car routes
    Route::get('/cars/{car}', [DashboardController::class, 'showCar'])->name('cars.show');
    Route::delete('/cars/{car}', [DashboardController::class, 'destroyCar'])->name('cars.destroy');

    // Admin servicer routes
    Route::put('/servicers/{servicer}/verify', [DashboardController::class, 'verifyServicer'])->name('servicers.verify');
});

// Main dashboard redirect
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
