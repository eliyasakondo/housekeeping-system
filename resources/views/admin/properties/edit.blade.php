@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary mb-2">
            <i class="bi bi-arrow-left"></i> Back to Properties
        </a>
        <h1><i class="bi bi-pencil-square"></i> Edit Property: {{ $property->name }}</h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.properties.update', $property) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="owner_id" class="form-label">Owner <span class="text-danger">*</span></label>
                            <select class="form-select @error('owner_id') is-invalid @enderror" 
                                    id="owner_id" 
                                    name="owner_id" 
                                    required>
                                <option value="">Select Owner...</option>
                                @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}" 
                                            {{ (old('owner_id', $property->owner_id) == $owner->id) ? 'selected' : '' }}>
                                        {{ $owner->name }} ({{ $owner->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('owner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Change property owner (use carefully!)</small>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Property Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $property->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="3" 
                                      required>{{ old('address', $property->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="beds" class="form-label">Bedrooms <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           class="form-control @error('beds') is-invalid @enderror" 
                                           id="beds" 
                                           name="beds" 
                                           value="{{ old('beds', $property->beds) }}" 
                                           min="0" 
                                           required>
                                    @error('beds')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="baths" class="form-label">Bathrooms <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           class="form-control @error('baths') is-invalid @enderror" 
                                           id="baths" 
                                           name="baths" 
                                           value="{{ old('baths', $property->baths) }}" 
                                           min="0" 
                                           required>
                                    @error('baths')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">GPS Coordinates (Optional)</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="number" 
                                           class="form-control @error('latitude') is-invalid @enderror" 
                                           name="latitude" 
                                           value="{{ old('latitude', $property->latitude) }}" 
                                           step="0.000001"
                                           placeholder="Latitude">
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="number" 
                                           class="form-control @error('longitude') is-invalid @enderror" 
                                           name="longitude" 
                                           value="{{ old('longitude', $property->longitude) }}" 
                                           step="0.000001"
                                           placeholder="Longitude">
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <small class="text-muted">Used for GPS verification</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Property
                            </button>
                            <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-info-circle"></i> Property Info</h5>
                    <ul class="list-unstyled">
                        <li><strong>ID:</strong> #{{ $property->id }}</li>
                        <li><strong>Created:</strong> {{ $property->created_at->format('M d, Y') }}</li>
                        <li><strong>Rooms:</strong> {{ $property->rooms()->count() }}</li>
                        <li><strong>Checklists:</strong> {{ $property->checklists()->count() }}</li>
                    </ul>
                </div>
            </div>

            <div class="card bg-warning bg-opacity-10 mt-3">
                <div class="card-body">
                    <h6 class="card-title"><i class="bi bi-exclamation-triangle"></i> Warning</h6>
                    <p class="mb-0 small">Changing the owner will transfer all property management rights to the new owner.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
