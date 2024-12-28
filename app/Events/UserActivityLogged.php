<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserActivityLogged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $activity;
    public $description;

    /**
     * Create a new event instance.
     *
     * @param int $userId
     * @param string $activity
     * @param string|null $description
     */
    public function __construct(int $userId, string $activity, ?string $description = null)
    {
        $this->userId = $userId;
        $this->activity = $activity;
        $this->description = $description;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}

