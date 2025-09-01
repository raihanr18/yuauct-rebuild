@extends('layouts.admin')

@section('title', 'User Management')

@section('breadcrumb')
    <li class="breadcrumb-item active">User Management</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">User Management</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-admin">
                <i class="bi bi-plus-circle"></i> Add New User
            </a>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="table-card">
            <div class="card-header">
                <h6 class="mb-0">Filters & Search</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.users.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" 
                                   value="{{ request('search') }}" 
                                   placeholder="Name, email, or username...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="">All Roles</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date From</label>
                            <input type="date" name="date_from" class="form-control" 
                                   value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date To</label>
                            <input type="date" name="date_to" class="form-control" 
                                   value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary btn-admin">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="row">
    <div class="col-12">
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Users ({{ $users->total() }} total)</h6>
                @if(request()->hasAny(['search', 'role', 'status', 'date_from', 'date_to']))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </a>
                @endif
            </div>
            <div class="card-body p-0">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Contact</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th>Joined</th>
                                    <th width="180">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-primary text-white me-3" 
                                                     style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                                    <small class="text-muted">{{ $user->username }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div>{{ $user->email }}</div>
                                                @if($user->phone_number)
                                                    <small class="text-muted">{{ $user->phone_number }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'staff' ? 'warning' : 'primary') }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->last_login_at)
                                                <span title="{{ $user->last_login_at->format('Y-m-d H:i:s') }}">
                                                    {{ $user->last_login_at->diffForHumans() }}
                                                </span>
                                            @else
                                                <span class="text-muted">Never</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span title="{{ $user->created_at->format('Y-m-d H:i:s') }}">
                                                {{ $user->created_at->diffForHumans() }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.users.show', $user) }}" 
                                                   class="btn btn-outline-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user) }}" 
                                                   class="btn btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                
                                                @if($user->status === 'active')
                                                    <form method="POST" action="{{ route('admin.users.suspend', $user) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-warning" 
                                                                title="Suspend" onclick="return confirm('Suspend this user?')">
                                                            <i class="bi bi-pause"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('admin.users.activate', $user) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success" 
                                                                title="Activate" onclick="return confirm('Activate this user?')">
                                                            <i class="bi bi-play"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                @if($user->id !== auth()->id())
                                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" 
                                                                title="Deactivate" data-confirm-delete>
                                                            <i class="bi bi-trash"></i>
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
                        <i class="bi bi-people display-1 text-muted"></i>
                        <h5 class="mt-3">No users found</h5>
                        <p class="text-muted">Try adjusting your search filters or add a new user.</p>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-admin">
                            <i class="bi bi-plus-circle"></i> Add First User
                        </a>
                    </div>
                @endif
            </div>
            
            @if($users->hasPages())
                <div class="card-footer">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
