@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-person me-2"></i>User Details</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">{{ $user->name }}</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary me-2">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit User
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- User Information -->
    <div class="col-lg-8">
        <div class="table-card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>User Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="mb-3">{{ $user->name }}</h3>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Username</h6>
                            <p class="mb-0">{{ $user->username }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Email Address</h6>
                            <p class="mb-0">
                                {{ $user->email }}
                                @if($user->email_verified_at)
                                    <span class="badge bg-success ms-2">Verified</span>
                                @else
                                    <span class="badge bg-warning ms-2">Unverified</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Phone Number</h6>
                            <p class="mb-0">{{ $user->phone_number ?? 'Not provided' }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Role</h6>
                            @php
                                $roleColors = [
                                    'user' => 'primary',
                                    'staff' => 'warning',
                                    'admin' => 'danger'
                                ];
                            @endphp
                            <span class="badge bg-{{ $roleColors[$user->role] ?? 'secondary' }} fs-6">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Status</h6>
                            @php
                                $statusColors = [
                                    'active' => 'success',
                                    'suspended' => 'warning',
                                    'inactive' => 'secondary'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$user->status] ?? 'secondary' }} fs-6">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Join Date</h6>
                            <p class="mb-0">{{ $user->created_at->format('M d, Y') }}</p>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Last Login</h6>
                            <p class="mb-0">
                                @if($user->last_login_at)
                                    {{ $user->last_login_at->format('M d, Y H:i') }}
                                    <br><small class="text-muted">{{ $user->last_login_at->diffForHumans() }}</small>
                                @else
                                    <span class="text-muted">Never logged in</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                @if($user->admin_notes)
                    <hr>
                    <div>
                        <h6 class="text-muted mb-2">Admin Notes</h6>
                        <div class="bg-light rounded p-3">
                            <p class="mb-0">{{ $user->admin_notes }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Activity Information -->
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-activity me-2"></i>Activity Summary</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4 text-center">
                        <div class="border rounded p-3">
                            <h4 class="mb-1 text-primary">{{ $user->bids->count() ?? 0 }}</h4>
                            <small class="text-muted">Total Bids</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4 text-center">
                        <div class="border rounded p-3">
                            <h4 class="mb-1 text-success">{{ $user->wonAuctions->count() ?? 0 }}</h4>
                            <small class="text-muted">Auctions Won</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4 text-center">
                        <div class="border rounded p-3">
                            <h4 class="mb-1 text-warning">{{ $user->managedAuctions->count() ?? 0 }}</h4>
                            <small class="text-muted">Managed Auctions</small>
                        </div>
                    </div>
                </div>

                @if($user->role === 'user' && $user->bids->count() > 0)
                    <hr>
                    <h6 class="mb-3">Recent Bidding Activity</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Auction</th>
                                    <th>Bid Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->bids->take(5) as $bid)
                                    <tr>
                                        <td>{{ $bid->auction->item->name ?? 'N/A' }}</td>
                                        <td>Rp {{ number_format($bid->amount, 0, ',', '.') }}</td>
                                        <td>{{ $bid->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($bid->auction->winner_id === $user->id)
                                                <span class="badge bg-success">Won</span>
                                            @elseif($bid->auction->status === 'closed')
                                                <span class="badge bg-secondary">Lost</span>
                                            @else
                                                <span class="badge bg-primary">Active</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if(in_array($user->role, ['staff', 'admin']) && $user->managedAuctions->count() > 0)
                    <hr>
                    <h6 class="mb-3">Recent Managed Auctions</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>Final Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->managedAuctions->take(5) as $auction)
                                    <tr>
                                        <td>{{ $auction->item->name ?? 'N/A' }}</td>
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
                                        <td>{{ $auction->start_time->format('M d, Y') }}</td>
                                        <td>
                                            @if($auction->final_price)
                                                Rp {{ number_format($auction->final_price, 0, ',', '.') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- User Actions Sidebar -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="table-card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-gear me-2"></i>User Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-pencil me-1"></i> Edit User
                </a>
                
                @if($user->status === 'active')
                    <form method="POST" action="{{ route('admin.users.suspend', $user) }}" class="mb-2">
                        @csrf
                        <div class="mb-2">
                            <input type="text" name="reason" class="form-control form-control-sm" 
                                   placeholder="Suspension reason" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100" 
                                onclick="return confirm('Suspend this user?')">
                            <i class="bi bi-pause-circle me-1"></i> Suspend User
                        </button>
                    </form>
                @elseif($user->status === 'suspended')
                    <form method="POST" action="{{ route('admin.users.activate', $user) }}" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-play-circle me-1"></i> Activate User
                        </button>
                    </form>
                @endif
                
                @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100" 
                                onclick="return confirm('Deactivate this user account? This will mark the account as inactive.')">
                            <i class="bi bi-person-x me-1"></i> Deactivate Account
                        </button>
                    </form>
                @else
                    <div class="alert alert-warning mb-0">
                        <small><i class="bi bi-exclamation-triangle me-1"></i> Cannot deactivate your own account</small>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- User Statistics -->
        <div class="table-card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>User Statistics</h6>
            </div>
            <div class="card-body">
                <div class="row g-2 text-center">
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <h6 class="mb-1 text-primary">{{ $user->created_at->diffInDays() }}</h6>
                            <small class="text-muted">Days as Member</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <h6 class="mb-1 text-success">
                                @if($user->last_login_at)
                                    {{ $user->last_login_at->diffInDays() }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </h6>
                            <small class="text-muted">Days Since Login</small>
                        </div>
                    </div>
                </div>
                
                @if($user->role === 'user')
                    <div class="mt-3 text-center">
                        <div class="border rounded p-2">
                            <h6 class="mb-1 text-info">
                                @php
                                    $totalSpent = $user->wonAuctions->sum('final_price');
                                @endphp
                                Rp {{ number_format($totalSpent, 0, ',', '.') }}
                            </h6>
                            <small class="text-muted">Total Spent</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
