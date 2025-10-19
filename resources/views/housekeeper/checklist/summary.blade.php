@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="bi bi-check-circle me-2"></i>Checklist Summary - Review Before Submitting</h4>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Review your work:</strong> Please review all completed tasks and uploaded photos below. You can go back to make changes before final submission.
                    </div>

                    <div class="mb-4">
                        <h5><strong>Property:</strong> {{ $checklist->property->name }}</h5>
                        <p class="text-muted mb-0">
                            <strong>Date:</strong> {{ $checklist->scheduled_date->format('l, F j, Y') }}
                            @if($checklist->scheduled_time)
                                at {{ date('g:i A', strtotime($checklist->scheduled_time)) }}
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

                        <div class="mb-4">
                            <h5 class="text-primary">
                                <i class="bi bi-door-open me-2"></i>{{ $room->name }}
                            </h5>

                            <!-- Tasks for this room -->
                            <div class="mb-3">
                                <h6 class="text-muted">Completed Tasks:</h6>
                                <ul class="list-group">
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
                                <div class="row g-2">
                                    @foreach($photos as $photo)
                                        <div class="col-md-3">
                                            <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                                 class="img-fluid rounded" 
                                                 alt="Photo">
                                            <small class="text-muted d-block">
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
                    <div class="d-flex justify-content-between mt-4">
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
