@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Admin Dashboard</h1>
            <div class="text-muted">
                <i class="bi bi-clock"></i>
                {{ $systemHealth['server_time'] }}
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards Row -->
<div class="row g-4 mb-4">
    <!-- User Stats -->
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Users</h6>
                    <h3 class="mb-0">{{ number_format($userStats['total']) }}</h3>
                    <small class="text-success">
                        <i class="bi bi-arrow-up"></i>
                        +{{ $userStats['new_this_month'] }} this month
                    </small>
                </div>
                <div class="stats-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Auctions -->
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Active Auctions</h6>
                    <h3 class="mb-0">{{ number_format($auctionStats['active']) }}</h3>
                    <small class="text-info">
                        {{ $auctionStats['total'] }} total auctions
                    </small>
                </div>
                <div class="stats-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="bi bi-hammer"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Bids -->
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Bids</h6>
                    <h3 class="mb-0">{{ number_format($revenueStats['total_bids']) }}</h3>
                    <small class="text-warning">
                        +{{ $revenueStats['this_month_bids'] }} this month
                    </small>
                </div>
                <div class="stats-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- System Health -->
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">System Status</h6>
                    <h3 class="mb-0 text-success">
                        @if($systemHealth['database_connection'] === 'Connected')
                            <i class="bi bi-check-circle"></i>
                        @else
                            <i class="bi bi-x-circle text-danger"></i>
                        @endif
                    </h3>
                    <small class="text-muted">
                        Laravel {{ $systemHealth['laravel_version'] }}
                    </small>
                </div>
                <div class="stats-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <i class="bi bi-gear"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row g-4">
    <!-- User Role Distribution -->
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="table-card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>User Role Distribution</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach(['admin' => 'danger', 'staff' => 'warning', 'user' => 'primary'] as $role => $color)
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-capitalize fw-medium">{{ $role }}s</span>
                                <span class="badge bg-{{ $color }} rounded-pill">
                                    {{ $roleStats[$role] ?? 0 }}
                                </span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-{{ $color }}" 
                                     style="width: {{ $userStats['total'] > 0 ? (($roleStats[$role] ?? 0) / $userStats['total']) * 100 : 0 }}%"
                                     aria-valuenow="{{ $roleStats[$role] ?? 0 }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="{{ $userStats['total'] }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="table-card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-people me-2"></i>Recent Users</h5>
            </div>
            <div class="card-body p-0">
                @if($recentUsers->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentUsers as $user)
                            <div class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1 me-3">
                                    <h6 class="mb-1 fw-medium text-truncate" style="max-width: 150px;" title="{{ $user->name }}">{{ $user->name }}</h6>
                                    <small class="text-muted text-truncate d-block" style="max-width: 180px;" title="{{ $user->email }}">{{ $user->email }}</small>
                                </div>
                                <div class="text-end flex-shrink-0">
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'staff' ? 'warning' : 'primary') }} mb-1">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <br>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-people text-muted mb-2" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0">No recent users</p>
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary w-100">
                    <i class="bi bi-arrow-right me-1"></i> View All Users
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-xl-4 col-lg-12 col-md-12">
        <div class="table-card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-activity me-2"></i>Recent Bids</h5>
            </div>
            <div class="card-body p-0">
                @if($recentBids->count() > 0)
                    <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                        @foreach($recentBids->take(5) as $bid)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1 me-3">
                                        <h6 class="mb-1 fw-medium text-truncate" style="max-width: 150px;" title="{{ $bid->user->name }}">{{ $bid->user->name }}</h6>
                                        <p class="mb-1 small text-muted text-truncate" style="max-width: 180px;" title="{{ $bid->auction->item->name }}">{{ $bid->auction->item->name }}</p>
                                        <small class="text-muted">{{ $bid->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <span class="badge bg-success rounded-pill mb-1">
                                            Rp {{ number_format($bid->bid_amount / 1000) }}k
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-currency-dollar text-muted mb-2" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0">No recent bids</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- System Information -->
<div class="row mt-4">
    <div class="col-12">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>System Information</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="system-info-item">
                            <div class="me-3">
                                <i class="bi bi-code-square text-primary" style="font-size: 1.5rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <strong class="d-block">Laravel Version</strong>
                                <span class="text-muted">{{ $systemHealth['laravel_version'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="system-info-item">
                            <div class="me-3">
                                <i class="bi bi-gear text-info" style="font-size: 1.5rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <strong class="d-block">PHP Version</strong>
                                <span class="text-muted">{{ $systemHealth['php_version'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="system-info-item">
                            <div class="me-3">
                                <i class="bi bi-database text-warning" style="font-size: 1.5rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <strong class="d-block">Database</strong>
                                <span class="text-{{ $systemHealth['database_connection'] === 'Connected' ? 'success' : 'danger' }}">
                                    <i class="bi bi-{{ $systemHealth['database_connection'] === 'Connected' ? 'check-circle' : 'x-circle' }}"></i>
                                    {{ $systemHealth['database_connection'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="system-info-item">
                            <div class="me-3">
                                <i class="bi bi-clock text-secondary" style="font-size: 1.5rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <strong class="d-block">Server Time</strong>
                                <span class="text-muted small" title="{{ $systemHealth['server_time'] }}">{{ Str::limit($systemHealth['server_time'], 20) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
