<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lat', 'lon', 'description'
    ];

    /**
     * Checks whether the address is inside the given section
     * @param Section $section
     * @return bool true if $this is inside $section, false otherwise
     */
    public function isInSection(Section $section)
    {
        $lat = $this->lat;
        $lon = $this->lon;

        $vertices = [
            array('lat' => $section->lat_bottom_left, 'lon' => $section->lon_bottom_left),
            array('lat' => $section->lat_bottom_right, 'lon' => $section->lon_bottom_right),
            array('lat' => $section->lat_top_left, 'lon' => $section->lon_top_left),
            array('lat' => $section->lat_top_right, 'lon' => $section->lon_top_right)
        ];
        $vertices_amount = count($vertices);

        $c = false;
        for ($i = 0, $j = $vertices_amount; $i < $vertices_amount; $j = $i++) {
            if ((($vertices[$i]['lat'] > $lat != ($vertices[$j]['lat'] > $lat)) &&
                ($lon < ($vertices[$j]['lon'] - $vertices[$i]['lon']) * ($lat - $vertices[$i]['lat']) / ($vertices[$j]['lat'] - $vertices[$i]['lat']) + $vertices[$i]['lon'])))
                $c = !$c;
        }
        return $c;
    }
}
