<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name',
    ];

    public function addresses(){
        $this->hasMany('App\Address');
    }
}
