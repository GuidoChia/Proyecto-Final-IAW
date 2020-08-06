<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwentyBuy extends Model
{
    protected $fillable = [
        'bought',
        'returned',
        'price'
    ];
}
