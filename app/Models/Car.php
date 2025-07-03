<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'make',
        'model',
        'year',
        'power',
        'mileage',
        'gearbox',
        'fuel',
        'engine_size',
        'equipment',
        'description',
        'location',
        'user_id',
        'price',
        'status'
    ];

    protected $casts = [
        'equipment' => 'array',
        'year' => 'integer',
        'power' => 'integer',
        'mileage' => 'integer',
        'engine_size' => 'float',
        'price' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(CarImage::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->year} {$this->make} {$this->model}";
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function isFavoritedBy(User $user)
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
} 