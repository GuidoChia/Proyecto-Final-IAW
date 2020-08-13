<?php

namespace App\Events;

use App\TwentyBuy;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TwentyBuyCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $twenty_buy;

    /**
     * Create a new event instance.
     *
     * @param TwentyBuy $twenty_buy
     */
    public function __construct(TwentyBuy $twenty_buy)
    {
        $this->twenty_buy = $twenty_buy;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
