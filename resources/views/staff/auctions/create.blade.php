@extends('layouts.admin')

@section('title', 'Create New Auction')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-plus-circle me-2"></i>Create New Auction</h2>
    <a href="{{ route('staff.auctions.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Auctions
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-hammer me-2"></i>Auction Details</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('staff.auctions.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="item_id" class="form-label">Select Item <span class="text-danger">*</span></label>
                        <select name="item_id" id="item_id" class="form-select @error('item_id') is-invalid @enderror" required>
                            <option value="">Choose an item to auction...</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} - {{ $item->formatted_start_price }}
                                </option>
                            @endforeach
                        </select>
                        @error('item_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Only items without active auctions are available for selection.
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" 
                                       name="start_time" 
                                       id="start_time" 
                                       class="form-control @error('start_time') is-invalid @enderror"
                                       value="{{ old('start_time', now()->addHour()->format('Y-m-d\TH:i')) }}"
                                       min="{{ now()->format('Y-m-d\TH:i') }}"
                                       required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" 
                                       name="end_time" 
                                       id="end_time" 
                                       class="form-control @error('end_time') is-invalid @enderror"
                                       value="{{ old('end_time', now()->addDays(7)->format('Y-m-d\TH:i')) }}"
                                       required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Auction Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="4"
                                  placeholder="Add any additional information about this auction...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('staff.auctions.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Create Auction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="table-card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Auction Guidelines</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Start Time:</strong> Must be in the future
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>End Time:</strong> Must be after start time
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Item Selection:</strong> Only items without active auctions
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Status:</strong> Auction will be created as "Pending"
                    </li>
                    <li class="mb-0">
                        <i class="bi bi-info-circle text-info me-2"></i>
                        <strong>Note:</strong> You can start the auction manually later
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Tips</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0 small">
                    <li class="mb-2">• Consider peak hours for better participation</li>
                    <li class="mb-2">• Allow sufficient time for bidding</li>
                    <li class="mb-2">• Check item details before creating auction</li>
                    <li class="mb-0">• Add descriptive auction information</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');

    // Update minimum end time when start time changes
    startTimeInput.addEventListener('change', function() {
        const startTime = new Date(this.value);
        startTime.setHours(startTime.getHours() + 1); // Minimum 1 hour duration
        
        const minEndTime = startTime.toISOString().slice(0, 16);
        endTimeInput.setAttribute('min', minEndTime);
        
        // Update end time if it's before the new minimum
        if (endTimeInput.value && new Date(endTimeInput.value) <= new Date(this.value)) {
            endTimeInput.value = minEndTime;
        }
    });

    // Validate end time
    endTimeInput.addEventListener('change', function() {
        if (startTimeInput.value && new Date(this.value) <= new Date(startTimeInput.value)) {
            alert('End time must be after start time');
            this.focus();
        }
    });
});
</script>
@endpush
