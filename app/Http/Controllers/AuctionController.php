<?php

namespace App\Http\Controllers;

use App\Events\BidPlaced;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuctionController extends Controller
{
    /**
     * Show auction detail
     */
    public function show(Auction $auction)
    {
        $auction->load(['item.category', 'bids.user', 'staff', 'winner']);
        
        // Check if auction exists and is accessible
        if (!$auction->isActive() && $auction->status !== 'closed') {
            return redirect()->route('home')->with('error', 'Lelang tidak ditemukan atau sudah berakhir.');
        }

        $bids = $auction->bids()->with('user')->latest()->paginate(10);
        $userBids = null;
        
        if (Auth::check()) {
            $userBids = $auction->bids()
                ->where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();
        }

        return view('auctions.show', compact('auction', 'bids', 'userBids'));
    }

    /**
     * Place a bid on auction
     */
    public function bid(Request $request, Auction $auction)
    {
        // Manual authorization check
        if (!Auth::check() || Auth::user()->role !== 'user') {
            abort(403, 'Unauthorized');
        }
        
        // Manual validation
        $request->validate([
            'bid_amount' => ['required', 'numeric', 'min:1000']
        ]);
        
        if (!$auction->isActive()) {
            return back()->with('error', 'Lelang sudah berakhir atau belum dimulai.');
        }

        $bidAmount = $request->bid_amount;
        $currentBid = $auction->current_bid ?? $auction->item->start_price ?? 0;

        if ($bidAmount <= $currentBid) {
            return back()->with('error', 'Penawaran harus lebih tinggi dari penawaran saat ini.');
        }

        // Check if user has placed a bid in the last 10 seconds (prevent spam)
        $recentBid = Bid::where('auction_id', $auction->id)
            ->where('user_id', Auth::id())
            ->where('created_at', '>', now()->subSeconds(10))
            ->first();

        if ($recentBid) {
            return back()->with('error', 'Harap tunggu 10 detik sebelum menawar lagi.');
        }

        try {
            DB::transaction(function () use ($auction, $bidAmount) {
                $bid = Bid::create([
                    'auction_id' => $auction->id,
                    'user_id' => Auth::id(),
                    'bid_amount' => $bidAmount,
                ]);

                // Broadcast the new bid
                broadcast(new BidPlaced($bid))->toOthers();
            });

            return back()->with('success', 'Penawaran berhasil ditempatkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menawar. Silakan coba lagi.');
        }
    }

    /**
     * Get current auction data for real-time updates
     */
    public function currentData(Auction $auction)
    {
        return response()->json([
            'current_bid' => $auction->current_bid ?? $auction->item->start_price ?? 0,
            'formatted_current_bid' => $auction->formatted_current_bid ?? 'Rp 0',
            'time_remaining' => $auction->time_remaining ?? 0,
            'is_active' => $auction->isActive(),
            'bid_count' => $auction->bids()->count(),
        ]);
    }
}
