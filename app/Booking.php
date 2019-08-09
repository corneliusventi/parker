<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = ['hour', 'date', 'time', 'user_id', 'car_id', 'slot_id', 'parking_lot_id', 'status', 'expired_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'expired_at'];

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
