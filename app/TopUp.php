<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopUp extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bank_account_number',
        'bank_account_name',
        'bank_name',
        'amount',
        'approved',
        'receipt_transfer',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function laratablesCustomAction($topUp)
    {
        return view('pages.top-ups.action', compact('topUp'))->render();
    }

    public static function laratablesAdditionalColumns()
    {
        return ['approved'];
    }

    public function laratablesAmount()
    {
        return 'Rp '.number_format($this->amount);
    }
}
