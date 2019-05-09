<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slot extends Model
{
	use SoftDeletes;
	
    protected $fillable = ['code', 'level', 'qrcode', 'active'];

    /**
     * Returns truncated name for the datatables.
     *
     * @return string
     */
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
