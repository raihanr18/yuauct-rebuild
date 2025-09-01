@extends('layouts.admin')

@section('title', 'Edit Item')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-pencil me-2"></i>Edit Item</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('staff.items.index') }}">Items</a></li>
                <li class="breadcrumb-item"><a href="{{ route('staff.items.show', $item) }}">{{ $item->name }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('staff.items.show', $item) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Details
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
                <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Item Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('staff.items.update', $item) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Item Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $item->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id" 
                                    required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  required>{{ old('description', $item->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="start_price" class="form-label">Starting Price (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" 
                                   class="form-control @error('start_price') is-invalid @enderror" 
                                   id="start_price" 
                                   name="start_price" 
                                   value="{{ old('start_price', $item->start_price) }}" 
                                   min="1000" 
                                   step="1000" 
                                   required>
                        </div>
                        @error('start_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimum starting price is Rp 1,000</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Item Image</label>
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   onchange="previewImage(this)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Supported formats: JPG, PNG, GIF. Max size: 2MB</div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Current/Preview Image</label>
                            <div class="border rounded p-2">
                                @if($item->image)
                                    <img id="preview" 
                                         src="{{ asset('storage/' . $item->image) }}" 
                                         alt="Current image" 
                                         class="img-fluid rounded"
                                         style="max-height: 200px; width: 100%; object-fit: cover;">
                                @else
                                    <div id="preview" 
                                         class="bg-light rounded d-flex align-items-center justify-content-center"
                                         style="height: 200px;">
                                        <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Update Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Item Status Warning -->
        @php
            $activeAuction = $item->auctions->where('status', 'open')->first();
            $pendingAuction = $item->auctions->where('status', 'pending')->first();
        @endphp
        
        @if($activeAuction || $pendingAuction)
            <div class="table-card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Editing Restrictions</h6>
                </div>
                <div class="card-body">
                    @if($activeAuction)
                        <div class="alert alert-warning mb-0">
                            <h6 class="alert-heading">Item in Active Auction</h6>
                            <p class="mb-1">This item is currently being auctioned.</p>
                            <small>Some changes may affect the ongoing auction. Edit carefully!</small>
                        </div>
                    @elseif($pendingAuction)
                        <div class="alert alert-info mb-0">
                            <h6 class="alert-heading">Auction Scheduled</h6>
                            <p class="mb-1">This item has a scheduled auction.</p>
                            <small>Changes will apply before the auction starts.</small>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        
        <!-- Edit Guidelines -->
        <div class="table-card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Edit Guidelines</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        Use clear, descriptive item names
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        Provide detailed descriptions
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        Set competitive starting prices
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        Upload high-quality images
                    </li>
                    <li class="mb-0">
                        <i class="bi bi-check text-success me-2"></i>
                        Select appropriate categories
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Current Item Stats -->
        <div class="table-card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Current Stats</h6>
            </div>
            <div class="card-body">
                <div class="row g-2 text-center">
                    <div class="col-12 mb-2">
                        <div class="bg-light rounded p-2">
                            <strong>{{ $item->formatted_start_price }}</strong><br>
                            <small class="text-muted">Current Starting Price</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded p-2">
                            <strong>{{ $item->auctions->count() }}</strong><br>
                            <small class="text-muted">Auctions</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded p-2">
                            <strong>{{ $item->created_at->diffForHumans() }}</strong><br>
                            <small class="text-muted">Added</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" 
                     alt="Preview" 
                     class="img-fluid rounded"
                     style="max-height: 200px; width: 100%; object-fit: cover;">
            `;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Format price input with thousand separators
document.getElementById('start_price').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^\d]/g, '');
    if (value) {
        e.target.value = parseInt(value);
    }
});

// Auto-resize textarea
document.getElementById('description').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});
</script>
@endsection
