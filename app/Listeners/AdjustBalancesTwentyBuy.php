<?php

namespace App\Listeners;

use App\Events\TwentyBuyCreated;

class AdjustBalancesTwentyBuy
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
     * @param TwentyBuyCreated $event
     * @return void
     */
    public function handle(TwentyBuyCreated $event)
    {
        $twenty_buy = $event->twenty_buy;
        $customer = $twenty_buy->customer;
        $customer->balance = $customer->balance + $twenty_buy->bought * $twenty_buy->price;
        $customer->twenty_balance = $customer->twenty_balance + $twenty_buy->bought - $twenty_buy->returned;
        $customer->save();
    }
}
