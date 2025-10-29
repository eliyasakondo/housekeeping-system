@extends('layouts.app')

@section('content')
<style>
    @media (max-width: 768px) {
        /* Container padding for mobile */
        .container {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        
        /* Card adjustments */
        .mobile-summary-card {
            border-radius: 0;
            margin-bottom: 0;
        }
        
        .mobile-summary-card .card-header {
            padding: 1rem !important;
        }
        
        .mobile-summary-card .card-header h4 {
            font-size: 1.1rem !important;
        }
        
        .mobile-summary-card .card-body {
            padding: 1rem !important;
        }
        
        /* Alert styling */
        .mobile-alert {
            padding: 0.75rem !important;
            font-size: 0.9rem !important;
        }
        
        /* Property info */
        .mobile-property-info h5 {
            font-size: 1rem !important;
        }
        
        .mobile-property-info p {
            font-size: 0.85rem !important;
        }
        
        /* Room sections */
        .mobile-room-section h5 {
            font-size: 1rem !important;
        }
        
        .mobile-room-section h6 {
            font-size: 0.9rem !important;
        }
        
        /* Task list */
        .mobile-task-list .list-group-item {
            padding: 0.75rem !important;
            font-size: 0.9rem !important;
        }
        
        .mobile-task-list .list-group-item i {
            font-size: 1.2rem !important;
        }
        
        /* Photo grid - 2 columns on mobile */
        .mobile-photo-grid {
            gap: 0.5rem !important;
        }
        
        .mobile-photo-item {
            margin-bottom: 0.5rem;
        }
        
        .mobile-photo-item img {
            height: 120px !important;
            object-fit: cover;
            border-radius: 0.5rem;
        }
        
        .mobile-photo-item small {
            font-size: 0.75rem !important;
        }
        
        /* Action buttons */
        .mobile-action-buttons {
            flex-direction: column !important;
            gap: 0.75rem;
        }
        
        .mobile-action-buttons .btn {
            width: 100% !important;
            padding: 1rem !important;
            font-size: 1rem !important;
            min-height: 48px;
        }
        
        .mobile-action-buttons form {
            width: 100%;
        }
        
        /* Badge adjustments */
        .badge {
            font-size: 0.75rem !important;
            padding: 0.35rem 0.6rem !important;
        }
        
        /* Separator lines */
        hr {
            margin: 1rem 0 !important;
        }
    }
    
    @media (max-width: 375px) {
        /* Extra small phones */
        .mobile-summary-card .card-header h4 {
            font-size: 1rem !important;
        }
        
        .mobile-photo-item img {
            height: 100px !important;
        }
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card mobile-summary-card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="bi bi-check-circle me-2"></i>Checklist Summary - Review Before Submitting</h4>
                </div>

                <div class="card-body">
                    <div class="alert alert-info mobile-alert">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Review your work:</strong> Please review all completed tasks and uploaded photos below. You can go back to make changes before final submission.
                    </div>

                    <div class="mb-4 mobile-property-info">
                        <h5><strong>Property:</strong> {{ $checklist->property->name }}</h5>
                        <p class="text-muted mb-0">
                            <strong>Date:</strong> {{ $checklist->scheduled_date->format('l, F j, Y') }}
                            @if($checklist->scheduled_time)
                                <br class="d-md-none">at {{ date('g:i A', strtotime($checklist->scheduled_time)) }}
                            @endif
                            <br>
                            <strong>Started:</strong> {{ $checklist->started_at->format('g:i A') }}
                        </p>
                    </div>

                    <hr>

                    @foreach($itemsByRoom as $roomId => $items)
                        @php
                            $room = $items->first()->room;
                            $photos = $photosByRoom[$roomId] ?? collect();
                        @endphp

                        <div class="mb-4 mobile-room-section">
                            <h5 class="text-primary">
                                <i class="bi bi-door-open me-2"></i>{{ $room->name }}
                            </h5>

                            <!-- Tasks for this room -->
                            <div class="mb-3">
                                <h6 class="text-muted">Completed Tasks:</h6>
                                <ul class="list-group mobile-task-list">
                                    @foreach($items as $item)
                                        <li class="list-group-item">
                                            @if($item->is_completed)
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            @else
                                                <i class="bi bi-circle text-muted me-2"></i>
                                            @endif
                                            {{ $item->task->name }}
                                            @if($item->notes)
                                                <br><small class="text-muted ms-4">Note: {{ $item->notes }}</small>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Photos for this room -->
                            <div class="mb-3">
                                <h6 class="text-muted">
                                    Photos Uploaded: 
                                    <span class="badge bg-{{ $photos->count() >= $room->min_photos ? 'success' : 'warning' }}">
                                        {{ $photos->count() }} / {{ $room->min_photos }} required
                                    </span>
                                </h6>
                                <div class="row g-2 mobile-photo-grid">
                                    @foreach($photos as $photo)
                                        <div class="col-6 col-md-3 mobile-photo-item">
                                            <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                                 class="img-fluid rounded w-100" 
                                                 alt="Photo"
                                                 style="height: 150px; object-fit: cover;">
                                            <small class="text-muted d-block text-center mt-1">
                                                {{ $photo->created_at->format('g:i A') }}
                                            </small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr>
                        </div>
                    @endforeach

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4 mobile-action-buttons">
                        <a href="{{ route('housekeeper.checklist.show', $checklist) }}" class="btn btn-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Go Back & Make Changes
                        </a>
                        
                        <form action="{{ route('housekeeper.checklist.complete', $checklist) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle-fill me-2"></i>Confirm & Submit Checklist
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
