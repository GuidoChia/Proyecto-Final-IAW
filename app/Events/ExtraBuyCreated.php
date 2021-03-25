<?php

namespace App\Events;

use App\ExtraBuy;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExtraBuyCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $extra_buy;

    /**
     * Create a new event instance.
     *
     * @param ExtraBuy $extra_buy
     */
    public function __construct(ExtraBuy $extra_buy)
    {
        $this->extra_buy = $extra_buy;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
