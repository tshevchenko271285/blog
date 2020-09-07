<?php

namespace App\Events;

use App\Attachment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OnAttachmentDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $attachment;

    /**
     * Create a new event instance.
     *
     * @param Attachment $attachment
     */
    public function __construct(Attachment $attachment)
    {
        $this->attachment = $attachment;
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
