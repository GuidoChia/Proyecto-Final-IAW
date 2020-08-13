<?php

namespace App;

use App\Events\TwelveBuyCreated;
use Illuminate\Database\Eloquent\Model;

class TwelveBuy extends Model
{
    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TwelveBuyCreated::class,
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
