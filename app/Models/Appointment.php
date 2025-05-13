<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'servicer_id',
        'car_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'notes'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function servicer()
    {
        return $this->belongsTo(Servicer::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
} 