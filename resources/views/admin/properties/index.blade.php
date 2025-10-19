@extends('layouts.app')

@section('title')
    @php
        $appName = config('app.name', 'HK Checklist');
        if (Storage::disk('local')->exists('settings.json')) {
            $settings = json_decode(Storage::disk('local')->get('settings.json'), true);
            $appName = $settings['app_name'] ?? $appName;
        }
    @endphp
    Properties - {{ $appName }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-building"></i> All Properties</h1>
        <a href="{{ route('admin.properties.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Property
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.properties.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Property name or address..." value="{{ request('search') }}">
                </div>
                
                <div class="col-md-4">
                    <label for="owner_id" class="form-label">Owner</label>
                    <select class="form-select" id="owner_id" name="owner_id">
                        <option value="">All Owners</option>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}" {{ request('owner_id') == $owner->id ? 'selected' : '' }}>
                                {{ $owner->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'owner_id']))
                        <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Results Summary -->
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Showing <strong>{{ $properties->total() }}</strong> propert{{ $properties->total() == 1 ? 'y' : 'ies' }}
    </div>

    <!-- Properties Table -->
    <div class="card">
        <div class="card-body">
            @if($properties->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Owner</th>
                                <th>Address</th>
                                <th>Beds/Baths</th>
                                <th>Rooms</th>
                                <th>Checklists</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($properties as $property)
                                <tr>
                                    <td><strong>#{{ $property->id }}</strong></td>
                                    <td>
                                        <i class="bi bi-building-fill text-primary"></i>
                                        <strong>{{ $property->name }}</strong>
                                    </td>
                                    <td>
                                        <i class="bi bi-person-fill"></i>
                                        {{ $property->owner->name }}
                                        <br>
                                        <small class="text-muted">{{ $property->owner->email }}</small>
                                    </td>
                                    <td>
                                        <small>{{ $property->address }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-house-door"></i> {{ $property->beds }} beds
                                        </span>
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-droplet"></i> {{ $property->baths }} baths
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">
                                            {{ $property->rooms_count }} rooms
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">
                                            {{ $property->checklists_count }} checklists
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.properties.show', $property) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.properties.edit', $property) }}" 
                                               class="btn btn-sm btn-warning" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.properties.destroy', $property) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this property? This will also delete all its rooms.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $properties->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-building display-1 text-muted"></i>
                    <p class="mt-3 text-muted">No properties found</p>
                    @if(request()->hasAny(['search', 'owner_id']))
                        <a href="{{ route('admin.properties.index') }}" class="btn btn-primary">
                            Clear Filters
                        </a>
                    @else
                        <a href="{{ route('admin.properties.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add Your First Property
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
