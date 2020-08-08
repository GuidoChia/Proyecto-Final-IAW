<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraBuy extends Model {
    protected $fillable = [
        'description',
        'price',
        'buy_id'
    ];

    public function buy() {
        return $this->belongsTo('App\Buy');
    }
}
