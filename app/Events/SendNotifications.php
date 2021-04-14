<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Notifications;
use App\Events\SendNotifications;

class SendNotifications implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

        public $notificationId;
        public $message;

    public function __construct($notificationId, $body)
    {
        $this->notificationId = $notificationId;
        $this->message = $body;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('notify');
    }
    public function broadcastAs()
    {
        return 'notification';
    }

    public function broadcastWith(){

        return[
            'notificationId' => $this->notificationId,
            'message' => $this->message,
        ];
    }
}
