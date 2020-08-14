<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * @var array default values for attributes
     */
    protected $attributes = [
        'twelve_balance' => 0,
        'twenty_balance' => 0,
        'balance' => 0,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address_id',
    ];

    public function buys()
    {
        return $this->hasMany('App\Buy');
    }

    public function address()
    {
        return $this->hasOne('App\Address');
    }

    /**
     * Returns true if it's predicted that the customer will buy something in the given date.
     * @param $predictedDate
     */
    public function predictBuy($predictedDate)
    {
        $lastBuys = $this->buys()->orderBy('date', 'desc')->take(20)->get();
        return $lastBuys->reverse();
    }
}
