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

    /**
     * Returns the associated customer
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    /**
     * Returns the associated TwelveBuy
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function twelveBuy()
    {
        return $this->hasOne('App\TwelveBuy');
    }

    /**
     * Returns the associated TwentyBuy
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function twentyBuy()
    {
        return $this->hasOne('App\TwentyBuy');
    }

    /**
     * Returns the associated ExtraBuy
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function extraBuy()
    {
        return $this->hasOne('App\ExtraBuy');
    }
}
