<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parking extends Model
{
    use SoftDeletes;

    // protected $dates = ['date'];
    protected $fillable = ['date', 'time_end', 'time_start', 'user_id', 'car_id', 'slot_id', 'parking_lot_id', 'status'];

    public function parkingLot()
    {
        return $this->belongsTo('App\ParkingLot');
    }
    public function slot()
    {
        return $this->belongsTo('App\Slot');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function car()
    {
        return $this->belongsTo('App\Car');
    }
}
