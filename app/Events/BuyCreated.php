<?php

namespace App\Events;

use App\Buy;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BuyCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $buy;

    /**
     * Create a new event instance.
     *
     * @param Buy $buy
     */
    public function __construct(Buy $buy)
    {
        $this->buy = $buy;
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
