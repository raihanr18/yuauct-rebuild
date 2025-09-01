@extends('layouts.admin')

@section('title', 'Item Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-eye me-2"></i>Item Details</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('staff.items.index') }}">Items</a></li>
                <li class="breadcrumb-item active">{{ $item->name }}</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('staff.items.index') }}" class="btn btn-outline-secondary me-2">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
        @if(!$item->auctions->filter(function($auction) { return in_array($auction->status, ['open', 'pending']); })->count())
            <a href="{{ route('staff.items.edit', $item) }}" class="btn btn-outline-primary me-2">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <a href="{{ route('staff.auctions.create', ['item_id' => $item->id]) }}" class="btn btn-primary">
                <i class="bi bi-hammer me-1"></i> Create Auction
            </a>
        @endif
    </div>
</div>

<div class="row">
    <!-- Item Information -->
    <div class="col-lg-8">
        <div class="table-card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-box me-2"></i>Item Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" 
                                 alt="{{ $item->name }}" 
                                 class="img-fluid rounded mb-3"
                                 style="width: 100%; max-height: 400px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" 
                                 style="height: 300px;">
                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <h3 class="mb-3">{{ $item->name }}</h3>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Description</h6>
                            <p class="mb-0">{{ $item->description }}</p>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <h6 class="text-muted mb-1">Category</h6>
                                <span class="badge bg-primary fs-6">{{ $item->category->name ?? 'Uncategorized' }}</span>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-muted mb-1">Starting Price</h6>
                                <span class="text-success fw-bold fs-4">{{ $item->formatted_start_price }}</span>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <h6 class="text-muted mb-1">Added Date</h6>
                                <span>{{ $item->created_at->format('M d, Y') }}</span><br>
                                <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-muted mb-1">Last Updated</h6>
                                <span>{{ $item->updated_at->format('M d, Y') }}</span><br>
                                <small class="text-muted">{{ $item->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auction History -->
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-hammer me-2"></i>Auction History</h5>
                <span class="badge bg-light text-dark">{{ $item->auctions->count() }} total auctions</span>
            </div>
            <div class="card-body p-0">
                @if($item->auctions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Auction Period</th>
                                    <th>Status</th>
                                    <th>Final Price</th>
                                    <th>Winner</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($item->auctions as $auction)
                                    <tr>
                                        <td>
                                            <strong>{{ $auction->start_time->format('M d, Y') }}</strong><br>
                                            <small class="text-muted">{{ $auction->start_time->format('H:i') }} - {{ $auction->end_time->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'warning',
                                                    'open' => 'success',
                                                    'closed' => 'info'
                                                ];
                                            @endphp
                                            <span class="badge bg-{{ $statusColors[$auction->status] ?? 'secondary' }}">
                                                {{ ucfirst($auction->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($auction->final_price)
                                                <span class="fw-bold text-success">
                                                    Rp {{ number_format($auction->final_price, 0, ',', '.') }}
                                                </span>
                                            @elseif($auction->status === 'open' && $auction->current_bid)
                                                <span class="text-primary">
                                                    Rp {{ number_format($auction->current_bid, 0, ',', '.') }}
                                                </span>
                                                <br><small class="text-muted">(Current bid)</small>
                                            @else
                                                <span class="text-muted">No bids</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($auction->winner)
                                                <div>
                                                    <strong>{{ $auction->winner->name }}</strong><br>
                                                    <small class="text-muted">{{ $auction->winner->email }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">No winner</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('staff.auctions.show', $auction) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-hammer text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">No auctions yet</h5>
                        <p class="text-muted mb-3">This item hasn't been put up for auction yet.</p>
                        <a href="{{ route('staff.auctions.create', ['item_id' => $item->id]) }}" class="btn btn-primary">
                            <i class="bi bi-hammer me-1"></i> Create First Auction
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Item Status Sidebar -->
    <div class="col-lg-4">
        <!-- Status Card -->
        <div class="table-card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Item Status</h6>
            </div>
            <div class="card-body">
                @php
                    $activeAuction = $item->auctions->where('status', 'open')->first();
                    $pendingAuction = $item->auctions->where('status', 'pending')->first();
                    $closedAuction = $item->auctions->where('status', 'closed')->first();
                @endphp

                <div class="text-center mb-3">
                    @if($activeAuction)
                        <span class="badge bg-success fs-6 px-3 py-2">
                            <i class="bi bi-play-circle me-1"></i> In Auction
                        </span>
                    @elseif($pendingAuction)
                        <span class="badge bg-warning fs-6 px-3 py-2">
                            <i class="bi bi-clock me-1"></i> Auction Pending
                        </span>
                    @elseif($closedAuction)
                        <span class="badge bg-info fs-6 px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i> Sold
                        </span>
                    @else
                        <span class="badge bg-light text-dark fs-6 px-3 py-2">
                            <i class="bi bi-box me-1"></i> Available
                        </span>
                    @endif
                </div>

                @if($activeAuction)
                    <div class="alert alert-success">
                        <h6 class="alert-heading">Currently in Auction</h6>
                        <p class="mb-1">End time: {{ $activeAuction->end_time->format('M d, Y H:i') }}</p>
                        <small>{{ $activeAuction->bids_count ?? 0 }} bids received</small>
                    </div>
                @elseif($pendingAuction)
                    <div class="alert alert-warning">
                        <h6 class="alert-heading">Auction Scheduled</h6>
                        <p class="mb-1">Start time: {{ $pendingAuction->start_time->format('M d, Y H:i') }}</p>
                        <small>Auction will begin automatically</small>
                    </div>
                @elseif($closedAuction)
                    <div class="alert alert-info">
                        <h6 class="alert-heading">Item Sold</h6>
                        <p class="mb-1">Final price: {{ $closedAuction->formatted_final_price }}</p>
                        <small>Sold to {{ $closedAuction->winner->name ?? 'Unknown' }}</small>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        @if(!$activeAuction && !$pendingAuction)
            <div class="table-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-gear me-2"></i>Quick Actions</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('staff.auctions.create', ['item_id' => $item->id]) }}" 
                       class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-hammer me-1"></i> Create Auction
                    </a>
                    
                    <a href="{{ route('staff.items.edit', $item) }}" 
                       class="btn btn-outline-primary w-100 mb-2">
                        <i class="bi bi-pencil me-1"></i> Edit Item
                    </a>
                    
                    @if(!$closedAuction)
                        <form method="POST" action="{{ route('staff.items.destroy', $item) }}" 
                              onsubmit="return confirm('Delete this item? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-trash me-1"></i> Delete Item
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif

        <!-- Item Stats -->
        <div class="table-card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Statistics</h6>
            </div>
            <div class="card-body">
                <div class="row g-3 text-center">
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <h4 class="mb-1 text-primary">{{ $item->auctions->count() }}</h4>
                            <small class="text-muted">Total Auctions</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <h4 class="mb-1 text-success">{{ $item->auctions->sum('bids_count') ?? 0 }}</h4>
                            <small class="text-muted">Total Bids</small>
                        </div>
                    </div>
                </div>
                
                @if($closedAuction && $closedAuction->final_price)
                    <div class="mt-3 text-center">
                        <div class="border rounded p-2">
                            <h5 class="mb-1 text-success">{{ $closedAuction->formatted_final_price }}</h5>
                            <small class="text-muted">Final Sale Price</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
