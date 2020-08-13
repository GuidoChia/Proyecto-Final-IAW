<?php

namespace App\Listeners;

use App\Events\TwelveBuyCreated;

class AdjustBalancesTwelveBuy
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
     * @param TwelveBuyCreated $event
     * @return void
     */
    public function handle(TwelveBuyCreated $event)
    {
        $twelve_buy = $event->twelve_buy;
        $customer = $twelve_buy->customer;
        $customer->balance = $customer->balance + $twelve_buy->bought * $twelve_buy->price;
        $customer->twelve_balance = $customer->twelve_balance + $twelve_buy->bought - $twelve_buy->returned;
        $customer->save();
    }
}
