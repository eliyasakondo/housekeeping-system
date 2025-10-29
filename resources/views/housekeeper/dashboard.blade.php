@extends('layouts.app')

@section('content')
<div class="container-fluid px-2 px-md-3">
    <div class="row mb-3 mb-md-4">
        <div class="col-12">
            <h2 class="h4 h3-md"><i class="bi bi-clipboard-check"></i> My Checklists</h2>
            <p class="text-muted mb-0 small">Hello, {{ auth()->user()->name }}!</p>
        </div>
    </div>

    <!-- Instructions for New Housekeepers -->
    @if($stats['total_completed'] == 0)
    <div class="row mb-3 mb-md-4">
        <div class="col-12">
            <div class="alert alert-success border-0 shadow-sm mobile-alert fade-in" role="alert">
                <div class="d-flex align-items-start">
                    <div class="me-2 me-md-3">
                        <i class="bi bi-lightbulb-fill" style="font-size: 2rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h4 class="mb-2 mb-md-3 h6 h5-md"><strong>Welcome! Here's Your 5-Step Workflow:</strong></h4>
                        <div class="row g-2">
                            <div class="col-12 col-md-6">
                                <div class="mb-2 p-2 rounded small" style="background: rgba(255,255,255,0.5);">
                                    <strong>1. Start a Checklist</strong> - Click the green button below
                                </div>
                                <div class="mb-2 p-2 rounded small" style="background: rgba(255,255,255,0.5);">
                                    <strong>2. Complete Tasks</strong> - Go room-by-room, checking off each task
                                </div>
                                <div class="mb-2 p-2 rounded small" style="background: rgba(255,255,255,0.5);">
                                    <strong>3. Check Inventory</strong> - Verify all 12 items (towels, soap, etc.)
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-2 p-2 rounded small" style="background: rgba(255,255,255,0.5);">
                                    <strong>4. Upload Photos</strong> - Take photos of each room as proof
                                </div>
                                <div class="mb-2 p-2 rounded small" style="background: rgba(255,255,255,0.5);">
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

    <div class="row g-2 g-md-4 mb-3 mb-md-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card warning hover-lift fade-in mobile-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="text-muted mb-0 small">Pending</h6>
                        <i class="bi bi-hourglass-split text-warning fs-4 d-none d-md-block" style="opacity: 0.3;"></i>
                    </div>
                    <h2 class="mb-0 h4 h3-md">{{ $stats['pending'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card primary hover-lift fade-in mobile-stat-card" style="animation-delay: 0.1s;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="text-muted mb-0 small">In Progress</h6>
                        <i class="bi bi-play-circle text-primary fs-4 d-none d-md-block" style="opacity: 0.3;"></i>
                    </div>
                    <h2 class="mb-0 h4 h3-md">{{ $stats['in_progress'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card success hover-lift fade-in mobile-stat-card" style="animation-delay: 0.2s;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="text-muted mb-0 small">Completed Today</h6>
                        <i class="bi bi-check-circle text-success fs-4 d-none d-md-block" style="opacity: 0.3;"></i>
                    </div>
                    <h2 class="mb-0 h4 h3-md">{{ $stats['completed_today'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card info hover-lift fade-in mobile-stat-card" style="animation-delay: 0.3s;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="text-muted mb-0 small">Total Completed</h6>
                        <i class="bi bi-trophy text-info fs-4 d-none d-md-block" style="opacity: 0.3;"></i>
                    </div>
                    <h2 class="mb-0 h4 h3-md">{{ $stats['total_completed'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    @if($in_progress->count() > 0)
    <div class="row mt-3 mt-md-4 mb-3 mb-md-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm mobile-progress-card" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">
                <div class="card-header border-0 p-3" style="background: transparent;">
                    <h3 class="mb-0 text-white h5 h4-md">
                        <i class="bi bi-exclamation-circle-fill"></i> You Have Work In Progress!
                    </h3>
                </div>
                <div class="card-body p-2 p-md-3">
                    @foreach($in_progress as $checklist)
                        <div class="card border-0 shadow-sm mb-3 hover-lift mobile-checklist-card">
                            <div class="card-body p-3">
                                <div class="row align-items-center g-2">
                                    <div class="col-12 col-md-8">
                                        <h3 class="mb-2 mb-md-3 h5 h4-md">
                                            <i class="bi bi-building"></i> {{ $checklist->property->name }}
                                        </h3>
                                        <div class="row g-2 mb-2 mb-md-3">
                                            <div class="col-12 col-md-6">
                                                <p class="mb-2 small">
                                                    <i class="bi bi-clock-fill text-primary"></i>
                                                    <strong>Started:</strong>
                                                    <span class="badge bg-primary">{{ $checklist->started_at->format('M d, g:i A') }}</span>
                                                </p>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <p class="mb-0 small">
                                                    <i class="bi bi-list-check text-success"></i>
                                                    <strong>Current Step:</strong>
                                                    @if($checklist->workflow_step === 'tasks')
                                                        <span class="badge bg-primary">
                                                            <i class="bi bi-1-circle"></i> Room Tasks
                                                        </span>
                                                    @elseif($checklist->workflow_step === 'inventory')
                                                        <span class="badge bg-info">
                                                            <i class="bi bi-2-circle"></i> Inventory
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-3-circle"></i> Photos
                                                        </span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 text-center text-md-end">
                                        <a href="{{ route('housekeeper.checklist.show', $checklist) }}"
                                           class="btn btn-warning btn-lg shadow-sm hover-lift w-100 w-md-auto mobile-btn"
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

    <div class="row mt-3 mt-md-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm mobile-upcoming-card">
                <div class="card-header bg-success text-white border-0 p-3">
                    <h4 class="mb-0 h6 h5-md"><i class="bi bi-calendar-check-fill"></i> Your Upcoming Tasks</h4>
                </div>
                <div class="card-body p-2 p-md-4">
                    @forelse($upcoming as $checklist)
                        <div class="card mb-3 border-0 shadow-sm hover-lift mobile-checklist-card">
                            <div class="card-body p-3">
                                <div class="row align-items-center g-2">
                                    <div class="col-12 col-md-5">
                                        <h4 class="mb-2 mb-md-3 h6 h5-md">
                                            <i class="bi bi-building-fill text-primary"></i>
                                            {{ $checklist->property->name }}
                                        </h4>
                                        <p class="text-muted mb-2 small">
                                            <i class="bi bi-geo-alt-fill"></i>
                                            {{ $checklist->property->address }}
                                        </p>
                                        <p class="mb-0 small">
                                            <i class="bi bi-door-open-fill text-info"></i>
                                            <strong>{{ $checklist->property->rooms->count() }} rooms</strong> to clean
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-4 text-center">
                                        <div class="mb-2">
                                            <span class="badge text-white shadow-sm mobile-date-badge" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); padding: 0.5rem 1rem;">
                                                <i class="bi bi-calendar-event"></i>
                                                {{ $checklist->scheduled_date->format('M d, Y') }}
                                            </span>
                                            @if($checklist->scheduled_time)
                                                <br><small class="text-muted mt-1 d-block"><i class="bi bi-clock"></i> {{ date('g:i A', strtotime($checklist->scheduled_time)) }}</small>
                                            @endif
                                        </div>
                                        <p class="text-muted mb-0 small">
                                            <i class="bi bi-clock"></i> {{ $checklist->scheduled_date->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-3 text-center text-md-end">
                                        <a href="{{ route('housekeeper.checklist.show', $checklist) }}"
                                           class="btn btn-success btn-lg shadow-sm hover-lift w-100 w-md-auto mobile-btn mb-2">
                                            <i class="bi bi-play-circle-fill"></i> Start Checklist
                                        </a>
                                        <small class="text-muted d-block small">
                                            <i class="bi bi-signpost-2-fill"></i> 3-Step Process
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-inbox mobile-empty-icon" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="text-muted mt-3 mb-0 small">
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

<style>
    /* Mobile Responsive Styles for Housekeeper Dashboard */
    @media (max-width: 768px) {
        /* Typography */
        .h3-md { font-size: 1.5rem !important; }
        .h4-md { font-size: 1.25rem !important; }
        .h5-md { font-size: 1.1rem !important; }
        .h6 { font-size: 0.95rem !important; }
        
        /* Container padding */
        .container-fluid {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        
        /* Alert mobile optimization */
        .mobile-alert {
            font-size: 0.85rem;
            padding: 0.75rem !important;
        }
        
        .mobile-alert .bi-lightbulb-fill {
            font-size: 1.5rem !important;
        }
        
        /* Stat cards mobile */
        .mobile-stat-card .card-body {
            padding: 0.75rem !important;
        }
        
        .mobile-stat-card h2 {
            font-size: 1.75rem !important;
        }
        
        .mobile-stat-card h6 {
            font-size: 0.75rem !important;
        }
        
        /* Progress card mobile */
        .mobile-progress-card .card-header {
            padding: 0.75rem !important;
        }
        
        .mobile-progress-card .card-header h3 {
            font-size: 1rem !important;
        }
        
        /* Checklist cards mobile */
        .mobile-checklist-card {
            margin-bottom: 1rem !important;
        }
        
        .mobile-checklist-card .card-body {
            padding: 1rem !important;
        }
        
        .mobile-checklist-card h3,
        .mobile-checklist-card h4 {
            font-size: 1.1rem !important;
        }
        
        /* Buttons mobile */
        .mobile-btn {
            padding: 0.75rem 1.25rem !important;
            font-size: 0.95rem !important;
            min-height: 48px;
        }
        
        /* Date badge mobile */
        .mobile-date-badge {
            padding: 0.5rem 0.75rem !important;
            font-size: 0.85rem !important;
        }
        
        /* Upcoming card mobile */
        .mobile-upcoming-card .card-header {
            padding: 0.75rem !important;
        }
        
        .mobile-upcoming-card .card-header h4 {
            font-size: 1rem !important;
        }
        
        /* Empty icon mobile */
        .mobile-empty-icon {
            font-size: 2.5rem !important;
        }
        
        /* Badge sizing */
        .badge {
            font-size: 0.75rem !important;
            padding: 0.35rem 0.65rem !important;
        }
    }
    
    /* Touch-friendly tap targets */
    @media (max-width: 768px) {
        .btn,
        .card {
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0.1);
        }
        
        .hover-lift:active {
            transform: scale(0.98);
        }
    }
    
    /* Small phone optimization */
    @media (max-width: 375px) {
        .mobile-stat-card h2 {
            font-size: 1.5rem !important;
        }
        
        .mobile-btn {
            padding: 0.65rem 1rem !important;
            font-size: 0.9rem !important;
        }
        
        .badge {
            font-size: 0.7rem !important;
        }
    }
</style>
@endsection
