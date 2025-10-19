@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="bi bi-buildings"></i> My Properties</h2>
            <p class="text-muted">
                <i class="bi bi-info-circle"></i> Manage your properties and their rooms
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('owner.properties.create') }}" class="btn btn-success btn-lg shadow-lg hover-lift">
                <i class="bi bi-plus-circle-fill"></i> Add New Property
            </a>
        </div>
    </div>

    <div class="row">
        @forelse($properties as $property)
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-md hover-lift">
                    <div class="card-header border-0 text-white" style="background: var(--primary-gradient);">
                        <h4 class="mb-0">
                            <i class="bi bi-house-door-fill"></i> {{ $property->name }}
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3 p-3 rounded" style="background: #f8f9fa;">
                            <p class="mb-2">
                                <i class="bi bi-geo-alt-fill text-danger"></i>
                                <strong>Address:</strong> {{ $property->address }}
                            </p>
                            <p class="mb-0">
                                <i class="bi bi-door-open-fill text-primary"></i>
                                <strong>Rooms:</strong>
                                <span class="badge bg-primary">{{ $property->rooms->count() }}</span>
                            </p>
                        </div>
                        @if($property->description)
                            <div class="p-3 rounded" style="background: #f8f9fa; border-left: 4px solid var(--bs-primary);">
                                <i class="bi bi-journal-text text-muted"></i>
                                <small class="text-muted d-block">{{ Str::limit($property->description, 100) }}</small>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-light border-0">
                        <a href="{{ route('owner.properties.show', $property) }}" class="btn btn-sm btn-info shadow-sm">
                            <i class="bi bi-eye-fill"></i> View Details
                        </a>
                        <a href="{{ route('owner.properties.edit', $property) }}" class="btn btn-sm btn-warning shadow-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('owner.properties.destroy', $property) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('⚠️ Are you sure you want to delete this property?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                <i class="bi bi-trash-fill"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="card border-0 shadow-lg text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-building-add" style="font-size: 5rem; opacity: 0.3;"></i>
                        <h3 class="mt-4 mb-3">No Properties Yet</h3>
                        <p class="text-muted mb-4">
                            <i class="bi bi-info-circle"></i> You haven't added any properties yet. Get started by adding your first property!
                        </p>
                        <a href="{{ route('owner.properties.create') }}" class="btn btn-success btn-lg">
                            <i class="bi bi-plus-circle-fill"></i> Add Your First Property
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
