@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-person-gear me-2"></i>Edit User</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary me-2">
            <i class="bi bi-arrow-left me-1"></i> Back to Details
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-list me-1"></i> All Users
        </a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <h6><i class="bi bi-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-person-gear me-2"></i>Edit User Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username', $user->username) }}" 
                                   required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" 
                                   class="form-control @error('phone_number') is-invalid @enderror" 
                                   id="phone_number" 
                                   name="phone_number" 
                                   value="{{ old('phone_number', $user->phone_number) }}">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" 
                                    id="role" 
                                    name="role" 
                                    required>
                                <option value="">Select Role</option>
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                                <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="">Select Status</option>
                                <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="suspended" {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Admin Notes</label>
                        <textarea class="form-control @error('admin_notes') is-invalid @enderror" 
                                  id="admin_notes" 
                                  name="admin_notes" 
                                  rows="3" 
                                  placeholder="Optional notes about this user">{{ old('admin_notes', $user->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Current User Info -->
        <div class="table-card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Current Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-2 text-center mb-3">
                    <div class="col-6">
                        <div class="bg-light rounded p-2">
                            <strong>{{ ucfirst($user->role) }}</strong><br>
                            <small class="text-muted">Current Role</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded p-2">
                            @php
                                $statusColors = [
                                    'active' => 'success',
                                    'suspended' => 'warning',
                                    'inactive' => 'secondary'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$user->status] ?? 'secondary' }}">
                                {{ ucfirst($user->status) }}
                            </span><br>
                            <small class="text-muted">Current Status</small>
                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <small class="text-muted">
                        <strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}<br>
                        <strong>Last Login:</strong> {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                    </small>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="table-card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick Actions</h6>
            </div>
            <div class="card-body">
                @if($user->status === 'active')
                    <form method="POST" action="{{ route('admin.users.suspend', $user) }}" class="mb-2">
                        @csrf
                        <input type="hidden" name="reason" value="Suspended by admin via edit page">
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
                        <small><i class="bi bi-exclamation-triangle me-1"></i> You cannot deactivate your own account.</small>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Edit Guidelines -->
        <div class="table-card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-shield-check me-2"></i>Edit Guidelines</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        Leave password blank to keep current
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        Role changes take effect immediately
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        Status changes affect login access
                    </li>
                    <li class="mb-0">
                        <i class="bi bi-check text-success me-2"></i>
                        Admin notes are visible to all admins
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
