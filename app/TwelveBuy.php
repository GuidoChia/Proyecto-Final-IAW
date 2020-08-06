<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwelveBuy extends Model
{
    protected $fillable = [
        'bought',
        'returned',
        'price'
    ];
}
