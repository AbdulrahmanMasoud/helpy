<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    // The attributes that are mass assignable.
    protected $fillable = [
        'f_name',
        'l_name',
        'email',
        'phone',
        'avatar',
        'password',
        'gender',
        'country',
        'city',
        'address',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
    ];

    public function markers()
    {
        return $this->hasMany(Marker::class);
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    
/**
 * القيمه قبل ما تتحفظ ف الداتابيز هيتم عليها العمليه دي
 */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


/**************************************This For Jwt Auth*************************************/

    // Get the identifier that will be stored in the subject claim of the JWT.
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Return a key value array, containing any custom claims to be added to the JWT.
    public function getJWTCustomClaims()
    {
        return [];
    }
}
