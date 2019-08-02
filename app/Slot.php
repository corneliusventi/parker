<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slot extends Model
{
	use SoftDeletes;

    protected $fillable = ['code', 'level', 'qrcode'];

    public function parkingLot()
    {
        return $this->belongsTo('App\ParkingLot');
    }

    public function parkings()
    {
        return $this->hasMany('App\Parking');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public static function code(ParkingLot $parkingLot, $level = null)
    {
        $parkingLotId = $parkingLot->id;

        if ($parkingLot->type == 'building') {
            if(!$level) {
                $level = 1;
            }
        } else {
            $level = 0;
        }

        $slotId = $parkingLot->slots->where('level', $level)->count() + 1;

        return "PARKER-$parkingLotId-$level-$slotId";
    }

    public static function laratablesCustomPrint($slot)
    {
        return view('pages.slots.print', compact('slot'))->render();
    }
}
