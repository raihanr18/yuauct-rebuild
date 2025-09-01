@extends('layouts.admin')

@section('title', 'Auction Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-eye me-2"></i>Auction Details</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('staff.auctions.index') }}">Auctions</a></li>
                <li class="breadcrumb-item active">{{ $auction->item->name }}</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('staff.auctions.index') }}" class="btn btn-outline-secondary me-2">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
        @if($auction->status === 'pending')
            <a href="{{ route('staff.auctions.edit', $auction) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
        @endif
    </div>
</div>

<!-- Auction Status Alert -->
@php
    $statusColors = [
        'pending' => 'warning',
        'open' => 'success',
        'closed' => 'info'
    ];
    $statusMessages = [
        'pending' => 'This auction is pending and has not started yet.',
        'open' => 'This auction is currently active and accepting bids.',
        'closed' => 'This auction has ended.'
    ];
@endphp

<div class="alert alert-{{ $statusColors[$auction->status] }} mb-4">
    <div class="d-flex align-items-center">
        <i class="bi bi-{{ $auction->status === 'pending' ? 'clock' : ($auction->status === 'open' ? 'play-circle' : 'check-circle') }} me-2"></i>
        <strong>{{ ucfirst($auction->status) }} Auction:</strong>
        <span class="ms-2">{{ $statusMessages[$auction->status] }}</span>
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
                    <div class="col-md-4">
                        @if($auction->item->image)
                            <img src="{{ asset('storage/' . $auction->item->image) }}" 
                                 alt="{{ $auction->item->name }}" 
                                 class="img-fluid rounded mb-3">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" 
                                 style="height: 200px;">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h4 class="mb-3">{{ $auction->item->name }}</h4>
                        <p class="text-muted mb-3">{{ $auction->item->description }}</p>
                        
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <strong>Category:</strong><br>
                                <span class="badge bg-light text-dark">{{ $auction->item->category->name ?? 'Uncategorized' }}</span>
                            </div>
                            <div class="col-sm-6">
                                <strong>Starting Price:</strong><br>
                                <span class="text-success fw-bold fs-5">{{ $auction->item->formatted_start_price }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bidding History -->
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-currency-dollar me-2"></i>Bidding History</h5>
                <span class="badge bg-light text-dark">{{ $auction->bids_count }} total bids</span>
            </div>
            <div class="card-body p-0">
                @if($auction->bids->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Bidder</th>
                                    <th>Bid Amount</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auction->bids as $bid)
                                    <tr class="{{ $loop->first ? 'table-success' : '' }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    @if($loop->first)
                                                        <i class="bi bi-trophy text-warning"></i>
                                                    @else
                                                        <i class="bi bi-person text-muted"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <strong>{{ $bid->user->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $bid->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-{{ $loop->first ? 'success' : 'primary' }}">
                                                Rp {{ number_format($bid->bid_amount, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $bid->created_at->format('M d, Y') }}</small><br>
                                            <small class="text-muted">{{ $bid->created_at->format('H:i:s') }}</small>
                                        </td>
                                        <td>
                                            @if($loop->first && $auction->status === 'closed')
                                                <span class="badge bg-success">Winning Bid</span>
                                            @elseif($loop->first)
                                                <span class="badge bg-warning">Highest Bid</span>
                                            @else
                                                <span class="badge bg-light text-dark">Outbid</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-currency-dollar text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">No bids yet</h5>
                        <p class="text-muted">Be the first to place a bid on this item!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Auction Details Sidebar -->
    <div class="col-lg-4">
        <!-- Auction Status Card -->
        <div class="table-card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Auction Status</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <span class="badge bg-{{ $statusColors[$auction->status] }} fs-6 px-3 py-2">
                        {{ ucfirst($auction->status) }}
                    </span>
                </div>

                <div class="row g-3 text-center">
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <small class="text-muted d-block">Start Time</small>
                            <strong>{{ $auction->start_time->format('M d, Y') }}</strong><br>
                            <small>{{ $auction->start_time->format('H:i') }}</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <small class="text-muted d-block">End Time</small>
                            <strong>{{ $auction->end_time->format('M d, Y') }}</strong><br>
                            <small>{{ $auction->end_time->format('H:i') }}</small>
                        </div>
                    </div>
                </div>

                @if($auction->status === 'open')
                    <div class="mt-3 text-center">
                        @if($auction->end_time > now())
                            <small class="text-muted">Time remaining:</small>
                            <div class="fw-bold text-danger" id="countdown">
                                <!-- Countdown will be updated by JavaScript -->
                            </div>
                        @else
                            <div class="text-warning">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Auction has expired
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Current Bid Card -->
        <div class="table-card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-currency-dollar me-2"></i>Current Bid</h6>
            </div>
            <div class="card-body text-center">
                <div class="display-6 fw-bold text-success mb-2">
                    @if($auction->current_bid && $auction->current_bid > $auction->item->start_price)
                        Rp {{ number_format($auction->current_bid, 0, ',', '.') }}
                    @else
                        {{ $auction->item->formatted_start_price }}
                    @endif
                </div>
                <small class="text-muted">
                    @if($auction->current_bid && $auction->current_bid > $auction->item->start_price)
                        Current highest bid
                    @else
                        Starting price
                    @endif
                </small>

                @if($auction->winner)
                    <div class="mt-3">
                        <div class="alert alert-success">
                            <i class="bi bi-trophy me-1"></i>
                            <strong>Winner:</strong><br>
                            {{ $auction->winner->name }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Staff Actions -->
        @if(in_array($auction->status, ['pending', 'open']))
            <div class="table-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-gear me-2"></i>Staff Actions</h6>
                </div>
                <div class="card-body">
                    @if($auction->status === 'pending')
                        <form method="POST" action="{{ route('staff.auctions.start', $auction) }}" 
                              class="mb-2" onsubmit="return confirm('Start this auction now?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-play me-1"></i> Start Auction
                            </button>
                        </form>
                    @endif

                    @if($auction->status === 'open')
                        <form method="POST" action="{{ route('staff.auctions.close', $auction) }}" 
                              class="mb-2" onsubmit="return confirm('Close this auction now?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="bi bi-stop me-1"></i> Close Auction
                            </button>
                        </form>
                    @endif

                    @if($auction->status === 'pending' && $auction->bids_count == 0)
                        <form method="POST" action="{{ route('staff.auctions.cancel', $auction) }}" 
                              onsubmit="return confirm('Cancel this auction? This action cannot be undone.')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-x me-1"></i> Cancel Auction
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($auction->status === 'open' && $auction->end_time > now())
        const endTime = new Date('{{ $auction->end_time->toISOString() }}').getTime();
        const countdownElement = document.getElementById('countdown');

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                countdownElement.innerHTML = "EXPIRED";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            let displayText = '';
            if (days > 0) displayText += days + "d ";
            if (hours > 0) displayText += hours + "h ";
            displayText += minutes + "m " + seconds + "s";

            countdownElement.innerHTML = displayText;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    @endif
});
</script>
@endpush
