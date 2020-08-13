<?php

namespace App;

use App\Events\ExtraBuyCreated;
use Illuminate\Database\Eloquent\Model;

class ExtraBuy extends Model
{
    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ExtraBuyCreated::class,
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
