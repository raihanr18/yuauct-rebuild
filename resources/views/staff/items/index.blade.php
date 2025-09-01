@extends('layouts.admin')

@section('title', 'Manage Items')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box me-2"></i>Manage Items</h2>
    <a href="{{ route('staff.items.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Add New Item
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-box text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $totalItems }}</h3>
                        <p class="text-muted mb-0">Total Items</p>
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
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $availableItems }}</h3>
                        <p class="text-muted mb-0">Available</p>
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
                        <i class="bi bi-hammer text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $inAuctionItems }}</h3>
                        <p class="text-muted mb-0">In Auction</p>
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
                        <i class="bi bi-trophy text-info" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $soldItems }}</h3>
                        <p class="text-muted mb-0">Sold</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="table-card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('staff.items.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="search" class="form-label">Search Items</label>
                <input type="text" name="search" id="search" class="form-control" 
                       placeholder="Search by name or description..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label for="price_min" class="form-label">Min Price</label>
                <input type="number" name="price_min" id="price_min" class="form-control" 
                       placeholder="0" value="{{ request('price_min') }}">
            </div>
            <div class="col-md-3">
                <label for="price_max" class="form-label">Max Price</label>
                <input type="number" name="price_max" id="price_max" class="form-control" 
                       placeholder="999999999" value="{{ request('price_max') }}">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
                <a href="{{ route('staff.items.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Items Table -->
<div class="table-card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>All Items</h5>
    </div>
    <div class="card-body p-0">
        @if($items->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Starting Price</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" 
                                                 alt="{{ $item->name }}" 
                                                 class="rounded me-2" 
                                                 style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #ddd;"
                                                 title="Image: {{ $item->image }}">
                                        @else
                                            <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong class="text-truncate d-block" style="max-width: 200px;" 
                                                    title="{{ $item->name }}">
                                                {{ $item->name }}
                                            </strong>
                                            <small class="text-muted text-truncate d-block" style="max-width: 250px;" 
                                                   title="{{ $item->description }}">
                                                {{ Str::limit($item->description, 50) }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $item->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-medium text-success">
                                        Rp {{ number_format($item->start_price, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $activeAuction = $item->auctions->where('status', 'open')->first();
                                        $closedAuction = $item->auctions->where('status', 'closed')->first();
                                        $pendingAuction = $item->auctions->where('status', 'pending')->first();
                                    @endphp
                                    
                                    @if($activeAuction)
                                        <span class="badge bg-success">In Auction</span>
                                    @elseif($pendingAuction)
                                        <span class="badge bg-warning">Auction Pending</span>
                                    @elseif($closedAuction)
                                        <span class="badge bg-info">Sold</span>
                                    @else
                                        <span class="badge bg-light text-dark">Available</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $item->created_at->format('M d, Y') }}</small><br>
                                    <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('staff.items.show', $item) }}" 
                                           class="btn btn-sm btn-outline-info" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        @if(!$activeAuction && !$pendingAuction)
                                            <a href="{{ route('staff.items.edit', $item) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                        
                                        @if(!$activeAuction && !$pendingAuction && !$closedAuction)
                                            <form method="POST" action="{{ route('staff.items.destroy', $item) }}" 
                                                  class="d-inline" onsubmit="return confirm('Delete this item? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if(!$activeAuction && !$pendingAuction)
                                            <a href="{{ route('staff.auctions.create', ['item_id' => $item->id]) }}" 
                                               class="btn btn-sm btn-outline-success" title="Create Auction">
                                                <i class="bi bi-hammer"></i>
                                            </a>
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
                <i class="bi bi-box text-muted mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-muted">No items found</h5>
                <p class="text-muted mb-3">Get started by adding your first item to the inventory.</p>
                <a href="{{ route('staff.items.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add New Item
                </a>
            </div>
        @endif
    </div>
    
    @if($items->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} results
                </small>
                {{ $items->links() }}
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
