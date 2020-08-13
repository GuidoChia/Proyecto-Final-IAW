<?php

namespace App;

use App\Events\BuyCreated;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => BuyCreated::class,
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function twelveBuy()
    {
        return $this->hasOne('App\TwelveBuy');
    }

    public function twentyBuy()
    {
        return $this->hasOne('App\TwentyBuy');
    }

    public function extraBuy()
    {
        return $this->hasOne('App\ExtraBuy');
    }
}
