<?php

namespace App\Listeners;

use App\Events\ExtraBuyCreated;

class AdjustBalancesExtraBuy
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ExtraBuyCreated $event
     * @return void
     */
    public function handle(ExtraBuyCreated $event)
    {
        $extra_buy = $event->extra_buy;
        $customer = $extra_buy->customer;
        $customer->balance = $customer->balance + $extra_buy->price;
        $customer->save();
    }
}
