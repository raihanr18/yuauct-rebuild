@extends('layouts.admin')

@section('title', 'Add New Item')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-plus-circle me-2"></i>Add New Item</h2>
    <a href="{{ route('staff.items.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Items
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-box me-2"></i>Item Details</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('staff.items.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Item Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Enter item name..."
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Choose a category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="4"
                                  placeholder="Provide detailed description of the item..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="start_price" class="form-label">Starting Price <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" 
                                   name="start_price" 
                                   id="start_price" 
                                   class="form-control @error('start_price') is-invalid @enderror"
                                   value="{{ old('start_price') }}"
                                   min="1000"
                                   step="1000"
                                   placeholder="0"
                                   required>
                        </div>
                        @error('start_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimum starting price is Rp 1,000</div>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">Item Image</label>
                        <input type="file" 
                               name="image" 
                               id="image" 
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/*"
                               onchange="previewImage(this)">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Supported formats: JPG, PNG, GIF. Maximum size: 2MB.
                        </div>
                        
                        <!-- Image Preview -->
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <label class="form-label">Preview:</label>
                            <div>
                                <img id="preview" src="" alt="Preview" class="rounded" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('staff.items.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Save Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="table-card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Item Guidelines</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Name:</strong> Use clear, descriptive names
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Category:</strong> Choose the most appropriate category
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Description:</strong> Include condition, age, material, etc.
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Price:</strong> Set competitive starting price
                    </li>
                    <li class="mb-0">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Image:</strong> High-quality photos increase interest
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Pro Tips</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0 small">
                    <li class="mb-2">• Take photos in good lighting</li>
                    <li class="mb-2">• Show multiple angles if possible</li>
                    <li class="mb-2">• Mention any defects or wear</li>
                    <li class="mb-2">• Research similar items for pricing</li>
                    <li class="mb-0">• Include provenance or history if available</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Format price input
    const priceInput = document.getElementById('start_price');
    
    priceInput.addEventListener('input', function() {
        // Remove non-numeric characters except for decimal point
        let value = this.value.replace(/[^\d]/g, '');
        
        // Ensure minimum value
        if (value && parseInt(value) < 1000) {
            value = '1000';
        }
        
        this.value = value;
    });
});
</script>
@endpush
