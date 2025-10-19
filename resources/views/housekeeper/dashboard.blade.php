@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="bi bi-clipboard-check"></i> My Checklists</h2>
            <p class="text-muted">Hello, {{ auth()->user()->name }}!</p>
        </div>
    </div>

    <!-- Instructions for New Housekeepers -->
    @if($stats['total_completed'] == 0)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-success border-0 shadow-lg fade-in" role="alert">
                <div class="d-flex align-items-start">
                    <div class="me-3">
                        <i class="bi bi-lightbulb-fill" style="font-size: 2.5rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h4 class="mb-3"><strong>Welcome! Here's Your 5-Step Workflow:</strong></h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2 p-2 rounded" style="background: rgba(255,255,255,0.5);">
                                    <strong>1. Start a Checklist</strong> - Click the green button below
                                </div>
                                <div class="mb-2 p-2 rounded" style="background: rgba(255,255,255,0.5);">
                                    <strong>2. Complete Tasks</strong> - Go room-by-room, checking off each task
                                </div>
                                <div class="mb-2 p-2 rounded" style="background: rgba(255,255,255,0.5);">
                                    <strong>3. Check Inventory</strong> - Verify all 12 items (towels, soap, etc.)
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2 p-2 rounded" style="background: rgba(255,255,255,0.5);">
                                    <strong>4. Upload Photos</strong> - Take photos of each room as proof
                                </div>
                                <div class="mb-2 p-2 rounded" style="background: rgba(255,255,255,0.5);">
                                    <strong>5. Review & Submit</strong> - Review everything and submit
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card warning hover-lift fade-in">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="text-muted mb-0">Pending</h6>
                        <i class="bi bi-hourglass-split text-warning" style="font-size: 1.5rem; opacity: 0.3;"></i>
                    </div>
                    <h2 class="mb-0">{{ $stats['pending'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card primary hover-lift fade-in" style="animation-delay: 0.1s;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="text-muted mb-0">In Progress</h6>
                        <i class="bi bi-play-circle text-primary" style="font-size: 1.5rem; opacity: 0.3;"></i>
                    </div>
                    <h2 class="mb-0">{{ $stats['in_progress'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card success hover-lift fade-in" style="animation-delay: 0.2s;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="text-muted mb-0">Completed Today</h6>
                        <i class="bi bi-check-circle text-success" style="font-size: 1.5rem; opacity: 0.3;"></i>
                    </div>
                    <h2 class="mb-0">{{ $stats['completed_today'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card info hover-lift fade-in" style="animation-delay: 0.3s;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="text-muted mb-0">Total Completed</h6>
                        <i class="bi bi-trophy text-info" style="font-size: 1.5rem; opacity: 0.3;"></i>
                    </div>
                    <h2 class="mb-0">{{ $stats['total_completed'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    @if($in_progress->count() > 0)
    <div class="row mt-4 mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-xl" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">
                <div class="card-header border-0" style="background: transparent;">
                    <h3 class="mb-0 text-white">
                        <i class="bi bi-exclamation-circle-fill"></i> You Have Work In Progress!
                    </h3>
                </div>
                <div class="card-body">
                    @foreach($in_progress as $checklist)
                        <div class="card border-0 shadow-lg mb-3 hover-lift">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h3 class="mb-3">
                                            <i class="bi bi-building"></i> {{ $checklist->property->name }}
                                        </h3>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <p class="mb-2">
                                                    <i class="bi bi-clock-fill text-primary"></i>
                                                    <strong>Started:</strong>
                                                    <span class="badge bg-primary">{{ $checklist->started_at->format('M d, Y g:i A') }}</span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-0">
                                                    <i class="bi bi-list-check text-success"></i>
                                                    <strong>Current Step:</strong>
                                                    @if($checklist->workflow_step === 'tasks')
                                                        <span class="badge bg-primary fs-6">
                                                            <i class="bi bi-1-circle"></i> Room Tasks
                                                        </span>
                                                    @elseif($checklist->workflow_step === 'inventory')
                                                        <span class="badge bg-info fs-6">
                                                            <i class="bi bi-2-circle"></i> Inventory
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success fs-6">
                                                            <i class="bi bi-3-circle"></i> Photos
                                                        </span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="{{ route('housekeeper.checklist.show', $checklist) }}"
                                           class="btn btn-warning btn-lg shadow-lg hover-lift"
                                           style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">
                                            <i class="bi bi-arrow-right-circle-fill"></i> Continue Working
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-success text-white border-0">
                    <h4 class="mb-0"><i class="bi bi-calendar-check-fill"></i> Your Upcoming Tasks</h4>
                </div>
                <div class="card-body p-4">
                    @forelse($upcoming as $checklist)
                        <div class="card mb-4 border-0 shadow-md hover-lift">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        <h4 class="mb-3">
                                            <i class="bi bi-building-fill text-primary"></i>
                                            {{ $checklist->property->name }}
                                        </h4>
                                        <p class="text-muted mb-2">
                                            <i class="bi bi-geo-alt-fill"></i>
                                            {{ $checklist->property->address }}
                                        </p>
                                        <p class="mb-0">
                                            <i class="bi bi-door-open-fill text-info"></i>
                                            <strong>{{ $checklist->property->rooms->count() }} rooms</strong> to clean
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="mb-3">
                                            <span class="badge text-white fs-5 shadow-lg" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); padding: 0.75rem 1.5rem;">
                                                <i class="bi bi-calendar-event"></i>
                                                {{ $checklist->scheduled_date->format('M d, Y') }}
                                            </span>
                                            @if($checklist->scheduled_time)
                                                <br><small class="text-muted mt-1"><i class="bi bi-clock"></i> {{ date('g:i A', strtotime($checklist->scheduled_time)) }}</small>
                                            @endif
                                        </div>
                                        <p class="text-muted mb-0">
                                            <i class="bi bi-clock"></i> {{ $checklist->scheduled_date->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <a href="{{ route('housekeeper.checklist.show', $checklist) }}"
                                           class="btn btn-success btn-lg shadow-lg hover-lift d-block mb-2">
                                            <i class="bi bi-play-circle-fill"></i> Start Checklist
                                        </a>
                                        <small class="text-muted">
                                            <i class="bi bi-signpost-2-fill"></i> 3-Step Process
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 4rem; opacity: 0.3;"></i>
                            <p class="text-muted mt-3 mb-0">
                                <strong>No upcoming tasks scheduled.</strong><br>
                                Enjoy your break! 😊
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
