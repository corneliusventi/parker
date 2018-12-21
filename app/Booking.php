<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = ['hour', 'date', 'type', 'time', 'user_id', 'parking_lot_id'];

    public function parkingLot()
    {
        return $this->belongsTo('App\ParkingLot');
    }
}
