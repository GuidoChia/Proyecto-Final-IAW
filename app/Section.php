<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'lat_bottom_left',
        'lon_bottom_left',
        'lat_bottom_right',
        'lon_bottom_right',
        'lat_top_left',
        'lon_top_left',
        'lat_top_right',
        'lon_top_right'
    ];

    /**
     * Calculates all the addresses inside the section
     * @return \Illuminate\Support\Collection
     */
    public function getAddresses()
    {
        $res = collect([]);
        $addresses = Address::all();
        foreach ($addresses as $address) {
            if ($address->isInSection($this)) {
                $res->add($address);
            }
        }
        return $res;
    }
}
