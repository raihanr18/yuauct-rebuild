<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Auction::with(['item.category', 'staff', 'winner'])
            ->withCount('bids');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('item', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('start_time', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('end_time', '<=', $request->date_to);
        }

        $auctions = $query->latest()->paginate(10);
        
        return view('staff.auctions.index', compact('auctions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::whereDoesntHave('auctions', function ($query) {
            $query->whereIn('status', ['pending', 'open']);
        })->get();
        
        return view('staff.auctions.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Check if item already has an active auction
        $existingAuction = Auction::where('item_id', $validated['item_id'])
            ->whereIn('status', ['pending', 'open'])
            ->exists();

        if ($existingAuction) {
            return back()->with('error', 'Barang ini sudah memiliki lelang aktif.');
        }

        $validated['staff_id'] = Auth::id();
        $validated['status'] = 'pending';

        Auction::create($validated);

        return redirect()->route('staff.auctions.index')
            ->with('success', 'Lelang berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Auction $auction)
    {
        $auction->load(['item.category', 'bids.user', 'staff', 'winner']);
        $bids = $auction->bids()->with('user')->latest()->paginate(20);
        
        return view('staff.auctions.show', compact('auction', 'bids'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auction $auction)
    {
        /** @var \App\Models\Auction $auctionModel */
        $auctionModel = $auction;
        
        if ($auctionModel->status !== 'pending') {
            return back()->with('error', 'Hanya lelang dengan status pending yang dapat diedit.');
        }

        $items = Item::whereDoesntHave('auctions', function ($query) use ($auctionModel) {
            $query->whereIn('status', ['pending', 'open'])
                  ->where('id', '!=', $auctionModel->id);
        })->get();

        return view('staff.auctions.edit', compact('auction', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auction $auction)
    {
        /** @var \App\Models\Auction $auctionModel */
        $auctionModel = $auction;
        
        if ($auctionModel->status !== 'pending') {
            return back()->with('error', 'Hanya lelang dengan status pending yang dapat diedit.');
        }

        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        $auction->update($validated);

        return redirect()->route('staff.auctions.index')
            ->with('success', 'Lelang berhasil diperbarui.');
    }

    /**
     * Start auction (change status from pending to open)
     */
    public function start(Auction $auction)
    {
        /** @var \App\Models\Auction $auctionModel */
        $auctionModel = $auction;
        
        if ($auctionModel->status !== 'pending') {
            return back()->with('error', 'Lelang sudah dimulai atau berakhir.');
        }

        if ($auctionModel->start_time > now()) {
            return back()->with('error', 'Lelang belum saatnya dimulai.');
        }

        $auction->update(['status' => 'open']);

        return back()->with('success', 'Lelang berhasil dimulai.');
    }

    /**
     * Close auction manually
     */
    public function close(Auction $auction)
    {
        /** @var \App\Models\Auction $auctionModel */
        $auctionModel = $auction;
        
        if ($auctionModel->status !== 'open') {
            return back()->with('error', 'Hanya lelang yang sedang berlangsung yang dapat ditutup.');
        }

        $highestBid = $auction->bids()->orderBy('bid_amount', 'desc')->first();

        if ($highestBid) {
            $auction->update([
                'status' => 'closed',
                'final_price' => $highestBid->bid_amount,
                'winner_id' => $highestBid->user_id,
            ]);
        } else {
            $auction->update(['status' => 'closed']);
        }

        return back()->with('success', 'Lelang berhasil ditutup.');
    }

    /**
     * Cancel auction
     */
    public function cancel(Auction $auction)
    {
        /** @var \App\Models\Auction $auctionModel */
        $auctionModel = $auction;
        
        if (!in_array($auctionModel->status, ['pending', 'open'])) {
            return back()->with('error', 'Lelang tidak dapat dibatalkan.');
        }

        if ($auctionModel->bids()->exists()) {
            return back()->with('error', 'Tidak dapat membatalkan lelang yang sudah memiliki penawaran.');
        }

        $auction->update(['status' => 'closed']);

        return back()->with('success', 'Lelang berhasil dibatalkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auction $auction)
    {
        /** @var \App\Models\Auction $auctionModel */
        $auctionModel = $auction;
        
        if ($auctionModel->status === 'open') {
            return back()->with('error', 'Tidak dapat menghapus lelang yang sedang berlangsung.');
        }

        if ($auctionModel->bids()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus lelang yang sudah memiliki penawaran.');
        }

        $auctionModel->delete();

        return redirect()->route('staff.auctions.index')
            ->with('success', 'Lelang berhasil dihapus.');
    }
}
