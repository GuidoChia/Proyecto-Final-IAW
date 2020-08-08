<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

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
        'email',
        'password',
        'address_id',
        'buy_frequency_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function buys(){
        return $this->hasMany('App\Buy');
    }

    public function address(){
        return $this->hasOne('App\Address');
    }

    public function buyFrequency(){
        return $this->hasOne('App\BuyFrequency');
    }
}
