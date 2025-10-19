@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary mb-2">
                <i class="bi bi-arrow-left"></i> Back to Properties
            </a>
            <h1><i class="bi bi-building"></i> {{ $property->name }}</h1>
            <p class="text-muted mb-0">
                <i class="bi bi-geo-alt"></i> {{ $property->address }}
            </p>
        </div>
        <div>
            <a href="{{ route('admin.properties.edit', $property) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit Property
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted"><i class="bi bi-person-fill"></i> Owner</h6>
                    <h4>{{ $property->owner->name }}</h4>
                    <small class="text-muted">{{ $property->owner->email }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted"><i class="bi bi-house-door"></i> Beds/Baths</h6>
                    <h4>{{ $property->beds }}/{{ $property->baths }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted"><i class="bi bi-door-open"></i> Rooms</h6>
                    <h4>{{ $stats['total_rooms'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted"><i class="bi bi-clipboard-check"></i> Total Checklists</h6>
                    <h4>{{ $stats['total_checklists'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted"><i class="bi bi-graph-up"></i> Status</h6>
                    <div class="d-flex gap-2">
                        <span class="badge bg-warning">{{ $stats['pending_checklists'] }} pending</span>
                        <span class="badge bg-info">{{ $stats['in_progress_checklists'] }} active</span>
                        <span class="badge bg-success">{{ $stats['completed_checklists'] }} done</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GPS Info -->
    @if($property->latitude && $property->longitude)
        <div class="alert alert-info">
            <i class="bi bi-geo-alt-fill"></i> 
            <strong>GPS Coordinates:</strong> {{ $property->latitude }}, {{ $property->longitude }}
            <small class="ms-2">(Used for location verification)</small>
        </div>
    @endif

    <!-- Rooms List -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-door-open"></i> Rooms ({{ $property->rooms->count() }})</h5>
        </div>
        <div class="card-body">
            @if($property->rooms->count() > 0)
                <div class="row">
                    @foreach($property->rooms as $room)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6>
                                        <i class="bi bi-door-closed-fill"></i> {{ $room->name }}
                                        @if($room->is_default)
                                            <span class="badge bg-primary badge-sm">Default</span>
                                        @endif
                                    </h6>
                                    <small class="text-muted">
                                        Min. Photos: {{ $room->min_photos }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted text-center py-4">No rooms added yet</p>
            @endif
        </div>
    </div>

    <!-- Recent Checklists -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> Recent Checklists</h5>
        </div>
        <div class="card-body">
            @if($property->checklists->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Housekeeper</th>
                                <th>Status</th>
                                <th>Scheduled</th>
                                <th>Started</th>
                                <th>Completed</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($property->checklists as $checklist)
                                <tr>
                                    <td><strong>#{{ $checklist->id }}</strong></td>
                                    <td>
                                        <i class="bi bi-person"></i> {{ $checklist->housekeeper->name }}
                                    </td>
                                    <td>
                                        @if($checklist->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($checklist->status == 'in_progress')
                                            <span class="badge bg-info">In Progress</span>
                                        @else
                                            <span class="badge bg-success">Completed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $checklist->scheduled_date->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        @if($checklist->started_at)
                                            <small>{{ $checklist->started_at->format('M d, H:i') }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($checklist->completed_at)
                                            <small>{{ $checklist->completed_at->format('M d, H:i') }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.checklists.show', $checklist) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($stats['total_checklists'] > 10)
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.checklists.index', ['property_id' => $property->id]) }}" 
                           class="btn btn-outline-primary">
                            <i class="bi bi-eye"></i> View All {{ $stats['total_checklists'] }} Checklists
                        </a>
                    </div>
                @endif
            @else
                <p class="text-muted text-center py-4">No checklists yet</p>
            @endif
        </div>
    </div>
</div>
@endsection
