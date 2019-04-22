<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $fillable = ['code', 'level', 'qrcode', 'order'];

}
