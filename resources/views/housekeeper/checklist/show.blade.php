@extends('layouts.app')

@push('styles')
<style>
    /* Enhanced larger and more responsive checkboxes */
    .task-checkbox {
        width: 2rem !important;
        height: 2rem !important;
        cursor: pointer;
        flex-shrink: 0;
        border-width: 2px !important;
        transition: all 0.3s ease;
    }
    
    .task-checkbox:hover {
        transform: scale(1.1);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .task-checkbox:checked {
        background-color: #198754 !important;
        border-color: #198754 !important;
        animation: checkboxPop 0.3s ease;
    }
    
    @keyframes checkboxPop {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    
    .form-check {
        display: flex;
        align-items: flex-start;
        padding: 16px;
        border-radius: 12px;
        transition: all 0.3s ease;
        background-color: #ffffff;
        border: 2px solid transparent;
        margin-bottom: 12px;
    }
    
    .form-check:hover {
        background-color: #f8f9fa;
        border-color: #e9ecef;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transform: translateX(4px);
    }
    
    .form-check-label {
        margin-left: 16px;
        cursor: pointer;
        flex: 1;
        line-height: 2rem;
        transition: all 0.3s ease;
        user-select: none;
    }
    
    .form-check-input:checked ~ .form-check-label {
        color: #6c757d;
        opacity: 0.7;
    }
    
    /* Smooth loading indicator */
    .task-checkbox.loading {
        opacity: 0.6;
        pointer-events: none;
    }
    
    /* Completed task styling */
    .task-completed {
        background-color: #d1e7dd !important;
        border-color: #badbcc !important;
    }
    
    /* MOBILE RESPONSIVE STYLES FOR CHECKLIST */
    @media (max-width: 768px) {
        /* Container padding */
        .container {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
            max-width: 100% !important;
        }
        
        /* Force single column layout */
        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        
        .row > div[class*="col-"] {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        
        /* Card wrapping and text overflow fixes */
        .card {
            width: 100% !important;
            max-width: 100% !important;
            margin-bottom: 1rem !important;
            overflow: hidden;
            box-sizing: border-box;
        }
        
        .card-header,
        .card-body,
        .card-footer {
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            word-break: break-word !important;
            white-space: normal !important;
            overflow: visible !important;
        }
        
        /* Force text wrapping for all elements */
        h1, h2, h3, h4, h5, h6,
        p, span, div, label, small, strong,
        .form-check-label,
        .text-muted {
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            word-break: break-word !important;
            white-space: normal !important;
            max-width: 100% !important;
        }
        
        /* Typography mobile */
        h2 { font-size: 1.5rem !important; }
        h3 { font-size: 1.25rem !important; }
        h4 { font-size: 1.1rem !important; }
        h5 { font-size: 1rem !important; }
        h6 { font-size: 0.95rem !important; }
        
        /* Header section mobile */
        .row.mb-4 { margin-bottom: 1rem !important; }
        
        /* Step indicator mobile */
        .step-indicator {
            padding: 1rem !important;
            margin-bottom: 0.75rem;
        }
        
        .step-indicator i {
            font-size: 2.5rem !important;
        }
        
        .step-indicator h5 {
            font-size: 0.95rem !important;
            margin-bottom: 0.5rem !important;
        }
        
        .step-indicator .badge {
            font-size: 0.75rem !important;
        }
        
        .step-indicator p.small {
            font-size: 0.75rem !important;
        }
        
        /* Card mobile optimization */
        .card {
            margin-bottom: 1rem !important;
        }
        
        .card-header {
            padding: 0.75rem !important;
        }
        
        .card-header h4,
        .card-header h5 {
            font-size: 1rem !important;
        }
        
        .card-body {
            padding: 1rem !important;
        }
        
        /* Alert mobile */
        .alert {
            padding: 0.75rem !important;
            font-size: 0.9rem !important;
        }
        
        .alert h5 {
            font-size: 1rem !important;
        }
        
        .alert ul {
            padding-left: 1.25rem;
        }
        
        .alert li {
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }
        
        /* Start button mobile */
        .btn-lg {
            padding: 0.75rem 1.5rem !important;
            font-size: 1rem !important;
            min-height: 48px;
        }
        
        /* Task checkboxes mobile - LARGER for easy tapping */
        .task-checkbox {
            width: 2.5rem !important;
            height: 2.5rem !important;
            min-width: 2.5rem !important;
            flex-shrink: 0 !important;
        }
        
        .form-check {
            padding: 12px !important;
            margin-bottom: 10px !important;
            display: flex !important;
            align-items: flex-start !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        
        .form-check-label {
            margin-left: 12px !important;
            line-height: 1.4 !important;
            font-size: 0.95rem !important;
            flex: 1 !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            word-break: break-word !important;
            white-space: normal !important;
            max-width: calc(100% - 3rem) !important;
        }
        
        .form-check-label strong {
            display: block !important;
            margin-bottom: 0.25rem !important;
            line-height: 1.3 !important;
        }
        
        .form-check-label small {
            display: block !important;
            line-height: 1.3 !important;
            margin-top: 0.25rem !important;
        }
        
        /* Room card mobile */
        .mobile-room-card .card-header {
            padding: 1rem !important;
        }
        
        .mobile-room-card h5 {
            font-size: 1rem !important;
        }
        
        /* Task items mobile */
        .mobile-task-item {
            padding: 1rem !important;
            margin-bottom: 0.75rem !important;
        }
        
        .mobile-task-item label {
            font-size: 0.95rem !important;
        }
        
        /* Complete button mobile */
        .mobile-complete-btn {
            padding: 1rem !important;
            font-size: 1rem !important;
            font-weight: 600;
        }
        
        /* Upcoming rooms card mobile */
        .mobile-upcoming-card .card-body {
            padding: 1rem !important;
        }
        
        /* Progress sidebar mobile */
        .mobile-progress-sidebar {
            position: relative !important;
            top: 0 !important;
            margin-bottom: 1rem;
        }
        
        .mobile-progress-sidebar .card-body p {
            margin-bottom: 0.75rem !important;
        }
        
        /* Inventory card mobile */
        .mobile-inventory-card .card-header {
            padding: 1rem !important;
        }
        
        .mobile-inventory-item {
            margin-bottom: 0.75rem !important;
        }
        
        .mobile-inventory-item .form-control,
        .mobile-inventory-item .form-select {
            font-size: 0.9rem !important;
            padding: 0.5rem !important;
        }
        
        .mobile-inventory-item .form-label {
            margin-bottom: 0.25rem !important;
            font-weight: 600;
        }
        
        /* Photo section mobile */
        .mobile-photo-alert {
            padding: 1rem !important;
        }
        
        .mobile-photo-room-card .card-header {
            padding: 1rem !important;
        }
        
        .mobile-photo-grid {
            margin-bottom: 1rem;
        }
        
        .mobile-photo-thumbnail {
            height: 120px !important;
            border-radius: 0.5rem;
        }
        
        .mobile-file-input {
            padding: 0.75rem !important;
            font-size: 0.9rem !important;
            min-height: 48px;
        }
        
        /* Progress bars mobile */
        .mobile-progress {
            height: 24px !important;
            font-size: 0.85rem !important;
            font-weight: 600;
        }
        
        /* Photo upload mobile */
        .photo-upload-area {
            padding: 1.5rem 1rem !important;
        }
        
        .photo-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.5rem !important;
        }
        
        .photo-item {
            height: 150px !important;
        }
        
        /* File input mobile */
        input[type="file"] {
            padding: 0.75rem !important;
            font-size: 0.9rem !important;
        }
        
        /* Badge mobile */
        .badge {
            font-size: 0.75rem !important;
            padding: 0.35rem 0.65rem !important;
        }
        
        /* Button group mobile */
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            width: 100%;
        }
        
        .btn-group .btn {
            width: 100% !important;
            margin: 0 !important;
        }
        
        /* Inventory items mobile */
        .inventory-item {
            padding: 0.75rem !important;
        }
        
        .inventory-item .form-check-label {
            line-height: 1.5 !important;
        }
        
        /* Progress bars mobile */
        .progress {
            height: 20px;
            font-size: 0.8rem;
        }
        
        /* Location status mobile */
        #locationStatus {
            font-size: 0.9rem !important;
        }
        
        /* Summary section mobile */
        .summary-section {
            padding: 1rem !important;
        }
        
        .summary-section .row {
            margin-bottom: 0.75rem;
        }
        
        /* Icon sizing mobile */
        .bi {
            vertical-align: middle;
        }
        
        /* Text sizing */
        .text-muted {
            font-size: 0.85rem !important;
        }
        
        small, .small {
            font-size: 0.8rem !important;
        }
        
        /* GPS verification mobile */
        .gps-status-card {
            padding: 1.5rem 1rem !important;
        }
        
        .gps-status-card i {
            font-size: 3rem !important;
        }
    }
    
    /* Very small phones (iPhone SE, etc) */
    @media (max-width: 375px) {
        h2 { font-size: 1.35rem !important; }
        h3 { font-size: 1.15rem !important; }
        h4 { font-size: 1rem !important; }
        
        .task-checkbox {
            width: 2.25rem !important;
            height: 2.25rem !important;
        }
        
        .form-check-label {
            font-size: 0.9rem !important;
            line-height: 2.25rem !important;
        }
        
        .btn-lg {
            padding: 0.65rem 1.25rem !important;
            font-size: 0.95rem !important;
        }
        
        .step-indicator i {
            font-size: 2rem !important;
        }
        
        .photo-grid {
            grid-template-columns: 1fr !important;
        }
    }
    
    /* Touch optimization */
    @media (max-width: 768px) {
        .form-check,
        .btn,
        .card-header[data-bs-toggle="collapse"] {
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0.1);
            touch-action: manipulation;
        }
        
        .form-check:active {
            transform: translateX(2px);
        }
        
        .btn:active {
            transform: scale(0.98);
        }
    }
    
    /* Landscape mode adjustments */
    @media (max-width: 768px) and (orientation: landscape) {
        .step-indicator {
            padding: 0.75rem !important;
        }
        
        .step-indicator i {
            font-size: 2rem !important;
        }
    }
</style>
@endpush

@section('content')
<div class="container mobile-checklist-container">
    <div class="row mb-3 mb-md-4">
        <div class="col-12">
            <h2 class="h4 h3-md"><i class="bi bi-clipboard-check"></i> Checklist for {{ $checklist->property->name }}</h2>
            <p class="text-muted small mb-0">
                <i class="bi bi-calendar-event"></i> Scheduled: {{ $checklist->scheduled_date->format('M d, Y') }}
                @if($checklist->scheduled_time)
                    <i class="bi bi-clock ms-2"></i> {{ date('g:i A', strtotime($checklist->scheduled_time)) }}
                @endif
                @if($checklist->status !== 'pending')
                    <br class="d-md-none"><span class="d-none d-md-inline">| </span><i class="bi bi-clock"></i> Started: {{ $checklist->started_at->format('g:i A') }}
                @endif
            </p>
        </div>
    </div>

    {{-- Step Progress Indicator - Enhanced --}}
    @if($checklist->status !== 'pending')
    <div class="card mb-3 mb-md-4 border-primary shadow-sm mobile-workflow-card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 h6 h5-md"><i class="bi bi-signpost-split"></i> Your 3-Step Workflow</h5>
        </div>
        <div class="card-body p-2 p-md-3">
            <div class="row text-center g-2 g-md-3">
                <div class="col-12 col-md-4">
                    <div class="step-indicator {{ $checklist->workflow_step === 'tasks' ? 'active border-3 border-primary bg-light' : ($checklist->tasks_completed_at ? 'completed' : 'pending') }}" 
                         style="padding: 1rem; border-radius: 10px; {{ $checklist->workflow_step === 'tasks' ? 'box-shadow: 0 4px 8px rgba(0,123,255,0.3);' : '' }}">
                        <div class="mb-2">
                            @if($checklist->tasks_completed_at)
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 2.5rem;"></i>
                            @elseif($checklist->workflow_step === 'tasks')
                                <i class="bi bi-arrow-right-circle-fill text-primary" style="font-size: 2.5rem;"></i>
                            @else
                                <i class="bi bi-list-check text-muted" style="font-size: 2.5rem;"></i>
                            @endif
                        </div>
                        <h5 class="mb-2 small">Step 1: Room Tasks</h5>
                        @if($checklist->tasks_completed_at)
                            <span class="badge bg-success">✓ Completed</span>
                        @elseif($checklist->workflow_step === 'tasks')
                            <span class="badge bg-primary">▶ Active Now</span>
                            <p class="small text-muted mt-2 mb-0 d-none d-md-block">Complete all tasks room-by-room</p>
                        @else
                            <span class="badge bg-secondary">Pending</span>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="step-indicator {{ $checklist->workflow_step === 'inventory' ? 'active border-3 border-info bg-light' : ($checklist->inventory_completed_at ? 'completed' : 'pending') }}"
                         style="padding: 1rem; border-radius: 10px; {{ $checklist->workflow_step === 'inventory' ? 'box-shadow: 0 4px 8px rgba(13,202,240,0.3);' : '' }}">
                        <div class="mb-2">
                            @if($checklist->inventory_completed_at)
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 2.5rem;"></i>
                            @elseif($checklist->workflow_step === 'inventory')
                                <i class="bi bi-arrow-right-circle-fill text-info" style="font-size: 2.5rem;"></i>
                            @else
                                <i class="bi bi-box-seam text-muted" style="font-size: 2.5rem;"></i>
                            @endif
                        </div>
                        <h5 class="mb-2 small">Step 2: Inventory</h5>
                        @if($checklist->inventory_completed_at)
                            <span class="badge bg-success">✓ Completed</span>
                        @elseif($checklist->workflow_step === 'inventory')
                            <span class="badge bg-info">▶ Active Now</span>
                            <p class="small text-muted mt-2 mb-0 d-none d-md-block">Check all 12 items</p>
                        @else
                            <span class="badge bg-secondary">🔒 Locked</span>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="step-indicator {{ $checklist->workflow_step === 'photos' ? 'active border-3 border-success bg-light' : 'pending' }}"
                         style="padding: 1rem; border-radius: 10px; {{ $checklist->workflow_step === 'photos' ? 'box-shadow: 0 4px 8px rgba(25,135,84,0.3);' : '' }}">
                        <div class="mb-2">
                            @if($checklist->workflow_step === 'photos')
                                <i class="bi bi-arrow-right-circle-fill text-success" style="font-size: 2.5rem;"></i>
                            @else
                                <i class="bi bi-camera text-muted" style="font-size: 2.5rem;"></i>
                            @endif
                        </div>
                        <h5 class="mb-2 small">Step 3: Photos</h5>
                        @if($checklist->workflow_step === 'photos')
                            <span class="badge bg-success">▶ Active Now</span>
                            <p class="small text-muted mt-2 mb-0 d-none d-md-block">Upload photos of each room</p>
                        @else
                            <span class="badge bg-secondary">🔒 Locked</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($checklist->status === 'pending')
        {{-- Instructions for Starting --}}
        <div class="alert alert-info alert-dismissible fade show mb-3 mb-md-4 mobile-start-alert" role="alert">
            <h5 class="h6 h5-md"><i class="bi bi-info-circle"></i> Before You Start:</h5>
            <ul class="mb-0 small">
                <li>Make sure you're at <strong>{{ $checklist->property->address }}</strong></li>
                <li>You'll need to allow location access to verify you're on-site</li>
                <li>Have your phone/camera ready for taking photos later</li>
                <li>The checklist has <strong>{{ $checklist->property->rooms->count() }} rooms</strong> to complete</li>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        {{-- GPS Start Section --}}
        <div class="card mb-3 mb-md-4 border-success shadow-sm mobile-start-card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0 h6 h5-md"><i class="bi bi-geo-alt"></i> Ready to Start?</h4>
            </div>
            <div class="card-body text-center py-4 py-md-5 gps-status-card">
                <i class="bi bi-play-circle" style="font-size: 3.5rem; color: #198754;"></i>
                <h4 class="mt-3 h6 h5-md">Let's Begin Your Checklist!</h4>
                <p class="text-muted mb-4 small">We'll verify your location first, then you can start cleaning room by room.</p>
                <button id="startBtn" class="btn btn-success btn-lg mobile-start-btn">
                    <i class="bi bi-play-circle"></i> Start Checklist
                </button>
                <div id="locationStatus" class="mt-3 small"></div>
            </div>
        </div>
    @elseif($checklist->workflow_step === 'tasks')
        {{-- STEP 1: ROOM-BY-ROOM TASKS --}}
        <div class="row g-3">
            <div class="col-12 col-md-8">
                @if($checklist->currentRoom)
                    <div class="card mb-3 mobile-room-card">
                        <div class="card-header bg-primary text-white p-3">
                            <h5 class="mb-1 h6 h5-md">
                                <i class="bi bi-door-open"></i> Current Room: {{ $checklist->currentRoom->name }}
                            </h5>
                            <small class="d-block small">Complete all tasks in this room before moving to the next</small>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="small">Tasks to Complete:</h6>
                            @php
                                $roomItems = $checklist->items->where('room_id', $checklist->current_room_id);
                                $completedCount = $roomItems->where('is_completed', true)->count();
                                $totalCount = $roomItems->count();
                            @endphp
                            
                            <div class="progress mb-3 mobile-progress">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ $totalCount > 0 ? ($completedCount / $totalCount * 100) : 0 }}%"
                                     aria-valuenow="{{ $completedCount }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="{{ $totalCount }}">
                                    {{ $completedCount }} / {{ $totalCount }}
                                </div>
                            </div>

                            @foreach($roomItems as $item)
                                <div class="form-check mb-3 mobile-task-item {{ $item->is_completed ? 'task-completed' : '' }}">
                                    <input class="form-check-input task-checkbox" type="checkbox" 
                                           id="task{{ $item->id }}" 
                                           data-item-id="{{ $item->id }}"
                                           {{ $item->is_completed ? 'checked' : '' }}>
                                    <label class="form-check-label {{ $item->is_completed ? 'text-decoration-line-through' : '' }}" 
                                           for="task{{ $item->id }}">
                                        <strong class="d-block">{{ $item->task->name }}</strong>
                                        @if($item->task->description)
                                            <small class="text-muted d-block mt-1">{{ $item->task->description }}</small>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                            
                            <hr class="my-3">
                            <form action="{{ route('housekeeper.checklist.room.complete', $checklist) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg w-100 mobile-complete-btn" 
                                        {{ $completedCount < $totalCount ? 'disabled' : '' }}>
                                    <i class="bi bi-check-circle"></i> Complete {{ $checklist->currentRoom->name }} & Continue
                                </button>
                                @if($completedCount < $totalCount)
                                    <small class="text-muted d-block mt-2 text-center small">
                                        Complete all tasks to unlock this button
                                    </small>
                                @endif
                            </form>
                        </div>
                    </div>

                    {{-- Show locked upcoming rooms --}}
                    @php
                        $upcomingRooms = $checklist->property->rooms()
                            ->where('id', '>', $checklist->current_room_id)
                            ->orderBy('id')
                            ->take(3)
                            ->get();
                    @endphp
                    @if($upcomingRooms->count() > 0)
                        <div class="card mb-3 border-secondary mobile-upcoming-card">
                            <div class="card-header bg-secondary text-white p-3">
                                <h6 class="mb-0 small"><i class="bi bi-lock"></i> Upcoming Rooms</h6>
                            </div>
                            <div class="card-body p-3">
                                @foreach($upcomingRooms as $room)
                                    <div class="text-muted mb-2 small">
                                        <i class="bi bi-circle"></i> {{ $room->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <div class="alert alert-success mobile-alert">
                        <h5 class="h6 h5-md">All Room Tasks Completed!</h5>
                        <p class="mb-0 small">Proceeding to inventory checklist...</p>
                    </div>
                @endif
            </div>

            <div class="col-12 col-md-4">
                <div class="card mobile-progress-sidebar" style="position: sticky; top: 80px;">
                    <div class="card-header bg-primary text-white p-3">
                        <h5 class="mb-0 h6 h5-md">Progress</h5>
                    </div>
                    <div class="card-body p-3">
                        <p class="small mb-2"><strong>Property:</strong><br><span class="text-muted">{{ $checklist->property->name }}</span></p>
                        <p class="small mb-2"><strong>Current Step:</strong><br>
                            <span class="badge bg-primary">Room Tasks</span>
                        </p>
                        <p class="small mb-2"><strong>Started:</strong><br><span class="text-muted">{{ $checklist->started_at?->format('g:i A') }}</span></p>
                        
                        <hr class="my-2">
                        
                        <p class="small mb-2"><strong>Overall Tasks:</strong><br>
                            <span class="text-success fs-5">{{ $checklist->items->where('is_completed', true)->count() }}</span> / {{ $checklist->items->count() }}
                        </p>

                        @php
                            $totalRooms = $checklist->property->rooms->count();
                            $completedRooms = 0;
                            foreach($checklist->property->rooms as $room) {
                                $roomItems = $checklist->items->where('room_id', $room->id);
                                if($roomItems->count() > 0 && $roomItems->where('is_completed', false)->count() === 0) {
                                    $completedRooms++;
                                }
                            }
                        @endphp
                        
                        <p class="small mb-0"><strong>Rooms Completed:</strong><br>
                            <span class="text-success fs-5">{{ $completedRooms }}</span> / {{ $totalRooms }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    @elseif($checklist->workflow_step === 'inventory')
        {{-- STEP 2: INVENTORY CHECKLIST --}}
        <div class="row g-3">
            <div class="col-12 col-md-8">
                <div class="card mb-3 mobile-inventory-card">
                    <div class="card-header bg-success text-white p-3">
                        <h5 class="mb-1 h6 h5-md">
                            <i class="bi bi-box-seam"></i> Inventory Checklist
                        </h5>
                        <small class="d-block small">Verify and count all items for this property</small>
                    </div>
                    <div class="card-body p-3">
                        @php
                            $completedInventory = $checklist->inventoryItems->where('is_completed', true)->count();
                            $totalInventory = $checklist->inventoryItems->count();
                        @endphp
                        
                        <div class="progress mb-3 mobile-progress">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ $totalInventory > 0 ? ($completedInventory / $totalInventory * 100) : 0 }}%"
                                 aria-valuenow="{{ $completedInventory }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="{{ $totalInventory }}">
                                {{ $completedInventory }} / {{ $totalInventory }}
                            </div>
                        </div>

                        @foreach($checklist->inventoryItems as $item)
                            <div class="card mb-2 mobile-inventory-item {{ $item->is_completed ? 'border-success' : '' }}">
                                <div class="card-body p-3">
                                    <div class="row align-items-center g-2">
                                        <div class="col-12 col-md-4 mb-2 mb-md-0">
                                            <strong class="d-block small">{{ $item->item_name }}</strong>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label class="form-label small mb-1 d-block d-md-none">Quantity</label>
                                            <input type="number" class="form-control form-control-sm inventory-quantity" 
                                                   data-item-id="{{ $item->id }}"
                                                   placeholder="Quantity" 
                                                   value="{{ $item->quantity }}"
                                                   {{ $item->is_completed ? 'readonly' : '' }}>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label class="form-label small mb-1 d-block d-md-none">Status</label>
                                            <select class="form-select form-select-sm inventory-available" 
                                                    data-item-id="{{ $item->id }}"
                                                    {{ $item->is_completed ? 'disabled' : '' }}>
                                                <option value="1" {{ $item->is_available ? 'selected' : '' }}>Available</option>
                                                <option value="0" {{ !$item->is_available ? 'selected' : '' }}>Not Available</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-2 text-center text-md-start">
                                            @if($item->is_completed)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <button type="button" class="btn btn-sm btn-primary inventory-complete-btn" 
                                                        data-item-id="{{ $item->id }}">
                                                    Check
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    @if($item->notes)
                                        <small class="text-muted d-block mt-2">Notes: {{ $item->notes }}</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <hr>
                        <form action="{{ route('housekeeper.checklist.inventory.complete', $checklist) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg w-100 mobile-complete-btn" 
                                    {{ $completedInventory < $totalInventory ? 'disabled' : '' }}>
                                <i class="bi bi-check-circle"></i> Complete Inventory & Continue to Photos
                            </button>
                            @if($completedInventory < $totalInventory)
                                <small class="text-muted d-block mt-2 text-center small">
                                    Check all inventory items to proceed
                                </small>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card position-sticky mobile-progress-sidebar" style="top: 20px;">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0 h6 h5-md">Progress</h5>
                    </div>
                    <div class="card-body">
                        <p class="small mb-2"><strong>Property:</strong><br><span class="text-muted">{{ $checklist->property->name }}</span></p>
                        <p class="small mb-2"><strong>Current Step:</strong><br>
                            <span class="badge bg-success">Inventory</span>
                        </p>
                        <p class="small mb-2"><strong>Tasks Completed:</strong><br>
                            <span class="badge bg-success">✓</span>
                        </p>
                        
                        <hr class="my-2">
                        
                        <p class="small mb-0"><strong>Inventory Items:</strong><br>
                            <span class="text-success fs-5">{{ $completedInventory }}</span> / {{ $totalInventory }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    @elseif($checklist->workflow_step === 'photos')
        {{-- STEP 3: PHOTO UPLOADS --}}
        <div class="row g-3">
            <div class="col-12 col-md-8">
                <div class="alert alert-info mb-3 mobile-photo-alert">
                    <h5 class="h6 h5-md"><i class="bi bi-info-circle"></i> Photo Upload Instructions</h5>
                    <p class="mb-0 small">Please upload at least {{ $checklist->property->rooms->first()?->min_photos ?? 8 }} photos for each room. Photos will be automatically timestamped.</p>
                </div>

                @foreach($checklist->property->rooms as $room)
                    <div class="card mb-3 mobile-photo-room-card">
                        <div class="card-header bg-info text-white p-3">
                            <h5 class="mb-0 h6 h5-md">{{ $room->name }}</h5>
                        </div>
                        <div class="card-body p-3">
                            <!-- Photo Upload Section -->
                            <div class="mb-3">
                                <h6 class="small">Photos (Minimum {{ $room->min_photos }} required)</h6>
                                <div class="row g-2 mobile-photo-grid" id="photos-room-{{ $room->id }}">
                                    @php
                                        $roomPhotos = $checklist->photos->where('room_id', $room->id);
                                    @endphp
                                    @forelse($roomPhotos as $photo)
                                        <div class="col-6 col-md-3 mb-2">
                                            <img src="{{ Storage::url($photo->file_path) }}" 
                                                 class="img-thumbnail mobile-photo-thumbnail" 
                                                 alt="Photo"
                                                 style="width: 100%; height: 150px; object-fit: cover;">
                                            <small class="d-block text-muted small text-center mt-1">{{ $photo->taken_at->format('g:i A') }}</small>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p class="text-muted small text-center py-3"><i class="bi bi-camera"></i> No photos uploaded yet</p>
                                        </div>
                                    @endforelse
                                </div>
                                <input type="file" class="form-control photo-upload mt-2 mobile-file-input" 
                                       data-room-id="{{ $room->id }}" 
                                       accept="image/*" 
                                       capture="environment" 
                                       multiple>
                                <small class="text-muted d-block mt-2 small">
                                    Photos: <strong>{{ $roomPhotos->count() }} / {{ $room->min_photos }}</strong>
                                    @if($roomPhotos->count() >= $room->min_photos)
                                        <span class="badge bg-success">✓ Complete</span>
                                    @else
                                        <span class="badge bg-warning">{{ $room->min_photos - $roomPhotos->count() }} more needed</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="card mb-3 border-success">
                    <div class="card-body text-center p-4">
                        <h5 class="h6 h5-md mb-3">Ready to Submit?</h5>
                        <p class="small mb-3">Once you've uploaded all required photos, you can review and submit the checklist.</p>
                        <a href="{{ route('housekeeper.checklist.summary', $checklist) }}" class="btn btn-success btn-lg w-100 mobile-complete-btn">
                            <i class="bi bi-clipboard-check"></i> Review & Submit Checklist
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card position-sticky mobile-progress-sidebar" style="top: 20px;">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0 h6 h5-md">Progress</h5>
                    </div>
                    <div class="card-body">
                        <p class="small mb-2"><strong>Property:</strong><br><span class="text-muted">{{ $checklist->property->name }}</span></p>
                        <p class="small mb-2"><strong>Current Step:</strong><br>
                            <span class="badge bg-info">Photos</span>
                        </p>
                        <p class="small mb-2"><strong>Tasks:</strong> <span class="badge bg-success">✓</span></p>
                        <p class="small mb-2"><strong>Inventory:</strong> <span class="badge bg-success">✓</span></p>
                        
                        <hr class="my-2">
                        
                        <p class="small mb-2"><strong>Photos Uploaded:</strong><br>
                            <span class="text-info fs-5">{{ $checklist->photos->count() }}</span> / {{ $checklist->property->rooms->sum('min_photos') }}
                        </p>

                        @php
                            $allRoomsComplete = true;
                            foreach($checklist->property->rooms as $room) {
                                if($checklist->photos->where('room_id', $room->id)->count() < $room->min_photos) {
                                    $allRoomsComplete = false;
                                    break;
                                }
                            }
                        @endphp

                        @if($allRoomsComplete)
                            <div class="alert alert-success p-2 mb-0">
                                <i class="bi bi-check-circle"></i> <small>All photos uploaded!</small>
                            </div>
                        @else
                            <div class="alert alert-warning p-2 mb-0">
                                <i class="bi bi-exclamation-triangle"></i> <small>More photos needed</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.step-indicator {
    padding: 20px;
    border-radius: 8px;
    transition: all 0.3s;
}
.step-indicator.active {
    background-color: #e3f2fd;
    border: 2px solid #2196F3;
}
.step-indicator.completed {
    background-color: #e8f5e9;
    border: 2px solid #4CAF50;
}
.step-indicator.pending {
    background-color: #f5f5f5;
    border: 2px solid #ddd;
    opacity: 0.6;
}
</style>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // GPS Start Button
    const startBtn = document.getElementById('startBtn');
    if (startBtn) {
        startBtn.addEventListener('click', function() {
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser');
                return;
            }

            document.getElementById('locationStatus').innerHTML = '<div class="alert alert-info">Getting your location...</div>';
            
            navigator.geolocation.getCurrentPosition(function(position) {
                // Submit the form with coordinates
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("housekeeper.checklist.start", $checklist) }}';
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);
                
                const latInput = document.createElement('input');
                latInput.type = 'hidden';
                latInput.name = 'latitude';
                latInput.value = position.coords.latitude;
                form.appendChild(latInput);
                
                const lonInput = document.createElement('input');
                lonInput.type = 'hidden';
                lonInput.name = 'longitude';
                lonInput.value = position.coords.longitude;
                form.appendChild(lonInput);
                
                document.body.appendChild(form);
                form.submit();
            }, function(error) {
                document.getElementById('locationStatus').innerHTML = 
                    '<div class="alert alert-danger">Unable to get your location. Please enable location services.</div>';
            });
        });
    }

    // Task Checkbox Handler with smooth animations
    document.querySelectorAll('.task-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const label = document.querySelector(`label[for="task${itemId}"]`);
            const formCheck = this.closest('.form-check');
            
            // Add loading state
            this.classList.add('loading');
            
            // Immediate visual feedback
            if (this.checked) {
                label.classList.add('text-decoration-line-through');
                formCheck.classList.add('task-completed');
            } else {
                label.classList.remove('text-decoration-line-through');
                formCheck.classList.remove('task-completed');
            }
            
            fetch(`/housekeeper/checklist/{{ $checklist->id }}/item/${itemId}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    notes: ''
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove loading state
                    this.classList.remove('loading');
                    
                    // Smooth reload with delay for visual confirmation
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                } else {
                    // Revert on error
                    this.checked = !this.checked;
                    if (this.checked) {
                        label.classList.add('text-decoration-line-through');
                        formCheck.classList.add('task-completed');
                    } else {
                        label.classList.remove('text-decoration-line-through');
                        formCheck.classList.remove('task-completed');
                    }
                    this.classList.remove('loading');
                    alert('Failed to update task. Please try again.');
                }
            })
            .catch(error => {
                // Revert on error
                this.checked = !this.checked;
                if (this.checked) {
                    label.classList.add('text-decoration-line-through');
                    formCheck.classList.add('task-completed');
                } else {
                    label.classList.remove('text-decoration-line-through');
                    formCheck.classList.remove('task-completed');
                }
                this.classList.remove('loading');
                console.error('Error:', error);
                alert('Network error. Please check your connection.');
            });
        });
    });

    // Inventory Item Complete Handler
    document.querySelectorAll('.inventory-complete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const quantity = document.querySelector(`.inventory-quantity[data-item-id="${itemId}"]`).value;
            const isAvailable = document.querySelector(`.inventory-available[data-item-id="${itemId}"]`).value;
            
            fetch(`/housekeeper/checklist/{{ $checklist->id }}/inventory/${itemId}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    quantity: parseInt(quantity),
                    is_available: isAvailable === '1',
                    notes: ''
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });
    });

    // Photo Upload Handler
    document.querySelectorAll('.photo-upload').forEach(input => {
        input.addEventListener('change', function() {
            const roomId = this.dataset.roomId;
            const files = this.files;
            
            if (files.length === 0) return;
            
            const formData = new FormData();
            formData.append('room_id', roomId);
            
            for (let i = 0; i < files.length; i++) {
                formData.append('photos[]', files[i]);
            }
            
            // Get location if available
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    formData.append('latitude', position.coords.latitude);
                    formData.append('longitude', position.coords.longitude);
                    uploadPhotos(formData);
                }, function() {
                    uploadPhotos(formData);
                });
            } else {
                uploadPhotos(formData);
            }
        });
    });
    
    function uploadPhotos(formData) {
        // Show uploading message
        const uploadBtn = document.querySelector('.photo-upload');
        if (uploadBtn) {
            uploadBtn.disabled = true;
        }
        
        fetch('{{ route("housekeeper.checklist.photo.upload", $checklist) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Upload failed');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.message || 'Error uploading photos');
                if (uploadBtn) uploadBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Upload error:', error);
            alert('Error uploading photos: ' + error.message);
            if (uploadBtn) uploadBtn.disabled = false;
        });
    }
});
</script>
@endpush
