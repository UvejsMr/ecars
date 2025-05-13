<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->user_id || 
               $user->id === $appointment->servicer->user_id ||
               $user->isAdmin();
    }

    public function update(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->user_id || 
               $user->id === $appointment->servicer->user_id ||
               $user->isAdmin();
    }
} 