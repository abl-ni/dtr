<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RequestOvertime implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $text;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $text)
    {
        $this->text = $text;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('test_channel');
    }

    public function broadcastWith()
    {
        return [
            'name' => $this->text['name']
        ];
    }
}
