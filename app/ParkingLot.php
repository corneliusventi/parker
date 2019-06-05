<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Malhal\Geographical\Geographical;

class ParkingLot extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;
    use Geographical;

    protected $fillable = ['name', 'address', 'type', 'latitude', 'longitude', 'user_id'];
    protected $softCascade = ['slots'];
    protected static $kilometers = true;

    public function slots()
    {
        return $this->hasMany('App\Slot');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function laratablesType()
    {
        return ucwords($this->type);
    }

    public function getOptionValueAttribute()
    {
        return $this->id;
    }

    public function getOptionTextAttribute()
    {
        return $this->name;
    }
}
