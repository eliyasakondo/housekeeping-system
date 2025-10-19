@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary mb-2">
            <i class="bi bi-arrow-left"></i> Back to Properties
        </a>
        <h1><i class="bi bi-building-add"></i> Add New Property</h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.properties.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="owner_id" class="form-label">Owner <span class="text-danger">*</span></label>
                            <select class="form-select @error('owner_id') is-invalid @enderror" 
                                    id="owner_id" 
                                    name="owner_id" 
                                    required>
                                <option value="">Select Owner...</option>
                                @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                                        {{ $owner->name }} ({{ $owner->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('owner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Select which owner will manage this property</small>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Property Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required
                                   placeholder="e.g., Sunset Villa, Downtown Apartment">
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
                                      required
                                      placeholder="Enter full address">{{ old('address') }}</textarea>
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
                                           value="{{ old('beds', 0) }}" 
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
                                           value="{{ old('baths', 0) }}" 
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
                                           value="{{ old('latitude') }}" 
                                           step="0.000001"
                                           placeholder="Latitude (e.g., 37.7749)">
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="number" 
                                           class="form-control @error('longitude') is-invalid @enderror" 
                                           name="longitude" 
                                           value="{{ old('longitude') }}" 
                                           step="0.000001"
                                           placeholder="Longitude (e.g., -122.4194)">
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <small class="text-muted">Used for GPS verification when housekeepers start checklists</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Create Property
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
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-info-circle"></i> Tips</h5>
                    <ul class="mb-0">
                        <li>Select the owner who will manage this property</li>
                        <li>Provide accurate GPS coordinates for location verification</li>
                        <li>After creating, you can add rooms to this property</li>
                        <li>Owner will be able to manage rooms and assign housekeepers</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
