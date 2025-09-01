<?php

namespace App\Events;

use App\Models\Bid;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BidPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bid;

    /**
     * Create a new event instance.
     */
    public function __construct(Bid $bid)
    {
        // Load necessary relationships
        $bid->load(['auction', 'user']);
        $this->bid = $bid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        /** @var \App\Models\Bid $bid */
        $bid = $this->bid;
        return [
            new Channel('auction.' . $bid->auction_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'bid.placed';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        /** @var \App\Models\Bid $bid */
        $bid = $this->bid;
        /** @var \App\Models\Auction $auction */
        $auction = $bid->auction;
        
        // Ensure auction is fresh with latest data
        $auction->refresh();
        
        return [
            'bid' => [
                'id' => $bid->id,
                'auction_id' => $bid->auction_id,
                'user_name' => $bid->user->name,
                'bid_amount' => $bid->bid_amount,
                'formatted_bid_amount' => $bid->formatted_bid_amount,
                'created_at' => $bid->created_at->toISOString(),
            ],
            'auction' => [
                'id' => $auction->id,
                'current_bid' => $auction->current_bid,
                'formatted_current_bid' => $auction->formatted_current_bid,
            ]
        ];
    }
}
