@extends('layouts.app')

@section('content')
<div class="container-fluid px-2 px-md-3">
    <!-- Header Card with Gradient -->
    <div class="card border-0 shadow-sm mb-3 mb-md-4 mobile-header-card" style="background: var(--success-gradient);">
        <div class="card-body py-3 py-md-4">
            <h2 class="text-white mb-2 h5 h4-md">
                <i class="bi bi-calendar-check"></i> My Cleaning Schedule
            </h2>
            <p class="text-white opacity-75 mb-0 small">
                <i class="bi bi-info-circle"></i> View your assigned cleaning dates and manage your tasks
            </p>
        </div>
    </div>

    <!-- Legend -->
    <div class="row mb-3 mb-md-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm mobile-legend-card">
                <div class="card-body py-2 py-md-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <strong class="me-2 small">
                            <i class="bi bi-info-circle-fill text-primary"></i> Status:
                        </strong>
                        <span class="badge bg-secondary shadow-sm mobile-legend-badge">
                            <i class="bi bi-hourglass"></i> Pending
                        </span>
                        <span class="badge bg-warning shadow-sm mobile-legend-badge">
                            <i class="bi bi-play-circle-fill"></i> In Progress
                        </span>
                        <span class="badge bg-success shadow-sm mobile-legend-badge">
                            <i class="bi bi-check-circle-fill"></i> Completed
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm mobile-calendar-card">
                <div class="card-body p-2 p-md-4">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered mobile-modal">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header border-0 text-white mobile-modal-header" style="background: var(--success-gradient);">
                <h4 class="modal-title h6 h5-md">
                    <i class="bi bi-clipboard-check-fill"></i> Assignment Details
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="detailsContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-3">Loading details...</p>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                </button>
                <a href="#" id="startChecklistBtn" class="btn btn-success shadow-lg" style="display:none;">
                    <i class="bi bi-play-circle-fill"></i> Start Checklist
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'));

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '{{ route("housekeeper.calendar.events") }}',
        eventDidMount: function(info) {
            // Add status class to event element for custom styling
            const status = info.event.extendedProps.status || 'pending';
            info.el.classList.add('status-' + status.replace('_', '-'));
        },
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            
            // Show details modal
            const props = info.event.extendedProps;
            const statusBadge = props.status === 'completed' ? 'success' : 
                              props.status === 'in_progress' ? 'warning' : 'secondary';
            const statusIcon = props.status === 'completed' ? 'bi-check-circle-fill' : 
                             props.status === 'in_progress' ? 'bi-play-circle-fill' : 'bi-hourglass';
            
            let html = `
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body">
                                <h6 class="text-muted text-uppercase mb-3">
                                    <i class="bi bi-building-fill text-primary"></i> Property Information
                                </h6>
                                <p class="mb-2">
                                    <i class="bi bi-house-door"></i> <strong>Name:</strong><br>
                                    <span class="ms-4">${props.property}</span>
                                </p>
                                <p class="mb-0">
                                    <i class="bi bi-geo-alt-fill text-danger"></i> <strong>Address:</strong><br>
                                    <span class="ms-4">${props.address}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body">
                                <h6 class="text-muted text-uppercase mb-3">
                                    <i class="bi bi-calendar-check-fill text-success"></i> Assignment Details
                                </h6>
                                <p class="mb-2">
                                    <i class="bi bi-calendar-event"></i> <strong>Scheduled Date:</strong><br>
                                    <span class="ms-4">${info.event.start.toLocaleDateString()}</span>
                                </p>
                                <p class="mb-0">
                                    <i class="${statusIcon}"></i> <strong>Status:</strong><br>
                                    <span class="badge bg-${statusBadge} fs-6 ms-4 mt-1">
                                        <i class="${statusIcon}"></i> ${props.status.replace('_', ' ').toUpperCase()}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info mt-4 border-0 shadow-sm">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle-fill fs-3 me-3"></i>
                        <div>
                            <strong>Ready to start?</strong><br>
                            <small>Click the button below to ${props.status === 'pending' ? 'begin' : 'view'} your checklist</small>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('detailsContent').innerHTML = html;
            
            // Show start button
            const startBtn = document.getElementById('startChecklistBtn');
            startBtn.style.display = 'inline-block';
            startBtn.href = info.event.url;
            
            if (props.status === 'pending') {
                startBtn.className = 'btn btn-success shadow-lg';
                startBtn.innerHTML = '<i class="bi bi-play-circle-fill"></i> Start Checklist';
            } else {
                startBtn.className = 'btn btn-primary shadow-lg';
                startBtn.innerHTML = '<i class="bi bi-eye-fill"></i> View Checklist';
            }
            
            detailsModal.show();
        },
        height: 'auto',
        eventTimeFormat: {
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short'
        },
        // Mobile responsive settings
        contentHeight: 'auto',
        handleWindowResize: true,
        windowResizeDelay: 100,
        aspectRatio: window.innerWidth < 768 ? 1 : 1.35
    });

    calendar.render();
    
    // Re-render calendar on window resize for mobile
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            calendar.setOption('aspectRatio', window.innerWidth < 768 ? 1 : 1.35);
        }, 250);
    });

    function getStatusClass(status) {
        return status === 'completed' ? 'success' : status === 'in_progress' ? 'info' : 'secondary';
    }
});
</script>

<style>
/* Mobile Responsive Styles for Housekeeper Calendar */
@media (max-width: 768px) {
    /* Typography */
    .h4-md { font-size: 1.25rem !important; }
    .h5-md { font-size: 1.1rem !important; }
    
    /* Header card mobile */
    .mobile-header-card .card-body {
        padding: 1rem !important;
    }
    
    /* Legend mobile */
    .mobile-legend-card .card-body {
        padding: 0.75rem !important;
    }
    
    .mobile-legend-badge {
        font-size: 0.75rem !important;
        padding: 0.35rem 0.6rem !important;
    }
    
    /* Calendar mobile */
    .mobile-calendar-card .card-body {
        padding: 0.5rem !important;
    }
    
    /* FullCalendar mobile customization */
    #calendar {
        font-size: 0.85rem;
    }
    
    .fc-toolbar {
        flex-direction: column !important;
        gap: 0.5rem;
    }
    
    .fc-toolbar-chunk {
        width: 100%;
        display: flex;
        justify-content: center;
    }
    
    .fc-button {
        padding: 0.5rem 0.75rem !important;
        font-size: 0.8rem !important;
    }
    
    .fc-toolbar-title {
        font-size: 1.1rem !important;
    }
    
    .fc-daygrid-day-number {
        font-size: 0.85rem !important;
        padding: 0.25rem !important;
    }
    
    .fc-daygrid-day-top {
        flex-direction: column;
    }
    
    .fc-event {
        font-size: 0.75rem !important;
        padding: 0.15rem 0.3rem !important;
        margin: 1px 2px !important;
    }
    
    .fc-event-title {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .fc-col-header-cell-cushion {
        padding: 0.5rem 0.25rem !important;
        font-size: 0.75rem !important;
    }
    
    /* Modal mobile */
    .mobile-modal {
        margin: 0.5rem;
        max-width: calc(100% - 1rem) !important;
    }
    
    .mobile-modal-header {
        padding: 1rem !important;
    }
    
    .mobile-modal .modal-body {
        padding: 1rem !important;
    }
    
    .mobile-modal .modal-footer {
        padding: 0.75rem 1rem !important;
    }
    
    .mobile-modal .btn {
        padding: 0.65rem 1rem !important;
        font-size: 0.9rem !important;
    }
}

/* Very small phones */
@media (max-width: 375px) {
    .fc-button {
        padding: 0.4rem 0.6rem !important;
        font-size: 0.75rem !important;
    }
    
    .fc-toolbar-title {
        font-size: 1rem !important;
    }
    
    .fc-event {
        font-size: 0.7rem !important;
    }
    
    .mobile-legend-badge {
        font-size: 0.7rem !important;
        padding: 0.3rem 0.5rem !important;
    }
}

/* Touch optimization */
.fc-event,
.fc-button {
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0.1);
    touch-action: manipulation;
}
</style>
@endpush
