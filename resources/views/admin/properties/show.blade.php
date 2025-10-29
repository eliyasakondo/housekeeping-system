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
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-door-open"></i> Rooms & Tasks Management</h5>
            <div>
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                    <i class="bi bi-plus-circle"></i> Add Room
                </button>
                <form action="{{ route('admin.properties.rooms.add-defaults', $property) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="bi bi-lightning-fill"></i> Quick Add Default Rooms
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if($property->rooms->count() > 0)
                @foreach($property->rooms as $room)
                    <div class="card mb-3 border-start border-primary border-3">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <i class="bi bi-door-closed-fill text-primary"></i> {{ $room->name }}
                                @if($room->is_default)
                                    <span class="badge bg-primary">Default</span>
                                @endif
                                <small class="text-muted">(Min. Photos: {{ $room->min_photos }})</small>
                            </h6>
                            <form action="{{ route('admin.properties.rooms.destroy', [$property, $room]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this room?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Delete Room
                                </button>
                            </form>
                        </div>
                        <div class="card-body">
                            <h6 class="text-muted mb-3">
                                <i class="bi bi-list-task"></i> Assigned Tasks ({{ $room->tasks->count() }})
                            </h6>
                            
                            @if($room->tasks->count() > 0)
                                <div class="row">
                                    @foreach($room->tasks as $task)
                                        <div class="col-md-6 mb-2">
                                            <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                <span>
                                                    <i class="bi bi-check-circle text-success"></i> {{ $task->name }}
                                                    @if($task->is_default)
                                                        <span class="badge bg-secondary badge-sm">Global</span>
                                                    @endif
                                                </span>
                                                <form action="{{ route('admin.properties.rooms.detach-task', [$property, $room, $task]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mb-3">No tasks assigned to this room yet.</p>
                            @endif

                            <!-- Add Task Form -->
                            <form action="{{ route('admin.properties.rooms.attach-task', [$property, $room]) }}" method="POST" class="mt-3">
                                @csrf
                                <div class="input-group">
                                    <select name="task_id" class="form-select" required>
                                        <option value="">-- Select a task to add --</option>
                                        @foreach($availableTasks as $task)
                                            <option value="{{ $task->id }}">
                                                {{ $task->name }}
                                                @if($task->is_default)
                                                    (Global Task)
                                                @else
                                                    (Owner's Task)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-plus"></i> Add Task
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    <i class="bi bi-door-open" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-2">No rooms added yet. Click "Add Room" or "Quick Add Default Rooms" to get started.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.properties.rooms.store', $property) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="room_name" class="form-label">Room Name *</label>
                            <input type="text" class="form-control" id="room_name" name="name" required placeholder="e.g., Master Bedroom">
                        </div>
                        <div class="mb-3">
                            <label for="min_photos" class="form-label">Minimum Photos Required *</label>
                            <input type="number" class="form-control" id="min_photos" name="min_photos" value="8" min="1" max="50" required>
                            <small class="text-muted">Housekeepers must upload at least this many photos for this room.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Add Room
                        </button>
                    </div>
                </form>
            </div>
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
