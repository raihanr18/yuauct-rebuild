<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'start_price',
        'category_id',
    ];

    protected $casts = [
        'start_price' => 'integer',
    ];

    /**
     * Get the category this item belongs to
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get auctions for this item
     */
    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    /**
     * Get active auction for this item
     */
    public function activeAuction()
    {
        return $this->hasOne(Auction::class)->where('status', 'open');
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/items/' . $this->image);
    }

    /**
     * Get formatted start price
     */
    public function getFormattedStartPriceAttribute()
    {
        return 'Rp ' . number_format($this->start_price, 0, ',', '.');
    }
}
