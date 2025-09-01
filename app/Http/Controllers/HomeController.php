<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with featured auctions
     */
    public function index()
    {
        $featuredAuctions = Auction::with(['item.category', 'highestBid.user'])
            ->active()
            ->limit(6)
            ->get();

        $categories = Category::withCount([
            'items' => function ($query) {
                $query->whereHas('auctions', function ($auctionQuery) {
                    $auctionQuery->where('status', 'open')
                        ->where('start_time', '<=', now())
                        ->where('end_time', '>', now());
                });
            }
        ])->get();

        return view('home', compact('featuredAuctions', 'categories'));
    }

    /**
     * Display all active auctions
     */
    public function auctions(Request $request)
    {
        $query = Auction::with(['item.category', 'highestBid.user'])->active();

        // Search by item name
        if ($request->filled('search')) {
            $query->whereHas('item', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('item', function ($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        // Sort options
        switch ($request->get('sort', 'ending_soon')) {
            case 'price_low':
                $query->join('items', 'auctions.item_id', '=', 'items.id')
                      ->orderBy('items.start_price', 'asc');
                break;
            case 'price_high':
                $query->join('items', 'auctions.item_id', '=', 'items.id')
                      ->orderBy('items.start_price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default: // ending_soon
                $query->orderBy('end_time', 'asc');
                break;
        }

        $auctions = $query->paginate(12);
        $categories = Category::all();

        return view('auctions.index', compact('auctions', 'categories'));
    }
}
