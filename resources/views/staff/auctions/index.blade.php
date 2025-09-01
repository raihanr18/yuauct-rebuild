@extends('layouts.admin')

@section('title', 'Manage Auctions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-hammer me-2"></i>Manage Auctions</h2>
    <a href="{{ route('staff.auctions.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Create New Auction
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $auctions->where('status', 'pending')->count() }}</h3>
                        <p class="text-muted mb-0">Pending</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-play-circle text-success" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $auctions->where('status', 'open')->count() }}</h3>
                        <p class="text-muted mb-0">Active</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-check-circle text-info" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $auctions->where('status', 'closed')->count() }}</h3>
                        <p class="text-muted mb-0">Completed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="table-card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('staff.auctions.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="search" class="form-label">Search Items</label>
                <input type="text" name="search" id="search" class="form-control" 
                       placeholder="Search by item name..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" name="date_from" id="date_from" class="form-control" 
                       value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" name="date_to" id="date_to" class="form-control" 
                       value="{{ request('date_to') }}">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
                <a href="{{ route('staff.auctions.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Auctions Table -->
<div class="table-card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>All Auctions</h5>
    </div>
    <div class="card-body p-0">
        @if($auctions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Starting Price</th>
                            <th>Current Bid</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th>Bids Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($auctions as $auction)
                            <tr>
                                <td>{{ $loop->iteration + ($auctions->currentPage() - 1) * $auctions->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($auction->item->image)
                                            <img src="{{ asset('storage/' . $auction->item->image) }}" 
                                                 alt="{{ $auction->item->name }}" 
                                                 class="rounded me-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #ddd;"
                                                 title="Image: {{ $auction->item->image }}">
                                        @else
                                            <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong class="text-truncate d-block" style="max-width: 200px;" 
                                                    title="{{ $auction->item->name }}">
                                                {{ $auction->item->name }}
                                            </strong>
                                            <small class="text-muted">{{ $auction->item->category->name ?? 'Uncategorized' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-medium text-success">
                                        Rp {{ number_format($auction->item->start_price, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    @if($auction->current_bid && $auction->current_bid > $auction->item->start_price)
                                        <span class="fw-medium text-primary">
                                            Rp {{ number_format($auction->current_bid, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-muted">No bids yet</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $auction->start_time->format('M d, Y') }}</small><br>
                                    <small class="text-muted">{{ $auction->start_time->format('H:i') }}</small>
                                </td>
                                <td>
                                    <small>{{ $auction->end_time->format('M d, Y') }}</small><br>
                                    <small class="text-muted">{{ $auction->end_time->format('H:i') }}</small>
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
                                    <span class="badge bg-light text-dark">
                                        {{ $auction->bids_count ?? 0 }} bids
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('staff.auctions.show', $auction) }}" 
                                           class="btn btn-sm btn-outline-info" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        @if($auction->status === 'pending')
                                            <a href="{{ route('staff.auctions.edit', $auction) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            
                                            <form method="POST" action="{{ route('staff.auctions.start', $auction) }}" 
                                                  class="d-inline" onsubmit="return confirm('Start this auction?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Start Auction">
                                                    <i class="bi bi-play"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($auction->status === 'open')
                                            <form method="POST" action="{{ route('staff.auctions.close', $auction) }}" 
                                                  class="d-inline" onsubmit="return confirm('Close this auction?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Close Auction">
                                                    <i class="bi bi-stop"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if(in_array($auction->status, ['pending']) && $auction->bids_count == 0)
                                            <form method="POST" action="{{ route('staff.auctions.cancel', $auction) }}" 
                                                  class="d-inline" onsubmit="return confirm('Cancel this auction?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancel">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-hammer text-muted mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-muted">No auctions found</h5>
                <p class="text-muted mb-3">Get started by creating your first auction.</p>
                <a href="{{ route('staff.auctions.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Create New Auction
                </a>
            </div>
        @endif
    </div>
    
    @if($auctions->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Showing {{ $auctions->firstItem() }} to {{ $auctions->lastItem() }} of {{ $auctions->total() }} results
                </small>
                {{ $auctions->links() }}
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh page for active auctions every 30 seconds
    if ({{ $auctions->where('status', 'open')->count() > 0 ? 'true' : 'false' }}) {
        setInterval(function() {
            // Only refresh if user is still on the page
            if (document.visibilityState === 'visible') {
                window.location.reload();
            }
        }, 30000);
    }
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
