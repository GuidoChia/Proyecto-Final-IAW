<?php

namespace App\Console\Commands;

use App\Address;
use App\Customer;
use App\Section;
use Illuminate\Console\Command;

class SetupAddresses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addresses:setup {--fresh=true}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup known addresses for testing';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('fresh')) {
            Address::query()->delete();
        }

        $names = ['Municipalidad',
            'Abuela Tita',
            'Alvarez Carlos',
            'Aschemacher Sergio',
            'Aino Mario',
            'Alvarez Gaston',
            'Arellano Tole',
            'Ancin Nidia',
            'Barth Kuky',
            'Barth Mario',
            'Bauer Manuel',
            'Bauer Pique'
        ];

        $latitudes = [-37.3772748,
            -37.37499749822193,
            -37.379696839771114,
            -37.374098148715504,
            -37.379696839771114,
            -37.37702208722281,
            -37.38063016506052,
            -37.37722259388393,
            -37.38015169409171,
            -37.372848462834746,
            -37.376832606535515,
            -37.37650268842168];
        $longitudes = [-63.7724862,
            -63.774760365486145,
            -63.77578929504273,
            -63.777610302683456,
            -63.77578929504273,
            -63.77229155563725,
            -63.76719704073065,
            -63.771752254057446,
            -63.766778984610994,
            -63.77613900489865,
            -63.77866467117019,
            -63.7793921359206];

        $section1 = new Section();
        $section1->name = "S1";
        $section1->save();

        $section2 = new Section();
        $section2->name = "S2";
        $section2->save();


        for ($i = 0; $i < count($names); $i++) {
            $customer = Customer::findByName($names[$i])->first();
            $address = new Address;
            $address->lat = $latitudes[$i];
            $address->lon = $longitudes[$i];
            $address->description = $customer->name . " address.";
            $address->customer_id = $customer->id;
            if ($i % 2 == 0) {
                $address->section_id = $section1->id;
            } else {
                $address->section_id = $section2->id;
            }
            $address->save();
            $customer->address_id = $address->id;
            $customer->save();
        }

        return 0;
    }
}
