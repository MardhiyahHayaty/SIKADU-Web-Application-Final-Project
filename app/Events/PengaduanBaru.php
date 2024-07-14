<?php

namespace App\Events;

use App\Models\Pengaduan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PengaduanBaru implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pengaduan;
    /**
     * Create a new event instance.
     */
    public function __construct($pengaduan)
    {
        $this->pengaduan = $pengaduan;
        Log::info('Event PengaduanBaru dipicu dengan data: ', (array) $pengaduan);
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
        return 'pengaduan-baru';
    }
}
