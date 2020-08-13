<?php

namespace App\Events;

use App\TwelveBuy;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TwelveBuyCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $twelve_buy;

    /**
     * Create a new event instance.
     *
     * @param TwelveBuy $twelve_buy
     */
    public function __construct(TwelveBuy $twelve_buy)
    {
        $this->twelve_buy = $twelve_buy;
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
