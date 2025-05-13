<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'phone_number',
        'address',
        'is_verified'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getAvailableTimeSlots($date)
    {
        $bookedSlots = $this->appointments()
            ->where('appointment_date', $date)
            ->where('status', '!=', 'cancelled')
            ->pluck('start_time')
            ->toArray();

        $allSlots = [
            '08:00', '09:00', '10:00', '11:00',
            '12:00', '13:00', '14:00', '15:00'
        ];

        return array_diff($allSlots, $bookedSlots);
    }
} 