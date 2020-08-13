<?php

namespace App\Listeners;

use App\Events\BuyCreated;

class AdjustBalancesNewBuy
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
     * @param BuyCreated $event
     * @return void
     */
    public function handle(BuyCreated $event)
    {
        $buy = $event->buy;

        $customer = $buy->customer;
        $customer->balance = intval($customer->balance - $buy->paid);
        $customer->save();
    }
}
