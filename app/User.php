<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Avatar;

class User extends Authenticatable
{
    use Notifiable;
    use HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname', 'username', 'email', 'password', 'wallet', 'photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cars()
    {
        return $this->hasMany('App\Car');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }
    public function parkings()
    {
        return $this->hasMany('App\Parking');
    }
    public function getAvatarAttribute()
    {
        return $this->photo ? 'data:image/png;base64,'.$this->photo : Avatar::create($this->fullname)->toBase64();
    }

    public static function laratablesCustomRole($user)
    {
        return $user->roles->first()->title;
    }
}
