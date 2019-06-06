<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = ['hour', 'date', 'time', 'user_id', 'parking_lot_id', 'status'];

    public function parkingLot()
    {
        return $this->belongsTo('App\ParkingLot');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
