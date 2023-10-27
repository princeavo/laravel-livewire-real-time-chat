<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewDiscussionMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $data;


    /**
     * Create a new event instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('discussion-message.'.$this->data['receiver_id']),
        ];
    }

    public function broadcastWith(){
        // return [
        //     "contenu" => $this->data['contenu'],
        //     "date" => $this->data['date'],
        //     "id" =>$this->data['id'],
        //     'isSaved' => false,
        //     'sentFromMe' => true,
        //     'read' => false
        // ];

        return $this->data;
    }
}
