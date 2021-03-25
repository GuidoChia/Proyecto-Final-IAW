<?php

namespace App;

use App\Events\BuyCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    /**
     * Returns the associated TwelveBuy
     * @return HasOne
     */
    public function twelveBuy()
    {
        return $this->hasOne('App\TwelveBuy');
    }

    /**
     * Returns the associated TwentyBuy
     * @return HasOne
     */
    public function twentyBuy()
    {
        return $this->hasOne('App\TwentyBuy');
    }

    /**
     * Returns the associated ExtraBuy
     * @return HasOne
     */
    public function extraBuy()
    {
        return $this->hasOne('App\ExtraBuy');
    }
}
