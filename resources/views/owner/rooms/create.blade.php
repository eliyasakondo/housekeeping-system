@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="bi bi-door-open"></i> Add Room to {{ $property->name }}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('owner.rooms.store', $property) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Room Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="e.g., Master Bedroom, Living Room, Kitchen" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Optional details about this room">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">e.g., "King bed with ocean view", "Fully equipped kitchen"</small>
                        </div>

                        <div class="mb-3">
                            <label for="min_photos" class="form-label">Minimum Photos Required *</label>
                            <input type="number" class="form-control @error('min_photos') is-invalid @enderror" 
                                   id="min_photos" name="min_photos" value="{{ old('min_photos', 8) }}" 
                                   min="1" max="50" required>
                            @error('min_photos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Housekeepers must upload at least this many photos for this room (recommended: 8)</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> <strong>Tip:</strong> Standard room types include:
                            Bedroom, Living Room, Kitchen, Bathroom, Dining Room, Office, Garage, Patio/Deck
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('owner.rooms.index', $property) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Add Room
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
