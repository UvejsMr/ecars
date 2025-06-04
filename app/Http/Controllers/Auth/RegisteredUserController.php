<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Servicer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        Log::info('Registration request:', [
            'role_id' => $request->role_id,
            'roles' => Role::all()->toArray()
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        $user->refresh();

        Log::info('User created:', [
            'user_id' => $user->id,
            'role_id' => $user->role_id,
            'is_servicer' => $user->isServicer()
        ]);

        // If user is registering as a servicer, create servicer record
        if ($user->isServicer()) {
            $servicer = Servicer::create([
                'user_id' => $user->id,
                'company_name' => $request->name . "'s Service",
                'phone_number' => 'To be updated',
                'address' => 'To be updated',
                'is_verified' => false
            ]);

            Log::info('Servicer record created:', [
                'servicer_id' => $servicer->id,
                'user_id' => $servicer->user_id
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        // Redirect based on role
        if ($user->isAdmin()) {
            Log::info('Redirecting to admin dashboard');
            return redirect()->route('admin.dashboard');
        } elseif ($user->isServicer()) {
            Log::info('Redirecting to servicer dashboard');
            return redirect()->route('servicer.dashboard');
        } else {
            Log::info('Redirecting to user dashboard');
            return redirect()->route('user.dashboard');
        }
    }
}
