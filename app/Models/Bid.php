<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'user_id',
        'bid_amount',
    ];

    protected $casts = [
        'bid_amount' => 'integer',
    ];

    /**
     * Get the auction this bid belongs to
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    /**
     * Get the user who made this bid
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted bid amount
     */
    public function getFormattedBidAmountAttribute()
    {
        return 'Rp ' . number_format($this->bid_amount, 0, ',', '.');
    }

    /**
     * Scope for latest bids first
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope for highest bids first
     */
    public function scopeHighest($query)
    {
        return $query->orderBy('bid_amount', 'desc');
    }
}
