<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    public function isUser()
    {
        return $this->role_id === 2;
    }

    public function isServicer()
    {
        \Illuminate\Support\Facades\Log::info('Checking if user is servicer:', [
            'user_id' => $this->id,
            'role_id' => $this->role_id
        ]);
        return $this->role_id === 3;
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function servicer()
    {
        return $this->hasOne(Servicer::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
