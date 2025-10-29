@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="gradient-text">
                <i class="bi bi-building-fill"></i> {{ $property->name }}
            </h2>
            <p class="text-muted mb-0">
                <i class="bi bi-geo-alt-fill"></i> {{ $property->address }}
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('owner.properties.edit', $property) }}" class="btn btn-warning">
                <i class="bi bi-pencil-fill"></i> Edit Property
            </a>
            <a href="{{ route('owner.properties.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Property Info Card --}}
        <div class="col-md-4 mb-4">
            <div class="card gradient-card-primary h-100">
                <div class="card-body">
                    <h5 class="card-title text-white mb-4">
                        <i class="bi bi-info-circle-fill"></i> Property Details
                    </h5>
                    
                    <div class="property-stat mb-3">
                        <i class="bi bi-door-closed-fill"></i>
                        <span class="stat-label">Bedrooms:</span>
                        <span class="stat-value">{{ $property->beds }}</span>
                    </div>
                    
                    <div class="property-stat mb-3">
                        <i class="bi bi-droplet-fill"></i>
                        <span class="stat-label">Bathrooms:</span>
                        <span class="stat-value">{{ $property->baths }}</span>
                    </div>
                    
                    <div class="property-stat mb-3">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                        <span class="stat-label">Total Rooms:</span>
                        <span class="stat-value">{{ $property->rooms->count() }}</span>
                    </div>

                    @if($property->description)
                        <div class="mt-4 pt-3 border-top border-white-20">
                            <h6 class="text-white mb-2">
                                <i class="bi bi-file-text"></i> Description
                            </h6>
                            <p class="text-white-80 small mb-0">{{ $property->description }}</p>
                        </div>
                    @endif

                    @if($property->latitude && $property->longitude)
                        <div class="mt-3 pt-3 border-top border-white-20">
                            <h6 class="text-white mb-2">
                                <i class="bi bi-geo-alt-fill"></i> GPS Coordinates
                            </h6>
                            <p class="text-white-80 small mb-0">
                                {{ round($property->latitude, 6) }}, {{ round($property->longitude, 6) }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Rooms & Tasks Management --}}
        <div class="col-md-8">
            <div class="card modern-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-door-open-fill"></i> Rooms & Tasks Management
                    </h5>
                    <div class="btn-group">
                        <button class="btn btn-success" 
                                data-bs-toggle="modal"
                                data-bs-target="#addDefaultRoomsModal"
                                type="button"
                                {{ $defaultRooms && $defaultRooms->count() > 0 ? '' : 'disabled' }}>
                            <i class="bi bi-lightning-charge-fill"></i> Quick Add Default Rooms
                        </button>
                        <button class="btn btn-primary" 
                                data-bs-toggle="modal"
                                data-bs-target="#addRoomModal"
                                type="button">
                            <i class="bi bi-plus-circle-fill"></i> Add Custom Room
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @forelse($property->rooms as $room)
                        <div class="room-card mb-4">
                            <div class="room-header">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="room-name mb-1">
                                            <i class="bi bi-door-closed-fill text-primary"></i> 
                                            {{ $room->name }}
                                            @if($room->is_default)
                                                <span class="badge bg-primary-subtle text-primary ms-2">
                                                    <i class="bi bi-star-fill"></i> Default
                                                </span>
                                            @endif
                                        </h5>
                                        @if($room->description)
                                            <p class="text-muted small mb-2">{{ $room->description }}</p>
                                        @endif
                                        <span class="badge bg-info">
                                            <i class="bi bi-camera-fill"></i> Min {{ $room->min_photos }} photos
                                        </span>
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-list-check"></i> {{ $room->tasks->count() }} tasks
                                        </span>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#editRoomModal{{ $room->id }}"
                                                type="button">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#addTaskModal{{ $room->id }}"
                                                type="button">
                                            <i class="bi bi-plus"></i> Task
                                        </button>
                                        <form action="{{ route('owner.rooms.destroy', [$property, $room]) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete {{ $room->name }}? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Tasks for this room --}}
                            <div class="room-tasks mt-3">
                                <h6 class="text-muted mb-2">
                                    <i class="bi bi-check2-square"></i> Assigned Tasks
                                </h6>
                                @if($room->tasks->count() > 0)
                                    <div class="row g-2">
                                        @foreach($room->tasks as $task)
                                            <div class="col-md-6">
                                                <div class="task-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="flex-grow-1">
                                                            <i class="bi bi-check-circle-fill text-success"></i>
                                                            <span class="task-name">{{ $task->name }}</span>
                                                            @if($task->is_default)
                                                                <span class="badge bg-primary-subtle text-primary ms-1" style="font-size: 0.7rem;">
                                                                    <i class="bi bi-star-fill"></i> Default
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <form method="POST" 
                                                              action="{{ route('owner.rooms.detach-task', ['property' => $property, 'room' => $room, 'task' => $task]) }}" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-link text-danger p-0" 
                                                                    onclick="return confirm('Remove this task from {{ $room->name }}?')">
                                                                <i class="bi bi-x-circle"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    @if($task->description)
                                                        <small class="text-muted d-block ms-4">{{ $task->description }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-light mb-0">
                                        <i class="bi bi-info-circle"></i> No tasks assigned yet. 
                                        <button class="btn btn-sm btn-link p-0" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#addTaskModal{{ $room->id }}"
                                                type="button">
                                            Add tasks now
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-door-closed display-1 text-muted"></i>
                            <h5 class="text-muted mt-3">No Rooms Added Yet</h5>
                            <p class="text-muted">Add rooms to this property to manage tasks and housekeeping</p>
                            <button class="btn btn-primary" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#addRoomModal"
                                    type="button">
                                <i class="bi bi-plus-circle-fill"></i> Add Your First Room
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modals for each room - COMPLETELY OUTSIDE all containers --}}
@foreach($property->rooms as $room)
    {{-- Edit Room Modal --}}
    <div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('owner.rooms.update', ['property' => $property, 'room' => $room]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil-fill"></i> Edit Room
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Room Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $room->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2">{{ $room->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Minimum Photos Required</label>
                            <input type="number" name="min_photos" class="form-control" value="{{ $room->min_photos }}" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Room
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Task to Room Modal --}}
    <div class="modal fade" 
         id="addTaskModal{{ $room->id }}" 
         tabindex="-1" 
         aria-labelledby="addTaskModalLabel{{ $room->id }}" 
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <form id="assignTaskForm{{ $room->id }}" method="POST" action="{{ route('owner.rooms.attach-task', ['property' => $property, 'room' => $room]) }}">
                    @csrf
                    <div class="modal-header gradient-header-success">
                        <h5 class="modal-title text-white" id="addTaskModalLabel{{ $room->id }}">
                            <i class="bi bi-plus-circle-fill"></i> Add Tasks to {{ $room->name }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                        @if($availableTasks->count() > 0)
                            {{-- Select All Defaults Option --}}
                            <div class="mb-3 p-3 bg-light rounded">
                                <div class="form-check">
                                    <input class="form-check-input form-check-input-lg" 
                                           type="checkbox" 
                                           id="selectAllDefaults{{ $room->id }}"
                                           style="width: 1.5em; height: 1.5em;">
                                    <label class="form-check-label fw-bold ms-2" for="selectAllDefaults{{ $room->id }}" style="font-size: 1.1rem;">
                                        <i class="bi bi-star-fill text-primary"></i> Select All Default Tasks
                                    </label>
                                </div>
                            </div>

                            {{-- Task List --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-check2-square"></i> Available Tasks:
                                </label>
                                <div class="list-group task-list-{{ $room->id }}">
                                    @foreach($availableTasks as $task)
                                        @php
                                            $isAssigned = $room->tasks->contains($task->id);
                                        @endphp
                                        <label class="list-group-item {{ $isAssigned ? 'list-group-item-success' : '' }} {{ $task->is_default ? 'default-task' : 'custom-task' }}" 
                                               style="cursor: {{ $isAssigned ? 'not-allowed' : 'pointer' }};">
                                            <div class="d-flex align-items-center py-2">
                                                <input class="form-check-input me-3 task-checkbox {{ $task->is_default ? 'default-task-checkbox' : '' }}" 
                                                       type="checkbox" 
                                                       name="task_ids[]" 
                                                       value="{{ $task->id }}"
                                                       data-room-id="{{ $room->id }}"
                                                       style="width: 1.5em; height: 1.5em; cursor: {{ $isAssigned ? 'not-allowed' : 'pointer' }};"
                                                       {{ $isAssigned ? 'checked disabled' : '' }}>
                                                <div class="flex-grow-1">
                                                    <div class="fw-bold" style="font-size: 1.05rem;">
                                                        {{ $task->name }}
                                                        @if($task->is_default)
                                                            <span class="badge bg-primary ms-2">
                                                                <i class="bi bi-star-fill"></i> Default
                                                            </span>
                                                        @endif
                                                        @if($isAssigned)
                                                            <span class="badge bg-success ms-2">
                                                                <i class="bi bi-check2"></i> Already Assigned
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @if($task->description)
                                                        <small class="text-muted d-block mt-1">{{ $task->description }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> No tasks available. 
                                <a href="{{ route('owner.tasks.create') }}" target="_blank" class="alert-link">Create tasks first</a>
                            </div>
                        @endif
                        
                        {{-- Collapsible Quick Create Task Form --}}
                        <div class="collapse border-top mt-3" id="createTaskForm{{ $room->id }}">
                            <div class="p-3 bg-light rounded">
                                <h6 class="mb-3"><i class="bi bi-lightning-fill text-warning"></i> Quick Create Task</h6>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="quickTaskName{{ $room->id }}" placeholder="Task name">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="quickTaskDescription{{ $room->id }}" placeholder="Description (optional)">
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="createQuickTask({{ $room->id }}, {{ $property->id }})">
                                            <i class="bi bi-check2"></i> Create & Add to List
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#createTaskForm{{ $room->id }}">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-primary me-auto" data-bs-toggle="collapse" data-bs-target="#createTaskForm{{ $room->id }}">
                            <i class="bi bi-plus-circle"></i> Create New Task
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-success btn-lg" {{ $availableTasks->count() == 0 ? 'disabled' : '' }}>
                            <i class="bi bi-check-circle-fill"></i> Assign Selected Tasks
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

{{-- Quick Add Default Rooms Modal --}}
<div class="modal fade" id="addDefaultRoomsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('owner.rooms.add-defaults', $property) }}">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border: none;">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-lightning-charge-fill"></i> Quick Add Default Rooms
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill"></i> 
                        <strong>Select default rooms to add to this property.</strong>
                        <br>These are standard rooms with pre-configured settings. You can customize them later.
                    </div>
                    
                    @if($defaultRooms->count() > 0)
                        <div class="row g-3">
                            @foreach($defaultRooms as $defaultRoom)
                                <div class="col-md-6">
                                    <div class="card h-100 default-room-card">
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="default_room_ids[]" 
                                                       value="{{ $defaultRoom->id }}" 
                                                       id="defaultRoom{{ $defaultRoom->id }}"
                                                       checked>
                                                <label class="form-check-label w-100" for="defaultRoom{{ $defaultRoom->id }}">
                                                    <h6 class="mb-1">
                                                        <i class="bi bi-door-closed-fill text-success"></i>
                                                        {{ $defaultRoom->name }}
                                                        <span class="badge bg-primary-subtle text-primary ms-2" style="font-size: 0.7rem;">
                                                            <i class="bi bi-star-fill"></i> Default
                                                        </span>
                                                    </h6>
                                                    @if($defaultRoom->description)
                                                        <p class="text-muted small mb-2">{{ $defaultRoom->description }}</p>
                                                    @endif
                                                    <small class="text-muted">
                                                        <i class="bi bi-camera-fill"></i> {{ $defaultRoom->min_photos }} photos required
                                                    </small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAllRooms" checked>
                                <label class="form-check-label" for="selectAllRooms">
                                    <strong>Select/Deselect All</strong>
                                </label>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> No default rooms available.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" {{ $defaultRooms->count() == 0 ? 'disabled' : '' }}>
                        <i class="bi bi-lightning-charge-fill"></i> Add Selected Rooms
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Add Room Modal --}}
<div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('owner.rooms.store', $property) }}">
                @csrf
                <div class="modal-header gradient-header-primary">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-plus-circle-fill"></i> Add New Room
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Room Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., Master Bedroom, Living Room" required>
                        <small class="text-muted">Give this room a descriptive name</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Optional details about this room"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Minimum Photos Required <span class="text-danger">*</span></label>
                        <input type="number" name="min_photos" class="form-control" value="8" min="1" required>
                        <small class="text-muted">Housekeepers must upload at least this many photos</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Create Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
    }

    .gradient-card-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .property-stat {
        display: flex;
        align-items: center;
        color: white;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
    }

    .property-stat i {
        font-size: 1.5rem;
        margin-right: 1rem;
    }

    .property-stat .stat-label {
        flex: 1;
        font-weight: 600;
    }

    .property-stat .stat-value {
        font-size: 1.25rem;
        font-weight: 700;
    }

    .border-white-20 {
        border-color: rgba(255, 255, 255, 0.2) !important;
    }

    .text-white-80 {
        color: rgba(255, 255, 255, 0.8);
    }

    .modern-card {
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
    }

    .room-card {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .room-card:hover {
        border-color: #667eea;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
        transform: translateY(-2px);
    }

    .room-name {
        color: #2d3748;
        font-weight: 700;
    }

    .task-item {
        background: white;
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }

    .task-item:hover {
        border-color: #667eea;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
    }

    .task-name {
        font-weight: 600;
        color: #2d3748;
    }

    .task-check-item {
        padding: 1rem;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
    }

    .task-check-item:hover {
        background: #f8f9fa;
        border-color: #667eea;
    }

    .task-selection-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .gradient-header-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .gradient-header-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
    }

    .btn-link {
        text-decoration: none;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    .default-room-card {
        border: 2px solid #e9ecef;
        transition: all 0.2s;
    }

    .default-room-card:has(.form-check-input:checked) {
        border-color: #38ef7d;
        background-color: #f0fff8;
    }

    .default-room-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Task selection cards */
    .task-selection-card {
        border: 2px solid #e9ecef;
        transition: all 0.2s;
        cursor: pointer;
    }

    .task-selection-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .task-selection-card:has(.form-check-input:checked:not(:disabled)) {
        border-color: #38ef7d;
        background-color: #f0fff8;
    }

    .task-selection-card.already-assigned {
        border-color: #28a745;
        background-color: #f8fff9;
        opacity: 0.8;
    }

    .task-selection-card .form-check-label {
        cursor: pointer;
    }

    .task-selection-card:has(.form-check-input:disabled) {
        cursor: not-allowed;
    }

    /* Fix modal blinking issue */
    .modal {
        z-index: 1055 !important;
    }
    
    .modal-backdrop {
        z-index: 1050 !important;
    }
    
    /* Ensure modal is stable */
    .modal.show {
        display: block !important;
    }
    
    .modal-dialog-scrollable {
        max-height: calc(100vh - 60px);
    }
    
    .modal-dialog-scrollable .modal-body {
        overflow-y: auto;
        max-height: calc(100vh - 200px);
    }
    
    /* Ensure modal footer is always visible */
    .modal-content {
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }
    
    .modal-body {
        flex: 1;
        overflow-y: auto;
    }
    
    .modal-footer {
        flex-shrink: 0;
        border-top: 2px solid #dee2e6;
    }
</style>
@endpush

@push('scripts')
<script>
// Select all functionality for default rooms modal only
document.addEventListener('DOMContentLoaded', function() {
    const selectAllRooms = document.getElementById('selectAllRooms');
    if (selectAllRooms) {
        selectAllRooms.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="default_room_ids[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        const roomCheckboxes = document.querySelectorAll('input[name="default_room_ids[]"]');
        roomCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(roomCheckboxes).every(cb => cb.checked);
                const noneChecked = Array.from(roomCheckboxes).every(cb => !cb.checked);
                selectAllRooms.checked = allChecked;
                selectAllRooms.indeterminate = !allChecked && !noneChecked;
            });
        });
    }
    
    // Select All Default Tasks functionality - Using event delegation for dynamic content
    document.addEventListener('change', function(e) {
        // Check if it's a "Select All Defaults" checkbox
        if (e.target.id && e.target.id.startsWith('selectAllDefaults')) {
            const roomId = e.target.id.replace('selectAllDefaults', '');
            const taskList = document.querySelector('.task-list-' + roomId);
            
            console.log('Select All clicked for room:', roomId, 'Checked:', e.target.checked);
            
            if (taskList) {
                const defaultCheckboxes = taskList.querySelectorAll('.default-task-checkbox:not(:disabled)');
                console.log('Found default checkboxes:', defaultCheckboxes.length);
                
                defaultCheckboxes.forEach(checkbox => {
                    checkbox.checked = e.target.checked;
                });
            }
        }
        
        // Update "Select All Defaults" when individual default task checkboxes change
        if (e.target.classList.contains('default-task-checkbox')) {
            const roomId = e.target.getAttribute('data-room-id');
            const selectAllCheckbox = document.getElementById('selectAllDefaults' + roomId);
            
            if (selectAllCheckbox) {
                const taskList = document.querySelector('.task-list-' + roomId);
                const allDefaultCheckboxes = taskList.querySelectorAll('.default-task-checkbox:not(:disabled)');
                const checkedDefaults = taskList.querySelectorAll('.default-task-checkbox:not(:disabled):checked');
                
                selectAllCheckbox.checked = allDefaultCheckboxes.length === checkedDefaults.length && allDefaultCheckboxes.length > 0;
                selectAllCheckbox.indeterminate = checkedDefaults.length > 0 && checkedDefaults.length < allDefaultCheckboxes.length;
            }
        }
    });
    
    // Debug form submissions
    document.querySelectorAll('[id^="assignTaskForm"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const formData = new FormData(this);
            const taskIds = formData.getAll('task_ids[]');
            
            console.log('=== Form Submission Debug ===');
            console.log('Form:', this.id);
            console.log('Action:', this.action);
            console.log('Task IDs being submitted:', taskIds);
            console.log('Number of tasks:', taskIds.length);
            
            // Check all checkboxes in the form
            const allCheckboxes = this.querySelectorAll('input[name="task_ids[]"]');
            const enabledCheckboxes = this.querySelectorAll('input[name="task_ids[]"]:not(:disabled)');
            const checkedCheckboxes = this.querySelectorAll('input[name="task_ids[]"]:checked');
            const checkedEnabledCheckboxes = this.querySelectorAll('input[name="task_ids[]"]:checked:not(:disabled)');
            
            console.log('Total checkboxes:', allCheckboxes.length);
            console.log('Enabled checkboxes:', enabledCheckboxes.length);
            console.log('Checked checkboxes:', checkedCheckboxes.length);
            console.log('Checked & Enabled checkboxes:', checkedEnabledCheckboxes.length);
            
            if (taskIds.length === 0) {
                e.preventDefault();
                alert('⚠️ Please select at least one task to assign.');
                return false;
            }
            
            console.log('Form will submit normally');
        });
    });
});

// Quick Create Task Function
function createQuickTask(roomId, propertyId) {
    const taskName = document.getElementById('quickTaskName' + roomId).value.trim();
    const taskDescription = document.getElementById('quickTaskDescription' + roomId).value.trim();
    
    if (!taskName) {
        alert('Please enter a task name');
        return;
    }
    
    // Create FormData for AJAX request
    const formData = new FormData();
    formData.append('name', taskName);
    formData.append('description', taskDescription);
    formData.append('property_id', propertyId);
    formData.append('is_default', '0'); // Custom task
    formData.append('_token', '{{ csrf_token() }}');
    
    // Show loading state
    const createBtn = event.target;
    const originalText = createBtn.innerHTML;
    createBtn.disabled = true;
    createBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Creating...';
    
    // Send AJAX request
    fetch('{{ route("owner.tasks.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Response:', data);
        if (data.success) {
            // Add new task to the list
            const taskList = document.querySelector('.task-list-' + roomId);
            const newTaskHtml = `
                <label class="list-group-item custom-task" style="cursor: pointer;">
                    <div class="d-flex align-items-center py-2">
                        <input class="form-check-input me-3 task-checkbox" 
                               type="checkbox" 
                               name="task_ids[]" 
                               value="${data.task.id}"
                               data-room-id="${roomId}"
                               style="width: 1.5em; height: 1.5em; cursor: pointer;"
                               checked>
                        <div class="flex-grow-1">
                            <div class="fw-bold" style="font-size: 1.05rem;">
                                ${data.task.name}
                            </div>
                            ${data.task.description ? '<small class="text-muted d-block mt-1">' + data.task.description + '</small>' : ''}
                        </div>
                    </div>
                </label>
            `;
            taskList.insertAdjacentHTML('beforeend', newTaskHtml);
            
            // Clear form
            document.getElementById('quickTaskName' + roomId).value = '';
            document.getElementById('quickTaskDescription' + roomId).value = '';
            
            // Hide form using Bootstrap collapse
            const collapseEl = document.getElementById('createTaskForm' + roomId);
            const bsCollapse = bootstrap.Collapse.getInstance(collapseEl) || new bootstrap.Collapse(collapseEl, {toggle: false});
            bsCollapse.hide();
            
            // Show success message
            alert('✅ Task created and added to selection!');
        } else {
            alert('❌ Error creating task: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error creating task. Please check console for details.');
    })
    .finally(() => {
        createBtn.disabled = false;
        createBtn.innerHTML = originalText;
    });
}
</script>
@endpush
@endsection
