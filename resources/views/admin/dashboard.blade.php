@extends('layouts.app')

@section('title')
    @php
        $appName = config('app.name', 'HK Checklist');
        if (Storage::disk('local')->exists('settings.json')) {
            $settings = json_decode(Storage::disk('local')->get('settings.json'), true);
            $appName = $settings['app_name'] ?? $appName;
        }
    @endphp
    Dashboard - {{ $appName }}
@endsection

@section('content')
<div class="container-fluid px-4">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg" style="background: var(--primary-gradient); border-radius: 20px;">
                <div class="card-body py-4 px-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="text-white mb-2 fw-bold" style="font-size: 2rem;">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard Overview
                            </h1>
                            <p class="text-white mb-0" style="font-size: 1.1rem; opacity: 0.95;">
                                <i class="bi bi-person-circle me-2"></i>Welcome back, <strong>{{ auth()->user()->name }}</strong>
                                <span class="badge bg-white text-primary ms-3 px-3 py-2" style="font-size: 0.9rem;">
                                    <i class="bi bi-shield-check"></i> Administrator
                                </span>
                            </p>
                        </div>
                        <div class="text-white" style="font-size: 4rem; opacity: 0.2;">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Row 1 -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card primary hover-lift fade-in border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-muted mb-2" style="font-size: 0.95rem; font-weight: 600; letter-spacing: 0.5px;">
                                <i class="bi bi-people-fill text-primary me-2"></i>TOTAL USERS
                            </h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.75rem;">{{ $stats['total_users'] }}</h2>
                        </div>
                        <div class="stat-icon-wrapper" style="background: rgba(102, 126, 234, 0.1); width: 70px; height: 70px; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-people-fill text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    <small class="text-muted d-flex align-items-center" style="font-size: 0.95rem;">
                        <i class="bi bi-graph-up-arrow me-2 text-success"></i>All system users
                    </small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card success hover-lift fade-in border-0 shadow-lg" style="animation-delay: 0.1s; border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-muted mb-2" style="font-size: 0.95rem; font-weight: 600; letter-spacing: 0.5px;">
                                <i class="bi bi-person-badge-fill text-success me-2"></i>PROPERTY OWNERS
                            </h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.75rem;">{{ $stats['total_owners'] }}</h2>
                        </div>
                        <div class="stat-icon-wrapper" style="background: rgba(17, 153, 142, 0.1); width: 70px; height: 70px; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-person-badge-fill text-success" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    <small class="text-muted d-flex align-items-center" style="font-size: 0.95rem;">
                        <i class="bi bi-buildings me-2 text-success"></i>Managing properties
                    </small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card info hover-lift fade-in border-0 shadow-lg" style="animation-delay: 0.2s; border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-muted mb-2" style="font-size: 0.95rem; font-weight: 600; letter-spacing: 0.5px;">
                                <i class="bi bi-person-workspace text-info me-2"></i>HOUSEKEEPERS
                            </h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.75rem;">{{ $stats['total_housekeepers'] }}</h2>
                        </div>
                        <div class="stat-icon-wrapper" style="background: rgba(79, 172, 254, 0.1); width: 70px; height: 70px; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-person-workspace text-info" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    <small class="text-muted d-flex align-items-center" style="font-size: 0.95rem;">
                        <i class="bi bi-briefcase-fill me-2 text-info"></i>Active workers
                    </small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card warning hover-lift fade-in border-0 shadow-lg" style="animation-delay: 0.3s; border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-muted mb-2" style="font-size: 0.95rem; font-weight: 600; letter-spacing: 0.5px;">
                                <i class="bi bi-houses-fill text-warning me-2"></i>TOTAL PROPERTIES
                            </h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.75rem;">{{ $stats['total_properties'] }}</h2>
                        </div>
                        <div class="stat-icon-wrapper" style="background: rgba(246, 211, 101, 0.15); width: 70px; height: 70px; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-houses-fill text-warning" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    <small class="text-muted d-flex align-items-center" style="font-size: 0.95rem;">
                        <i class="bi bi-geo-alt-fill me-2 text-warning"></i>System-wide
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Row 2 -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card stat-card primary hover-lift fade-in border-0 shadow-lg" style="animation-delay: 0.4s; border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-muted mb-2" style="font-size: 0.95rem; font-weight: 600; letter-spacing: 0.5px;">
                                <i class="bi bi-hourglass-split text-primary me-2"></i>PENDING
                            </h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.75rem;">{{ $stats['pending_checklists'] }}</h2>
                        </div>
                        <div class="stat-icon-wrapper" style="background: rgba(102, 126, 234, 0.1); width: 70px; height: 70px; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-hourglass-split text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    <small class="text-muted d-flex align-items-center" style="font-size: 0.95rem;">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Awaiting start
                    </small>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card stat-card success hover-lift fade-in border-0 shadow-lg" style="animation-delay: 0.5s; border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-muted mb-2" style="font-size: 0.95rem; font-weight: 600; letter-spacing: 0.5px;">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>COMPLETED
                            </h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.75rem;">{{ $stats['completed_checklists'] }}</h2>
                        </div>
                        <div class="stat-icon-wrapper" style="background: rgba(17, 153, 142, 0.1); width: 70px; height: 70px; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    <small class="text-muted d-flex align-items-center" style="font-size: 0.95rem;">
                        <i class="bi bi-trophy-fill me-2 text-success"></i>Successfully done
                    </small>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card stat-card info hover-lift fade-in border-0 shadow-lg" style="animation-delay: 0.6s; border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-muted mb-2" style="font-size: 0.95rem; font-weight: 600; letter-spacing: 0.5px;">
                                <i class="bi bi-clipboard-data text-info me-2"></i>TOTAL CHECKLISTS
                            </h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.75rem;">{{ $stats['total_checklists'] }}</h2>
                        </div>
                        <div class="stat-icon-wrapper" style="background: rgba(79, 172, 254, 0.1); width: 70px; height: 70px; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-clipboard-data text-info" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    <small class="text-muted d-flex align-items-center" style="font-size: 0.95rem;">
                        <i class="bi bi-bar-chart-fill me-2 text-info"></i>All-time total
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-header border-0 text-white py-4" style="background: var(--primary-gradient); border-radius: 20px 20px 0 0;">
                    <h4 class="mb-0 fw-bold d-flex align-items-center" style="font-size: 1.4rem;">
                        <i class="bi bi-activity me-3" style="font-size: 1.8rem;"></i>Recent Checklists Activity
                    </h4>
                    <p class="mb-0 mt-2" style="opacity: 0.9; font-size: 1rem;">
                        <i class="bi bi-clock-history me-2"></i>Latest system activity and updates
                    </p>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" style="font-size: 1rem;">
                            <thead style="background: rgba(102, 126, 234, 0.05);">
                                <tr>
                                    <th class="border-0 py-3" style="font-weight: 700; font-size: 0.95rem; letter-spacing: 0.5px;">
                                        <i class="bi bi-hash text-primary me-2"></i>ID
                                    </th>
                                    <th class="border-0 py-3" style="font-weight: 700; font-size: 0.95rem; letter-spacing: 0.5px;">
                                        <i class="bi bi-building text-success me-2"></i>PROPERTY
                                    </th>
                                    <th class="border-0 py-3" style="font-weight: 700; font-size: 0.95rem; letter-spacing: 0.5px;">
                                        <i class="bi bi-person-badge text-info me-2"></i>HOUSEKEEPER
                                    </th>
                                    <th class="border-0 py-3" style="font-weight: 700; font-size: 0.95rem; letter-spacing: 0.5px;">
                                        <i class="bi bi-calendar-event text-warning me-2"></i>SCHEDULED DATE
                                    </th>
                                    <th class="border-0 py-3" style="font-weight: 700; font-size: 0.95rem; letter-spacing: 0.5px;">
                                        <i class="bi bi-flag-fill text-danger me-2"></i>STATUS
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_checklists as $checklist)
                                    <tr style="transition: all 0.3s ease;">
                                        <td class="border-0 py-3">
                                            <strong style="font-size: 1.1rem; color: #667eea;">#{{ $checklist->id }}</strong>
                                        </td>
                                        <td class="border-0 py-3" style="font-size: 1rem;">
                                            <i class="bi bi-house-door-fill text-primary me-2"></i>
                                            <strong>{{ $checklist->property->name }}</strong>
                                        </td>
                                        <td class="border-0 py-3" style="font-size: 1rem;">
                                            <i class="bi bi-person-circle text-info me-2"></i>
                                            {{ $checklist->housekeeper->name }}
                                        </td>
                                        <td class="border-0 py-3" style="font-size: 1rem;">
                                            <i class="bi bi-calendar-check text-success me-2"></i>
                                            {{ $checklist->scheduled_date->format('M d, Y') }}
                                        </td>
                                        <td class="border-0 py-3">
                                            @if($checklist->status === 'pending')
                                                <span class="badge bg-secondary px-3 py-2" style="font-size: 0.95rem; font-weight: 600;">
                                                    <i class="bi bi-hourglass me-1"></i> {{ ucfirst($checklist->status) }}
                                                </span>
                                            @elseif($checklist->status === 'in_progress')
                                                <span class="badge bg-info px-3 py-2" style="font-size: 0.95rem; font-weight: 600;">
                                                    <i class="bi bi-play-circle-fill me-1"></i> In Progress
                                                </span>
                                            @else
                                                <span class="badge bg-success px-3 py-2" style="font-size: 0.95rem; font-weight: 600;">
                                                    <i class="bi bi-check-circle-fill me-1"></i> {{ ucfirst($checklist->status) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 border-0">
                                            <div style="opacity: 0.3;">
                                                <i class="bi bi-inbox" style="font-size: 4rem;"></i>
                                            </div>
                                            <p class="text-muted mt-3 mb-0" style="font-size: 1.1rem; font-weight: 500;">No checklists found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Tutorial Modal - Step 1 -->
<div class="modal fade" id="welcomeTutorialModal" tabindex="-1" aria-labelledby="welcomeTutorialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <!-- Header -->
            <div class="modal-header border-0 text-white py-4" style="background: var(--primary-gradient); border-radius: 20px 20px 0 0;">
                <h4 class="modal-title fw-bold" id="welcomeTutorialModalLabel">
                    <i class="bi bi-rocket-takeoff-fill me-2"></i>Welcome to {{ config('app.name', 'HK Checklist') }}!
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="display-1 mb-3">
                        <i class="bi bi-info-circle-fill" style="color: #667eea;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Quick Start Guide - Step 1</h5>
                    <p class="text-muted">Here's how to get started with your housekeeping management system:</p>
                </div>

                <!-- Steps -->
                <div class="row g-4">
                    <!-- Step 1 -->
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); border-radius: 15px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="badge rounded-circle p-3" style="background: var(--primary-gradient); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                            <span class="text-white fw-bold fs-5">1</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fw-bold mb-2">
                                            <i class="bi bi-building me-2 text-primary"></i>Add Properties
                                        </h6>
                                        <p class="mb-0 small text-muted">Start by adding your hotel or property in the <strong>Properties</strong> section.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%); border-radius: 15px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="badge rounded-circle p-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                            <span class="text-white fw-bold fs-5">2</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fw-bold mb-2">
                                            <i class="bi bi-people me-2" style="color: #4facfe;"></i>Create Users
                                        </h6>
                                        <p class="mb-0 small text-muted">Add property owners and housekeepers in the <strong>Users</strong> section with appropriate roles.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(17, 153, 142, 0.1) 0%, rgba(56, 239, 125, 0.1) 100%); border-radius: 15px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="badge rounded-circle p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                            <span class="text-white fw-bold fs-5">3</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fw-bold mb-2">
                                            <i class="bi bi-calendar-event me-2" style="color: #11998e;"></i>Use Calendar
                                        </h6>
                                        <p class="mb-0 small text-muted">View and manage all scheduled cleanings from the <strong>Calendar</strong> section.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(246, 211, 101, 0.1) 0%, rgba(253, 160, 133, 0.1) 100%); border-radius: 15px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <div class="badge rounded-circle p-3" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                            <span class="text-white fw-bold fs-5">4</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fw-bold mb-2">
                                            <i class="bi bi-gear me-2" style="color: #f6d365;"></i>Customize Settings
                                        </h6>
                                        <p class="mb-0 small text-muted">Personalize app name and favicon in <strong>Settings</strong> to match your brand.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Important Note -->
                <div class="alert alert-warning border-0 mt-4" style="background: rgba(246, 211, 101, 0.15); border-radius: 15px;">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-info-circle-fill" style="color: #f6d365;" class="fs-4 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-2">Important Note:</h6>
                            <p class="mb-0 small"><strong>Property Owners</strong> will handle creating <strong>Rooms</strong> and <strong>Tasks</strong> for their properties. As an admin, you manage properties, users, and system settings.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 p-4">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" style="border-radius: 12px; font-weight: 600;">
                    <i class="bi bi-x-circle me-2"></i>Skip
                </button>
                <button type="button" class="btn btn-lg px-4" style="background: var(--primary-gradient); color: white; border-radius: 12px; font-weight: 600;" id="goToStep2">
                    <i class="bi bi-arrow-right-circle me-2"></i>Next
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Tutorial Modal - Step 2 -->
<div class="modal fade" id="welcomeTutorialModal2" tabindex="-1" aria-labelledby="welcomeTutorialModal2Label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <!-- Header -->
            <div class="modal-header border-0 text-white py-4" style="background: var(--primary-gradient); border-radius: 20px 20px 0 0;">
                <h4 class="modal-title fw-bold" id="welcomeTutorialModal2Label">
                    <i class="bi bi-lightbulb-fill me-2"></i>Quick Tips & Navigation
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="display-1 mb-3">
                        <i class="bi bi-compass-fill" style="color: #667eea;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Navigation Guide</h5>
                    <p class="text-muted">Quickly access all features from the sidebar menu:</p>
                </div>

                <!-- Navigation Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: rgba(102, 126, 234, 0.1); border-radius: 12px;">
                            <div class="card-body p-3">
                                <h6 class="mb-2"><i class="bi bi-speedometer2 text-primary me-2"></i>Dashboard</h6>
                                <small class="text-muted">Overview of all activities and statistics</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: rgba(79, 172, 254, 0.1); border-radius: 12px;">
                            <div class="card-body p-3">
                                <h6 class="mb-2"><i class="bi bi-building text-primary me-2"></i>Properties</h6>
                                <small class="text-muted">Manage hotels and buildings</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: rgba(17, 153, 142, 0.1); border-radius: 12px;">
                            <div class="card-body p-3">
                                <h6 class="mb-2"><i class="bi bi-door-closed text-success me-2"></i>Rooms</h6>
                                <small class="text-muted">View all rooms across properties</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: rgba(246, 211, 101, 0.1); border-radius: 12px;">
                            <div class="card-body p-3">
                                <h6 class="mb-2"><i class="bi bi-list-check text-warning me-2"></i>Tasks</h6>
                                <small class="text-muted">Manage cleaning task templates</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: rgba(56, 239, 125, 0.1); border-radius: 12px;">
                            <div class="card-body p-3">
                                <h6 class="mb-2"><i class="bi bi-clipboard-check text-success me-2"></i>Checklists</h6>
                                <small class="text-muted">View all cleaning assignments</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: rgba(253, 160, 133, 0.1); border-radius: 12px;">
                            <div class="card-body p-3">
                                <h6 class="mb-2"><i class="bi bi-calendar-event text-danger me-2"></i>Calendar</h6>
                                <small class="text-muted">Schedule and timeline view</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: rgba(102, 126, 234, 0.1); border-radius: 12px;">
                            <div class="card-body p-3">
                                <h6 class="mb-2"><i class="bi bi-people text-primary me-2"></i>Users</h6>
                                <small class="text-muted">Manage owners and housekeepers</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: rgba(118, 75, 162, 0.1); border-radius: 12px;">
                            <div class="card-body p-3">
                                <h6 class="mb-2"><i class="bi bi-gear text-secondary me-2"></i>Settings</h6>
                                <small class="text-muted">Customize app appearance</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pro Tips -->
                <div class="alert alert-info border-0" style="background: rgba(79, 172, 254, 0.1); border-radius: 15px;">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-star-fill text-primary fs-4 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-2">Pro Tips:</h6>
                            <ul class="mb-0 small">
                                <li>All lists support <strong>pagination</strong> (20 items per page) for better performance</li>
                                <li>Use the <strong>search and filter</strong> options to quickly find specific items</li>
                                <li>Monitor <strong>real-time status</strong> updates (Pending, In Progress, Completed)</li>
                                <li><strong>Property Owners</strong> can upload photos during checklist completion for quality assurance</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 p-4">
                <div class="form-check me-auto">
                    <input class="form-check-input" type="checkbox" id="neverShowAgain">
                    <label class="form-check-label" for="neverShowAgain">
                        <i class="bi bi-x-circle me-1"></i>Don't show this again
                    </label>
                </div>
                <button type="button" class="btn btn-outline-secondary px-4 me-2" id="goBackToStep1" style="border-radius: 12px; font-weight: 600;">
                    <i class="bi bi-arrow-left-circle me-2"></i>Back
                </button>
                <button type="button" class="btn btn-lg px-4" style="background: var(--primary-gradient); color: white; border-radius: 12px; font-weight: 600;" id="closeWelcomeModal">
                    <i class="bi bi-check-circle me-2"></i>Got It!
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show modal only if backend says to show it (once per login session)
    @if(isset($showWelcomeTutorial) && $showWelcomeTutorial)
        const modal1 = new bootstrap.Modal(document.getElementById('welcomeTutorialModal'));
        modal1.show();
    @endif
    
    // Handle "Next" button - go to step 2
    document.getElementById('goToStep2').addEventListener('click', function() {
        const modal1 = bootstrap.Modal.getInstance(document.getElementById('welcomeTutorialModal'));
        modal1.hide();
        
        const modal2 = new bootstrap.Modal(document.getElementById('welcomeTutorialModal2'));
        modal2.show();
    });
    
    // Handle "Back" button - go back to step 1
    document.getElementById('goBackToStep1').addEventListener('click', function() {
        const modal2 = bootstrap.Modal.getInstance(document.getElementById('welcomeTutorialModal2'));
        modal2.hide();
        
        const modal1 = new bootstrap.Modal(document.getElementById('welcomeTutorialModal'));
        modal1.show();
    });
    
    // Handle "Got It!" button on step 2
    document.getElementById('closeWelcomeModal').addEventListener('click', function() {
        const neverShowAgain = document.getElementById('neverShowAgain').checked;
        
        if (neverShowAgain) {
            // Send AJAX request to save preference in database
            fetch('{{ route('admin.welcome.dismiss') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json())
              .then(data => {
                  console.log('Welcome tutorial dismissed permanently');
              });
        }
        
        const modal2 = bootstrap.Modal.getInstance(document.getElementById('welcomeTutorialModal2'));
        if (modal2) modal2.hide();
    });
});
</script>
@endpush
@endsection
