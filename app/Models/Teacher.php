<?php

namespace App\Models;

use App\Interfaces\UserInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Authenticatable implements UserInterface
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'bio'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isTeacher(): bool
    {
        return true;
    }

    public function isStudent(): bool
    {
        return false;
    }
}
