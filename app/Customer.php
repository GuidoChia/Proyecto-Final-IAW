<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * Mutates the name, upper casing the first letters.
     * @param $value
     * @return string
     */
    public function getNameAttribute($value)
    {
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

    public function section()
    {
        return $this->hasOneThrough('App\Section', 'App\Address', 'id', 'id', 'address_id', 'section_id');
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

    static public function findBySection($sectionName): Collection
    {
        if ($sectionName == "All") {
            return Customer::all();
        } else {
            return Customer::whereHas('section', function (Builder $query) use ($sectionName) {
                $query->where('name', '=', $sectionName);
            })->get();
        }
    }

    static public function getCustomerNamesAsArray()
    {
        return array_values(
            Customer::all()->map(function ($item, $key) {
            return $item->name;
        })->sort()->toArray());
    }
}
