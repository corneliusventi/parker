<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parking extends Model
{
    use SoftDeletes;

    protected $dates = ['date'];
    protected $fillable = ['date', 'time_end', 'time_start', 'user_id', 'status'];
}
