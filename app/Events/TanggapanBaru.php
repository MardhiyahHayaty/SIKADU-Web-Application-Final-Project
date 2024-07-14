<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TanggapanBaru implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tanggapan;
    /**
     * Create a new event instance.
     */
    public function __construct($tanggapan)
    {
        $this->tanggapan = $tanggapan;
        Log::info('Event TanggapanBaru dipicu dengan data: ', (array) $tanggapan);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('SIKADU');
    }

    public function broadcastAs()
    {
        return 'tanggapan-baru';
    }
}
