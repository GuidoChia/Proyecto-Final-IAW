<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buy extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'date',
        'paid',
        'twelve_buy_id',
        'twenty_buy_id',
        'extra_buy_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'foreign_key');
    }

    public function twelveBuy() {
        return $this->hasOne('App\TwelveBuy');
    }

    public function twentyBuy() {
        return $this->hasOne('App\TwentyBuy');
    }

    public function extraBuy() {
        return $this->hasOne('App\ExtraBuy');
    }
}
