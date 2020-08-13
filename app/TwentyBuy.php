<?php

namespace App;

use App\Events\TwentyBuyCreated;
use Illuminate\Database\Eloquent\Model;

class TwentyBuy extends Model
{
    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TwentyBuyCreated::class,
    ];

    public function buy()
    {
        return $this->belongsTo('App\Buy');
    }

    public function customer()
    {
        return $this->buy->customer();
    }
}
