<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\BuyCreated' => [
            'App\Listeners\AdjustBalancesNewBuy',],
        'App\Events\TwentyBuyCreated' => [
            'App\Listeners\AdjustBalancesTwentyBuy',],
        'App\Events\TwelveBuyCreated' => [
            'App\Listeners\AdjustBalancesTwelveBuy',],
        'App\Events\ExtraBuyCreated' => [
            'App\Listeners\AdjustBalancesExtraBuy',],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
