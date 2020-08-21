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

    public function getNameAttribute($value){
        return ucwords($value);
    }

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
     * @return Boolean
     */
    public function predictBuy($predictedDate)
    {
        $consideredBuysAmount = 20;
        $lastBuys = $this->buys()->orderBy('date', 'desc')->take($consideredBuysAmount)->get()->reverse();
        $firstDate = $lastBuys->first()->date; // The first buy within the last $consideredBuysAmount buys
        $lastDate = $lastBuys->last()->date; // The last buy from the customer
        $meanBuyDifference = date_diff($lastDate, $firstDate)->format("%a") / $consideredBuysAmount;
        return date_diff($lastDate, $predictedDate)->format("%r%a") > $meanBuyDifference;
    }

    static public function findByName($name)
    {
        return Customer::where('name', '=', mb_strtolower($name))->get();
    }
}
