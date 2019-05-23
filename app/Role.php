<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Silber\Bouncer\Database\Concerns\IsRole;

class Role extends Model
{
    use IsRole;

    public function getOptionValueAttribute()
    {
        return $this->name;
    }

    public function getOptionTextAttribute()
    {
        return $this->title;
    }
}