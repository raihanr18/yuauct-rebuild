<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'staff_id',
        'start_time',
        'end_time',
        'final_price',
        'winner_id',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'final_price' => 'integer',
    ];

    /**
     * Get the item being auctioned
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the staff managing this auction
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Get the winner of this auction
     */
    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    /**
     * Get all bids for this auction
     */
    public function bids()
    {
        return $this->hasMany(Bid::class)->orderBy('bid_amount', 'desc');
    }

    /**
     * Get the highest bid for this auction
     */
    public function highestBid()
    {
        return $this->hasOne(Bid::class)->orderBy('bid_amount', 'desc');
    }

    /**
     * Get current highest bid amount
     */
    public function getCurrentBidAttribute()
    {
        $highestBid = $this->highestBid;
        return $highestBid ? $highestBid->bid_amount : $this->item->start_price;
    }

    /**
     * Check if auction is active
     */
    public function isActive()
    {
        return $this->status === 'open' && 
               $this->start_time <= now() && 
               $this->end_time > now();
    }

    /**
     * Check if auction has ended
     */
    public function hasEnded()
    {
        return $this->end_time <= now() || $this->status === 'closed';
    }

    /**
     * Get time remaining in seconds
     */
    public function getTimeRemainingAttribute()
    {
        if ($this->hasEnded()) {
            return 0;
        }
        
        return $this->end_time->diffInSeconds(now());
    }

    /**
     * Get formatted current bid
     */
    public function getFormattedCurrentBidAttribute()
    {
        return 'Rp ' . number_format($this->current_bid, 0, ',', '.');
    }

    /**
     * Get formatted final price
     */
    public function getFormattedFinalPriceAttribute()
    {
        return $this->final_price ? 'Rp ' . number_format($this->final_price, 0, ',', '.') : null;
    }

    /**
     * Scope for active auctions
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'open')
                    ->where('start_time', '<=', now())
                    ->where('end_time', '>', now());
    }

    /**
     * Scope for ended auctions
     */
    public function scopeEnded($query)
    {
        return $query->where(function($q) {
            $q->where('end_time', '<=', now())
              ->orWhere('status', 'closed');
        });
    }
}
