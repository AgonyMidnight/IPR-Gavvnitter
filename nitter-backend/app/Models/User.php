<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Ramsey\Uuid\Type\Integer;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const GENDERS_DEFAULT = 0;
    const GENDERS_MALE = 1;
    const GENDERS_FEMALE = 2;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'avatar',
        'gender',
        'login',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getGender ($gender) :int
    {
        return match ($gender) {
            'Male' => self::GENDERS_MALE,
            'Female' => self::GENDERS_FEMALE,
            default => self::GENDERS_DEFAULT,
        };
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }
}
