<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slot extends Model
{
	use SoftDeletes;
	
    protected $fillable = ['code', 'level', 'qrcode', 'active'];

    public function parkings()
    {
        return $this->hasMany('App\Parking');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function laratablesActive()
    {
        return $this->active ? 'Active' : 'Disable';
    }

    public static function laratablesAdditionalColumns()
    {
        return ['active'];
    }
    public static function laratablesCustomActiveButton($slot)
    {
        return view('pages.slot.active-button', compact('slot'))->render();
    }
    public static function laratablesCustomAction($slot)
    {
        return view('pages.slot.action', compact('slot'))->render();
    }
}
