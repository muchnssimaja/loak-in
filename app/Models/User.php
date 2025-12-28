<?php

namespace App\Models;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

protected $fillable = [
    'name',
    'email',
    'password',
    'avatar_path',
    'location',
    'whatsapp',
    'bio',
    'is_admin',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}
