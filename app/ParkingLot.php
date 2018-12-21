<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParkingLot extends Model
{
    use SoftDeletes;

    public function parkings()
    {
        return $this->hasMany('App\Parking');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }
}
