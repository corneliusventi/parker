<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['plate', 'brand'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function laratablesCustomAction($car)
    {
        return view('pages.cars.action', compact('car'))->render();
    }
}
