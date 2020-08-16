<?php

namespace App\Console\Commands;

use App\Address;
use App\Customer;
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
        if ($this->option('fresh')){
            Address::query()->delete();
        }
        $names = ['Municipalidad',
            'Abuela Tita'];
        $latitudes = [-37.3772748,
            37.37499749822193];
        $longitudes = [-63.7724862,
            -63.774760365486145];

        for ($i=0; $i<count($names); $i++){
            $customer = Customer::findByName($names[$i])->first();
            $address = new Address;
            $address->lat=$latitudes[$i];
            $address->lon=$longitudes[$i];
            $address->description=$customer->name." address.";
            $address->save();
            $customer->address_id=$address->id;
            $customer->save();
        }

        return 0;
    }
}
