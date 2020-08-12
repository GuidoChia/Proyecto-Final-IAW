<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwentyBuy extends Model {
    protected $fillable = [
        'bought',
        'returned',
        'price',
        'buy_id'
    ];


    public function buy() {
        return $this->belongsTo('App\Buy');
    }
}
