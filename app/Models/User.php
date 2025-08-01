<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'utype', // Your existing user type column
        'password',
        'reg_number', // NEW: Add reg_number to fillable
        'fee_balance', // NEW: Add fee_balance to fillable
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
            'fee_balance' => 'decimal:2', // NEW: Cast fee_balance to decimal
        ];
    }

    //Add the relationship for reservations
    /**
     * Get the reservations for the user.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // This method defines a one-to-many relationship between User and Reservation
    // It allows you to access all reservations made by a user
    public function reservations(): HasMany{
        return $this->hasMany(Reservation::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

}

