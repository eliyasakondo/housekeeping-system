@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="bi bi-speedometer2"></i> Owner Dashboard</h2>
            <p class="text-muted">Welcome back, {{ auth()->user()->name }}!</p>
        </div>
    </div>

    <!-- Quick Action: Assign Housekeeper -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card cta-card border-0">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-calendar-plus" style="font-size: 4rem; opacity: 0.9;"></i>
                    </div>
                    <h3 class="mb-3 fw-bold">Need to Schedule a Cleaning?</h3>
                    <p class="mb-4 fs-5" style="opacity: 0.95;">Assign a housekeeper to clean your property on a specific date</p>
                    <a href="{{ route('owner.calendar') }}" class="btn btn-light btn-lg shadow-lg hover-lift">
                        <i class="bi bi-calendar-check"></i> Assign Housekeeper to Property
                    </a>
                    <div class="mt-4 pt-3" style="border-top: 1px solid rgba(255,255,255,0.2);">
                        <small style="opacity: 0.9;">
                            <i class="bi bi-lightbulb"></i> Tip: Click any date on the calendar to quickly create an assignment
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- My Properties Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-lg hover-lift" style="border-radius: 20px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.9rem; font-weight: 500;">My Properties</p>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.75rem; color: #667eea;">{{ $stats['total_properties'] }}</h2>
                        </div>
                        <div class="badge rounded-circle p-3" style="background: var(--primary-gradient); width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-building text-white" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <a href="{{ route('owner.properties.index') }}" class="btn btn-sm w-100" style="background: var(--primary-gradient); color: white; border-radius: 12px; font-weight: 600;">
                        <i class="bi bi-arrow-right-circle me-1"></i> Manage
                    </a>
                </div>
            </div>
        </div>

        <!-- My Housekeepers Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-lg hover-lift" style="border-radius: 20px; background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.9rem; font-weight: 500;">My Housekeepers</p>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.75rem; color: #4facfe;">{{ $stats['total_housekeepers'] }}</h2>
                        </div>
                        <div class="badge rounded-circle p-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-people text-white" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <a href="{{ route('owner.housekeepers.index') }}" class="btn btn-sm w-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border-radius: 12px; font-weight: 600;">
                        <i class="bi bi-arrow-right-circle me-1"></i> View All
                    </a>
                </div>
            </div>
        </div>

        <!-- Pending Tasks Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-lg hover-lift" style="border-radius: 20px; background: linear-gradient(135deg, rgba(246, 211, 101, 0.1) 0%, rgba(253, 160, 133, 0.1) 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.9rem; font-weight: 500;">Pending Tasks</p>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.75rem; color: #f6d365;">{{ $stats['pending_checklists'] }}</h2>
                        </div>
                        <div class="badge rounded-circle p-3" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-clock-history text-white" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <a href="{{ route('owner.checklists.index') }}?status=pending" class="btn btn-sm w-100" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); color: white; border-radius: 12px; font-weight: 600;">
                        <i class="bi bi-arrow-right-circle me-1"></i> View All
                    </a>
                </div>
            </div>
        </div>

        <!-- Completed Today Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-lg hover-lift" style="border-radius: 20px; background: linear-gradient(135deg, rgba(17, 153, 142, 0.1) 0%, rgba(56, 239, 125, 0.1) 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.9rem; font-weight: 500;">Completed Today</p>
                            <h2 class="mb-0 fw-bold" style="font-size: 2.75rem; color: #11998e;">{{ $stats['completed_today'] }}</h2>
                        </div>
                        <div class="badge rounded-circle p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-check-circle text-white" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <a href="{{ route('owner.checklists.index') }}?status=completed" class="btn btn-sm w-100" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border-radius: 12px; font-weight: 600;">
                        <i class="bi bi-arrow-right-circle me-1"></i> View All
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header border-0" style="background: var(--primary-gradient);">
                    <h4 class="mb-0 text-white">
                        <i class="bi bi-clipboard-data"></i> Recent Checklists Activity
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-building"></i> Property</th>
                                    <th><i class="bi bi-person-badge"></i> Housekeeper</th>
                                    <th><i class="bi bi-calendar-event"></i> Scheduled</th>
                                    <th><i class="bi bi-flag"></i> Status</th>
                                    <th><i class="bi bi-geo-alt"></i> GPS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_checklists as $checklist)
                                    <tr>
                                        <td>
                                            <i class="bi bi-house-door text-primary"></i>
                                            <strong>{{ $checklist->property->name }}</strong>
                                        </td>
                                        <td>
                                            <i class="bi bi-person-circle text-info"></i>
                                            {{ $checklist->housekeeper->name }}
                                        </td>
                                        <td>
                                            <i class="bi bi-calendar-check text-success"></i>
                                            {{ $checklist->scheduled_date->format('M d, Y') }}
                                        </td>
                                        <td>
                                            @if($checklist->status === 'pending')
                                                <span class="badge bg-secondary">
                                                    <i class="bi bi-hourglass"></i> Pending
                                                </span>
                                            @elseif($checklist->status === 'in_progress')
                                                <span class="badge bg-info">
                                                    <i class="bi bi-play-circle"></i> In Progress
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i> {{ ucfirst($checklist->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($checklist->gps_verified)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-geo-alt-fill"></i> Verified
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="bi bi-x-circle"></i> Not Verified
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <p class="text-muted mt-2 mb-0">No checklists found</p>
                                        </td>
                                    </tr>
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

<!-- 3-Page Welcome Tutorial Modals -->
@if($showWelcomeTutorial)
<!-- Page 1: Getting Started -->
<div class="modal fade" id="welcomeTutorialModal1" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 text-white" style="background: var(--primary-gradient); border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-rocket-takeoff me-2"></i>Welcome to Your Dashboard!
                </h5>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="bi bi-house-heart" style="font-size: 4rem; color: #667eea;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Getting Started Guide</h4>
                    <p class="text-muted">Let's set up your housekeeping management system in 4 simple steps</p>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="badge rounded-circle p-3 me-3" style="background: var(--primary-gradient); width: 50px; height: 50px;">
                                        <span class="text-white fw-bold" style="font-size: 1.2rem;">1</span>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-2">Add Your Properties</h6>
                                        <p class="small text-muted mb-0">Go to Properties → Create properties and add rooms with tasks for each room</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="badge rounded-circle p-3 me-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); width: 50px; height: 50px;">
                                        <span class="text-white fw-bold" style="font-size: 1.2rem;">2</span>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-2">Invite Housekeepers</h6>
                                        <p class="small text-muted mb-0">Go to Housekeepers → Add your cleaning staff who will perform the work</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(17, 153, 142, 0.1) 0%, rgba(56, 239, 125, 0.1) 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="badge rounded-circle p-3 me-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); width: 50px; height: 50px;">
                                        <span class="text-white fw-bold" style="font-size: 1.2rem;">3</span>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-2">Schedule Cleaning</h6>
                                        <p class="small text-muted mb-0">Use Schedule Cleaning → Assign housekeepers to properties with date and time</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(246, 211, 101, 0.1) 0%, rgba(253, 160, 133, 0.1) 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="badge rounded-circle p-3 me-3" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); width: 50px; height: 50px;">
                                        <span class="text-white fw-bold" style="font-size: 1.2rem;">4</span>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-2">Monitor Progress</h6>
                                        <p class="small text-muted mb-0">Track work in Checklists → View photos, inventory, and task completion</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-outline-secondary" onclick="skipWelcomeTutorial()">
                    <i class="bi bi-x-circle me-1"></i>Skip Tutorial
                </button>
                <button type="button" class="btn btn-primary" onclick="goToTutorialPage2()" style="background: var(--primary-gradient); border: none;">
                    Next: Navigation Guide <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Page 2: Navigation Guide -->
<div class="modal fade" id="welcomeTutorialModal2" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 text-white" style="background: var(--primary-gradient); border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-compass me-2"></i>Navigation Guide
                </h5>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h5 class="fw-bold">Quick Access to All Features</h5>
                    <p class="text-muted">Here's what each menu item does</p>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="bi bi-speedometer2 text-primary mb-2" style="font-size: 2rem;"></i>
                            <h6 class="fw-bold mb-1">Dashboard</h6>
                            <small class="text-muted">Overview & quick stats</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="bi bi-building text-purple mb-2" style="font-size: 2rem; color: #667eea;"></i>
                            <h6 class="fw-bold mb-1">Properties</h6>
                            <small class="text-muted">Manage properties & rooms</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="bi bi-person-badge text-info mb-2" style="font-size: 2rem;"></i>
                            <h6 class="fw-bold mb-1">Housekeepers</h6>
                            <small class="text-muted">Manage your staff</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="bi bi-list-check text-success mb-2" style="font-size: 2rem;"></i>
                            <h6 class="fw-bold mb-1">Tasks</h6>
                            <small class="text-muted">Create cleaning tasks</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="bi bi-clipboard-check text-warning mb-2" style="font-size: 2rem;"></i>
                            <h6 class="fw-bold mb-1">Checklists</h6>
                            <small class="text-muted">View assigned work</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="bi bi-calendar-check text-danger mb-2" style="font-size: 2rem;"></i>
                            <h6 class="fw-bold mb-1">Schedule</h6>
                            <small class="text-muted">Assign tasks to dates</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-outline-secondary" onclick="goBackToTutorialPage1()">
                    <i class="bi bi-arrow-left me-1"></i>Back
                </button>
                <button type="button" class="btn btn-primary" onclick="goToTutorialPage3()" style="background: var(--primary-gradient); border: none;">
                    Next: Pro Tips <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Page 3: Pro Tips -->
<div class="modal fade" id="welcomeTutorialModal3" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 text-white" style="background: var(--primary-gradient); border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-lightbulb me-2"></i>Pro Tips & Best Practices
                </h5>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h5 class="fw-bold">Get the Most Out of the System</h5>
                    <p class="text-muted">Tips to streamline your housekeeping management</p>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Real-Time Tracking</h6>
                                <p class="text-muted small mb-0">View live updates as housekeepers complete tasks, upload photos, and check inventory</p>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-camera-fill text-primary me-3 mt-1" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Photo Verification</h6>
                                <p class="text-muted small mb-0">Housekeepers must upload minimum photos per room for quality assurance</p>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-geo-alt-fill text-danger me-3 mt-1" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="fw-bold mb-1">GPS Verification</h6>
                                <p class="text-muted small mb-0">System verifies housekeepers are on-site before they can start work</p>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-box-seam text-warning me-3 mt-1" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Inventory Management</h6>
                                <p class="text-muted small mb-0">Track item conditions and get notified about damaged or missing items</p>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-clock-history text-info me-3 mt-1" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Schedule Time</h6>
                                <p class="text-muted small mb-0">Assign specific times for cleaning to better coordinate with guests</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light" style="border-radius: 0 0 20px 20px;">
                <div class="form-check me-auto">
                    <input class="form-check-input" type="checkbox" id="dontShowAgain">
                    <label class="form-check-label" for="dontShowAgain">
                        Don't show this again
                    </label>
                </div>
                <button type="button" class="btn btn-outline-secondary" onclick="goBackToTutorialPage2()">
                    <i class="bi bi-arrow-left me-1"></i>Back
                </button>
                <button type="button" class="btn btn-success" onclick="closeWelcomeTutorial()">
                    <i class="bi bi-check-circle-fill me-1"></i>Got It!
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Show first modal on page load
document.addEventListener('DOMContentLoaded', function() {
    const modal1 = new bootstrap.Modal(document.getElementById('welcomeTutorialModal1'));
    modal1.show();
});

function goToTutorialPage2() {
    const modal1 = bootstrap.Modal.getInstance(document.getElementById('welcomeTutorialModal1'));
    modal1.hide();
    setTimeout(() => {
        const modal2 = new bootstrap.Modal(document.getElementById('welcomeTutorialModal2'));
        modal2.show();
    }, 300);
}

function goToTutorialPage3() {
    const modal2 = bootstrap.Modal.getInstance(document.getElementById('welcomeTutorialModal2'));
    modal2.hide();
    setTimeout(() => {
        const modal3 = new bootstrap.Modal(document.getElementById('welcomeTutorialModal3'));
        modal3.show();
    }, 300);
}

function goBackToTutorialPage1() {
    const modal2 = bootstrap.Modal.getInstance(document.getElementById('welcomeTutorialModal2'));
    modal2.hide();
    setTimeout(() => {
        const modal1 = new bootstrap.Modal(document.getElementById('welcomeTutorialModal1'));
        modal1.show();
    }, 300);
}

function goBackToTutorialPage2() {
    const modal3 = bootstrap.Modal.getInstance(document.getElementById('welcomeTutorialModal3'));
    modal3.hide();
    setTimeout(() => {
        const modal2 = new bootstrap.Modal(document.getElementById('welcomeTutorialModal2'));
        modal2.show();
    }, 300);
}

function skipWelcomeTutorial() {
    const modal1 = bootstrap.Modal.getInstance(document.getElementById('welcomeTutorialModal1'));
    modal1.hide();
    saveWelcomeTutorialPreference(true);
}

function closeWelcomeTutorial() {
    const dontShowAgain = document.getElementById('dontShowAgain').checked;
    const modal3 = bootstrap.Modal.getInstance(document.getElementById('welcomeTutorialModal3'));
    modal3.hide();
    
    if (dontShowAgain) {
        saveWelcomeTutorialPreference(true);
    }
}

function saveWelcomeTutorialPreference(dismissed) {
    fetch('{{ route("owner.welcome-tutorial.dismiss") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            dismissed: dismissed
        })
    });
}
</script>
@endif
@endsection
