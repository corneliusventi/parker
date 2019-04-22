<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParkingLot extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'address', 'type', 'latitude', 'longitude'];

    public function slots()
    {
        return $this->hasMany('App\Slot');
    }    

    public function parkings()
    {
        return $this->hasMany('App\Parking');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public static function laratablesCustomAction($parkingLot)
    {
        return view('pages.parking-lot.action', compact('parkingLot'))->render();
    }
}
