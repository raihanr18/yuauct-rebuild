<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Item::with(['category', 'auctions']);

        // Apply filters
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('price_min')) {
            $query->where('start_price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('start_price', '<=', $request->price_max);
        }

        $items = $query->latest()->paginate(10);
        
        // Get statistics
        $totalItems = Item::count();
        $availableItems = Item::whereDoesntHave('auctions', function ($q) {
            $q->whereIn('status', ['open', 'pending']);
        })->count();
        $inAuctionItems = Item::whereHas('auctions', function ($q) {
            $q->where('status', 'open');
        })->count();
        $soldItems = Item::whereHas('auctions', function ($q) {
            $q->where('status', 'closed')->whereNotNull('winner_id');
        })->count();
        
        // Get categories for filter dropdown
        $categories = Category::all();
        
        return view('staff.items.index', compact(
            'items', 
            'categories',
            'totalItems',
            'availableItems', 
            'inAuctionItems',
            'soldItems'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('staff.items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {
        $validated = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/items', $imageName);
            $validated['image'] = $imageName;
        }

        Item::create($validated);

        return redirect()->route('staff.items.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $item->load(['category', 'auctions.bids']);
        return view('staff.items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('staff.items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_price' => 'required|numeric|min:1000',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            /** @var \App\Models\Item $itemModel */
            $itemModel = $item;
            
            // Delete old image
            if ($itemModel->image) {
                Storage::delete('public/items/' . $itemModel->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/items', $imageName);
            $validated['image'] = $imageName;
        }

        $item->update($validated);

        return redirect()->route('staff.items.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        /** @var \App\Models\Item $itemModel */
        $itemModel = $item;
        
        // Check if item has active auctions
        if ($itemModel->auctions()->where('status', '!=', 'closed')->exists()) {
            return back()->with('error', 'Tidak dapat menghapus barang yang sedang dilelang.');
        }

        // Delete image
        if ($itemModel->image) {
            Storage::delete('public/items/' . $itemModel->image);
        }

        $itemModel->delete();

        return redirect()->route('staff.items.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
