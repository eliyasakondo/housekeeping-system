@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('owner.checklists.index') }}" class="btn btn-outline-secondary mb-2">
                <i class="bi bi-arrow-left"></i> Back to Checklists
            </a>
            <h1><i class="bi bi-clipboard-check"></i> Checklist #{{ $checklist->id }}</h1>
        </div>
        <div>
            @if($checklist->status == 'completed')
                <span class="badge bg-success fs-5">
                    <i class="bi bi-check-circle"></i> Completed
                </span>
            @elseif($checklist->status == 'in_progress')
                <span class="badge bg-info fs-5">
                    <i class="bi bi-play-circle"></i> In Progress
                </span>
            @else
                <span class="badge bg-warning fs-5">
                    <i class="bi bi-clock"></i> Pending
                </span>
            @endif
            <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bi bi-trash-fill"></i> Delete
            </button>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted"><i class="bi bi-building"></i> Property</h6>
                    <h4>{{ $checklist->property->name }}</h4>
                    <small class="text-muted">{{ $checklist->property->address }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted"><i class="bi bi-person"></i> Housekeeper</h6>
                    <h4>{{ $checklist->housekeeper->name }}</h4>
                    <small class="text-muted">{{ $checklist->housekeeper->email }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted"><i class="bi bi-calendar"></i> Scheduled Date</h6>
                    <h4>{{ $checklist->scheduled_date->format('M d, Y') }}</h4>
                    @if($checklist->scheduled_time)
                        <p class="mb-1"><i class="bi bi-clock text-primary"></i> {{ date('g:i A', strtotime($checklist->scheduled_time)) }}</p>
                    @endif
                    @if($checklist->started_at)
                        <small class="text-muted">Started: {{ $checklist->started_at->format('M d, H:i') }}</small>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted"><i class="bi bi-list-check"></i> Progress</h6>
                    @php
                        $totalItems = $checklist->checklistItems->count();
                        $completedItems = $checklist->checklistItems->where('is_completed', true)->count();
                        $percentage = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
                    @endphp
                    <h4>{{ $percentage }}%</h4>
                    <small class="text-muted">{{ $completedItems }}/{{ $totalItems }} tasks completed</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks -->
    @if($checklist->checklistItems->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-list-check"></i> Cleaning Tasks</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Task</th>
                            <th>Description</th>
                            <th>Completed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checklist->checklistItems as $item)
                            <tr class="{{ $item->is_completed ? 'table-success' : '' }}">
                                <td class="text-center">
                                    @if($item->is_completed)
                                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    @else
                                        <i class="bi bi-circle text-muted fs-5"></i>
                                    @endif
                                </td>
                                <td>{{ $item->task->name }}</td>
                                <td>
                                    @if($item->task->description)
                                        <small class="text-muted">{{ $item->task->description }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->completed_at)
                                        <small>{{ $item->completed_at->format('M d, H:i') }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Inventory Items -->
    @if($checklist->inventoryItems->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Inventory Checklist</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Condition</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checklist->inventoryItems as $item)
                                <tr>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>
                                        @if($item->condition === 'good')
                                            <span class="badge bg-success">Good</span>
                                        @elseif($item->condition === 'damaged')
                                            <span class="badge bg-danger">Damaged</span>
                                        @else
                                            <span class="badge bg-warning">Missing</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->notes)
                                            <small class="text-muted">{{ $item->notes }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Photos -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-camera"></i> Photos ({{ $checklist->photos->count() }})</h5>
        </div>
        <div class="card-body">
            @if($checklist->photos->count() > 0)
                @php
                    $photosByRoom = $checklist->photos->groupBy('room_id');
                @endphp
                
                @foreach($checklist->property->rooms as $room)
                    @php
                        $roomPhotos = $photosByRoom->get($room->id, collect());
                    @endphp
                    
                    @if($roomPhotos->count() > 0)
                        <div class="mb-4">
                            <h6><i class="bi bi-door-closed"></i> {{ $room->name }} ({{ $roomPhotos->count() }} photos)</h6>
                            <div class="row g-3">
                                @foreach($roomPhotos as $photo)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                                 class="card-img-top" 
                                                 alt="Photo"
                                                 style="height: 200px; object-fit: cover; cursor: pointer;"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#photoModal{{ $photo->id }}">
                                            <div class="card-body p-2">
                                                <small class="text-muted">
                                                    <i class="bi bi-clock"></i> {{ $photo->taken_at->format('M d, H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Photo Modal -->
                                    <div class="modal fade" id="photoModal{{ $photo->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $room->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-0">
                                                    <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                                         class="w-100" 
                                                         alt="Photo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <p class="text-muted text-center py-4">No photos uploaded yet</p>
            @endif
        </div>
    </div>

    <!-- GPS Verification -->
    @if($checklist->gps_verified)
        <div class="alert alert-success">
            <i class="bi bi-geo-alt-fill"></i> GPS Verified: 
            Location confirmed at {{ $checklist->gps_latitude }}, {{ $checklist->gps_longitude }}
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Delete Checklist
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this checklist?</p>
                <p class="text-muted mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('owner.checklists.destroy', $checklist) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
