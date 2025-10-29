@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="bi bi-pencil"></i> Edit Property</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('owner.properties.update', $property) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Property Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $property->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="beds" class="form-label">Bedrooms *</label>
                                    <input type="number" class="form-control @error('beds') is-invalid @enderror" 
                                           id="beds" name="beds" value="{{ old('beds', $property->beds) }}" min="0" required>
                                    @error('beds')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="baths" class="form-label">Bathrooms *</label>
                                    <input type="number" class="form-control @error('baths') is-invalid @enderror" 
                                           id="baths" name="baths" value="{{ old('baths', $property->baths) }}" min="0" step="0.5" required>
                                    @error('baths')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address *</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="2" required>{{ old('address', $property->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning border-warning">
                            <h6 class="alert-heading fw-bold mb-2">
                                <i class="bi bi-geo-alt-fill me-2"></i>GPS Location Required for Housekeeper Check-In
                            </h6>
                            <p class="mb-0 small">
                                <strong>MANDATORY:</strong> If you want your housekeepers to verify their location using GPS before starting work, 
                                you <strong>MUST</strong> provide both Latitude and Longitude values for this property. 
                                Without GPS coordinates, housekeepers will not be able to check in at the property location.
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="latitude" class="form-label fw-bold">
                                        <i class="bi bi-geo-alt me-1"></i>Latitude 
                                        <span class="text-danger">(Required for GPS)</span>
                                    </label>
                                    <input type="number" step="0.00000001" class="form-control @error('latitude') is-invalid @enderror" 
                                           id="latitude" name="latitude" value="{{ old('latitude', $property->latitude) }}"
                                           placeholder="e.g., 40.7128">
                                    <small class="text-muted">Example: 40.7128 (New York)</small>
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="longitude" class="form-label fw-bold">
                                        <i class="bi bi-geo-alt me-1"></i>Longitude 
                                        <span class="text-danger">(Required for GPS)</span>
                                    </label>
                                    <input type="number" step="0.00000001" class="form-control @error('longitude') is-invalid @enderror" 
                                           id="longitude" name="longitude" value="{{ old('longitude', $property->longitude) }}"
                                           placeholder="e.g., -74.0060">
                                    <small class="text-muted">Example: -74.0060 (New York)</small>
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mb-3">
                            <small>
                                <i class="bi bi-lightbulb me-1"></i><strong>How to find GPS coordinates:</strong> 
                                Search your property on <a href="https://www.google.com/maps" target="_blank" class="alert-link">Google Maps</a>, 
                                right-click on the location, and select the coordinates to copy them.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $property->description) }}</textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('owner.properties.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Property
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
