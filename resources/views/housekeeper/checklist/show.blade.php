@extends('layouts.app')

@push('styles')
<style>
    /* Larger and more flexible checkboxes */
    .task-checkbox {
        width: 1.5rem !important;
        height: 1.5rem !important;
        cursor: pointer;
        flex-shrink: 0;
    }
    
    .form-check {
        display: flex;
        align-items: flex-start;
        padding: 12px;
        border-radius: 8px;
        transition: background-color 0.2s;
    }
    
    .form-check:hover {
        background-color: #f8f9fa;
    }
    
    .form-check-label {
        margin-left: 12px;
        cursor: pointer;
        flex: 1;
        line-height: 1.5rem;
    }
    
    .form-check-input:checked ~ .form-check-label {
        color: #6c757d;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="bi bi-clipboard-check"></i> Checklist for {{ $checklist->property->name }}</h2>
            <p class="text-muted">
                <i class="bi bi-calendar-event"></i> Scheduled: {{ $checklist->scheduled_date->format('M d, Y') }}
                @if($checklist->scheduled_time)
                    <i class="bi bi-clock ms-2"></i> {{ date('g:i A', strtotime($checklist->scheduled_time)) }}
                @endif
                @if($checklist->status !== 'pending')
                    | <i class="bi bi-clock"></i> Started: {{ $checklist->started_at->format('g:i A') }}
                @endif
            </p>
        </div>
    </div>

    {{-- Step Progress Indicator - Enhanced --}}
    @if($checklist->status !== 'pending')
    <div class="card mb-4 border-primary shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-signpost-split"></i> Your 3-Step Workflow</h5>
        </div>
        <div class="card-body">
            <div class="row text-center g-3">
                <div class="col-md-4">
                    <div class="step-indicator {{ $checklist->workflow_step === 'tasks' ? 'active border-3 border-primary bg-light' : ($checklist->tasks_completed_at ? 'completed' : 'pending') }}" 
                         style="padding: 20px; border-radius: 10px; {{ $checklist->workflow_step === 'tasks' ? 'box-shadow: 0 4px 8px rgba(0,123,255,0.3);' : '' }}">
                        <div class="mb-2">
                            @if($checklist->tasks_completed_at)
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                            @elseif($checklist->workflow_step === 'tasks')
                                <i class="bi bi-arrow-right-circle-fill text-primary" style="font-size: 3rem;"></i>
                            @else
                                <i class="bi bi-list-check text-muted" style="font-size: 3rem;"></i>
                            @endif
                        </div>
                        <h5 class="mb-2">Step 1: Room Tasks</h5>
                        @if($checklist->tasks_completed_at)
                            <span class="badge bg-success">✓ Completed</span>
                        @elseif($checklist->workflow_step === 'tasks')
                            <span class="badge bg-primary">▶ Active Now</span>
                            <p class="small text-muted mt-2 mb-0">Complete all tasks room-by-room</p>
                        @else
                            <span class="badge bg-secondary">Pending</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-indicator {{ $checklist->workflow_step === 'inventory' ? 'active border-3 border-info bg-light' : ($checklist->inventory_completed_at ? 'completed' : 'pending') }}"
                         style="padding: 20px; border-radius: 10px; {{ $checklist->workflow_step === 'inventory' ? 'box-shadow: 0 4px 8px rgba(13,202,240,0.3);' : '' }}">
                        <div class="mb-2">
                            @if($checklist->inventory_completed_at)
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                            @elseif($checklist->workflow_step === 'inventory')
                                <i class="bi bi-arrow-right-circle-fill text-info" style="font-size: 3rem;"></i>
                            @else
                                <i class="bi bi-box-seam text-muted" style="font-size: 3rem;"></i>
                            @endif
                        </div>
                        <h5 class="mb-2">Step 2: Inventory</h5>
                        @if($checklist->inventory_completed_at)
                            <span class="badge bg-success">✓ Completed</span>
                        @elseif($checklist->workflow_step === 'inventory')
                            <span class="badge bg-info">▶ Active Now</span>
                            <p class="small text-muted mt-2 mb-0">Check all 12 items</p>
                        @else
                            <span class="badge bg-secondary">🔒 Locked</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-indicator {{ $checklist->workflow_step === 'photos' ? 'active border-3 border-success bg-light' : 'pending' }}"
                         style="padding: 20px; border-radius: 10px; {{ $checklist->workflow_step === 'photos' ? 'box-shadow: 0 4px 8px rgba(25,135,84,0.3);' : '' }}">
                        <div class="mb-2">
                            @if($checklist->workflow_step === 'photos')
                                <i class="bi bi-arrow-right-circle-fill text-success" style="font-size: 3rem;"></i>
                            @else
                                <i class="bi bi-camera text-muted" style="font-size: 3rem;"></i>
                            @endif
                        </div>
                        <h5 class="mb-2">Step 3: Photos</h5>
                        @if($checklist->workflow_step === 'photos')
                            <span class="badge bg-success">▶ Active Now</span>
                            <p class="small text-muted mt-2 mb-0">Upload photos of each room</p>
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
        <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
            <h5><i class="bi bi-info-circle"></i> Before You Start:</h5>
            <ul class="mb-0">
                <li>Make sure you're at <strong>{{ $checklist->property->address }}</strong></li>
                <li>You'll need to allow location access to verify you're on-site</li>
                <li>Have your phone/camera ready for taking photos later</li>
                <li>The checklist has <strong>{{ $checklist->property->rooms->count() }} rooms</strong> to complete</li>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        {{-- GPS Start Section --}}
        <div class="card mb-4 border-success shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="bi bi-geo-alt"></i> Ready to Start?</h4>
            </div>
            <div class="card-body text-center py-5">
                <i class="bi bi-play-circle" style="font-size: 4rem; color: #198754;"></i>
                <h4 class="mt-3">Let's Begin Your Checklist!</h4>
                <p class="text-muted mb-4">We'll verify your location first, then you can start cleaning room by room.</p>
                <button id="startBtn" class="btn btn-success btn-lg">
                    <i class="bi bi-play-circle"></i> Start Checklist
                </button>
                <div id="locationStatus" class="mt-3"></div>
            </div>
        </div>
    @elseif($checklist->workflow_step === 'tasks')
        {{-- STEP 1: ROOM-BY-ROOM TASKS --}}
        <div class="row">
            <div class="col-md-8">
                @if($checklist->currentRoom)
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-door-open"></i> Current Room: {{ $checklist->currentRoom->name }}
                            </h5>
                            <small>Complete all tasks in this room before moving to the next</small>
                        </div>
                        <div class="card-body">
                            <h6>Tasks to Complete:</h6>
                            @php
                                $roomItems = $checklist->items->where('room_id', $checklist->current_room_id);
                                $completedCount = $roomItems->where('is_completed', true)->count();
                                $totalCount = $roomItems->count();
                            @endphp
                            
                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ $totalCount > 0 ? ($completedCount / $totalCount * 100) : 0 }}%"
                                     aria-valuenow="{{ $completedCount }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="{{ $totalCount }}">
                                    {{ $completedCount }} / {{ $totalCount }}
                                </div>
                            </div>

                            @foreach($roomItems as $item)
                                <div class="form-check mb-3">
                                    <input class="form-check-input task-checkbox" type="checkbox" 
                                           id="task{{ $item->id }}" 
                                           data-item-id="{{ $item->id }}"
                                           {{ $item->is_completed ? 'checked' : '' }}>
                                    <label class="form-check-label {{ $item->is_completed ? 'text-decoration-line-through' : '' }}" 
                                           for="task{{ $item->id }}">
                                        <strong>{{ $item->task->name }}</strong>
                                        @if($item->task->description)
                                            <small class="text-muted d-block mt-1">{{ $item->task->description }}</small>
                                        @endif
                                    </label>
                                </div>
                            @endforeach

                            <hr>
                            <form action="{{ route('housekeeper.checklist.room.complete', $checklist) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg w-100" 
                                        {{ $completedCount < $totalCount ? 'disabled' : '' }}>
                                    <i class="bi bi-check-circle"></i> Complete {{ $checklist->currentRoom->name }} & Continue
                                </button>
                                @if($completedCount < $totalCount)
                                    <small class="text-muted d-block mt-2 text-center">
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
                        <div class="card mb-3 border-secondary">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0"><i class="bi bi-lock"></i> Upcoming Rooms</h6>
                            </div>
                            <div class="card-body">
                                @foreach($upcomingRooms as $room)
                                    <div class="text-muted mb-1">
                                        <i class="bi bi-circle"></i> {{ $room->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <div class="alert alert-success">
                        <h5>All Room Tasks Completed!</h5>
                        <p>Proceeding to inventory checklist...</p>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card position-sticky" style="top: 20px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Progress</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Property:</strong> {{ $checklist->property->name }}</p>
                        <p><strong>Current Step:</strong> 
                            <span class="badge bg-primary">Room Tasks</span>
                        </p>
                        <p><strong>Started:</strong> {{ $checklist->started_at?->format('g:i A') }}</p>
                        
                        <hr>
                        
                        <p><strong>Overall Tasks:</strong><br>
                            {{ $checklist->items->where('is_completed', true)->count() }} / {{ $checklist->items->count() }}
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
                        
                        <p><strong>Rooms Completed:</strong><br>
                            {{ $completedRooms }} / {{ $totalRooms }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    @elseif($checklist->workflow_step === 'inventory')
        {{-- STEP 2: INVENTORY CHECKLIST --}}
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-box-seam"></i> Inventory Checklist
                        </h5>
                        <small>Verify and count all items for this property</small>
                    </div>
                    <div class="card-body">
                        @php
                            $completedInventory = $checklist->inventoryItems->where('is_completed', true)->count();
                            $totalInventory = $checklist->inventoryItems->count();
                        @endphp
                        
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ $totalInventory > 0 ? ($completedInventory / $totalInventory * 100) : 0 }}%"
                                 aria-valuenow="{{ $completedInventory }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="{{ $totalInventory }}">
                                {{ $completedInventory }} / {{ $totalInventory }}
                            </div>
                        </div>

                        @foreach($checklist->inventoryItems as $item)
                            <div class="card mb-2 {{ $item->is_completed ? 'border-success' : '' }}">
                                <div class="card-body p-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <strong>{{ $item->item_name }}</strong>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control form-control-sm inventory-quantity" 
                                                   data-item-id="{{ $item->id }}"
                                                   placeholder="Quantity" 
                                                   value="{{ $item->quantity }}"
                                                   {{ $item->is_completed ? 'readonly' : '' }}>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select form-select-sm inventory-available" 
                                                    data-item-id="{{ $item->id }}"
                                                    {{ $item->is_completed ? 'disabled' : '' }}>
                                                <option value="1" {{ $item->is_available ? 'selected' : '' }}>Available</option>
                                                <option value="0" {{ !$item->is_available ? 'selected' : '' }}>Not Available</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
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
                            <button type="submit" class="btn btn-success btn-lg w-100" 
                                    {{ $completedInventory < $totalInventory ? 'disabled' : '' }}>
                                <i class="bi bi-check-circle"></i> Complete Inventory & Continue to Photos
                            </button>
                            @if($completedInventory < $totalInventory)
                                <small class="text-muted d-block mt-2 text-center">
                                    Check all inventory items to proceed
                                </small>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card position-sticky" style="top: 20px;">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Progress</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Property:</strong> {{ $checklist->property->name }}</p>
                        <p><strong>Current Step:</strong> 
                            <span class="badge bg-success">Inventory</span>
                        </p>
                        <p><strong>Tasks Completed:</strong> 
                            <span class="badge bg-success">✓</span>
                        </p>
                        
                        <hr>
                        
                        <p><strong>Inventory Items:</strong><br>
                            {{ $completedInventory }} / {{ $totalInventory }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    @elseif($checklist->workflow_step === 'photos')
        {{-- STEP 3: PHOTO UPLOADS --}}
        <div class="row">
            <div class="col-md-8">
                <div class="alert alert-info mb-3">
                    <h5><i class="bi bi-info-circle"></i> Photo Upload Instructions</h5>
                    <p class="mb-0">Please upload at least {{ $checklist->property->rooms->first()?->min_photos ?? 8 }} photos for each room. Photos will be automatically timestamped.</p>
                </div>

                @foreach($checklist->property->rooms as $room)
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">{{ $room->name }}</h5>
                        </div>
                        <div class="card-body">
                            <!-- Photo Upload Section -->
                            <div class="mb-3">
                                <h6>Photos (Minimum {{ $room->min_photos }} required)</h6>
                                <div class="row" id="photos-room-{{ $room->id }}">
                                    @php
                                        $roomPhotos = $checklist->photos->where('room_id', $room->id);
                                    @endphp
                                    @forelse($roomPhotos as $photo)
                                        <div class="col-md-3 mb-2">
                                            <img src="{{ Storage::url($photo->file_path) }}" 
                                                 class="img-thumbnail" 
                                                 alt="Photo"
                                                 style="width: 100%; height: 200px; object-fit: cover;">
                                            <small class="d-block text-muted">{{ $photo->taken_at->format('g:i A') }}</small>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p class="text-muted"><i class="bi bi-camera"></i> No photos uploaded yet</p>
                                        </div>
                                    @endforelse
                                </div>
                                <input type="file" class="form-control photo-upload mt-2" 
                                       data-room-id="{{ $room->id }}" 
                                       accept="image/*" 
                                       capture="environment" 
                                       multiple>
                                <small class="text-muted">
                                    Photos: {{ $roomPhotos->count() }} / {{ $room->min_photos }}
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
                    <div class="card-body text-center">
                        <h5>Ready to Submit?</h5>
                        <p>Once you've uploaded all required photos, you can review and submit the checklist.</p>
                        <a href="{{ route('housekeeper.checklist.summary', $checklist) }}" class="btn btn-success btn-lg">
                            <i class="bi bi-clipboard-check"></i> Review & Submit Checklist
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card position-sticky" style="top: 20px;">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Progress</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Property:</strong> {{ $checklist->property->name }}</p>
                        <p><strong>Current Step:</strong> 
                            <span class="badge bg-info">Photos</span>
                        </p>
                        <p><strong>Tasks:</strong> <span class="badge bg-success">✓</span></p>
                        <p><strong>Inventory:</strong> <span class="badge bg-success">✓</span></p>
                        
                        <hr>
                        
                        <p><strong>Photos Uploaded:</strong><br>
                            {{ $checklist->photos->count() }} / {{ $checklist->property->rooms->sum('min_photos') }}
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
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle"></i> All photos uploaded!
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> More photos needed
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

    // Task Checkbox Handler
    document.querySelectorAll('.task-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const label = document.querySelector(`label[for="task${itemId}"]`);
            
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
                    if (this.checked) {
                        label.classList.add('text-decoration-line-through');
                    } else {
                        label.classList.remove('text-decoration-line-through');
                    }
                    // Reload to update progress
                    setTimeout(() => location.reload(), 500);
                }
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
