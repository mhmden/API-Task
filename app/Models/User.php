<?php

namespace App\Models;

use App\Builders\UserBuilder;
use App\Mixins\JsonResponse;
use App\Traits\HasBuilder;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse as HttpJsonResponse;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasBuilder;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'banned_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $dates = [
        'banned_at'
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function todos(){

        return $this->belongsToMany(Todo::class)->withTimestamps();

    }

    // public function newEloquentBuilder($query) : Builder // How can we Achieve this in a trait.
    // {
    //     return new UserBuilder($query);
    // }

    protected function password(): Attribute
    { // A model mutator that we want to hash the password prior to saving
        return Attribute::make(
            set: fn ($value) => Hash::make($value),
        );
    }
}
