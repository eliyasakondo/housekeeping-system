@extends('layouts.app')

@section('title')
    @php
        $appName = config('app.name', 'HK Checklist');
        if (Storage::disk('local')->exists('settings.json')) {
            $settings = json_decode(Storage::disk('local')->get('settings.json'), true);
            $appName = $settings['app_name'] ?? $appName;
        }
    @endphp
    Calendar - {{ $appName }}
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header Card with Gradient -->
    <div class="card border-0 shadow-lg mb-4" style="background: var(--info-gradient);">
        <div class="card-body py-4">
            <h2 class="text-white mb-2">
                <i class="bi bi-calendar-range"></i> System-Wide Cleaning Schedule
            </h2>
            <p class="text-white opacity-75 mb-0">
                <i class="bi bi-info-circle"></i> Monitor all cleaning assignments across all properties and housekeepers
            </p>
        </div>
    </div>

    <!-- Legend -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <strong class="me-2">
                            <i class="bi bi-info-circle-fill text-primary"></i> Status Legend:
                        </strong>
                        <span class="badge bg-secondary fs-6 shadow-sm">
                            <i class="bi bi-hourglass"></i> Pending
                        </span>
                        <span class="badge bg-warning fs-6 shadow-sm">
                            <i class="bi bi-play-circle-fill"></i> In Progress
                        </span>
                        <span class="badge bg-success fs-6 shadow-sm">
                            <i class="bi bi-check-circle-fill"></i> Completed
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-xl">
                <div class="card-body p-4">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-xl">
            <div class="modal-header border-0 text-white" style="background: var(--info-gradient);">
                <h4 class="modal-title">
                    <i class="bi bi-clipboard-data-fill"></i> Checklist Details
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="detailsContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-info" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-3">Loading details...</p>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                </button>
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
        events: '{{ route("admin.calendar.events") }}',
        eventDidMount: function(info) {
            // Add status class to event element for custom styling
            const status = info.event.extendedProps.status || 'pending';
            info.el.classList.add('status-' + status.replace('_', '-'));
        },
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            showChecklistDetails(info.event.id);
        },
        height: 'auto',
        eventTimeFormat: {
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short'
        }
    });

    calendar.render();

    function showChecklistDetails(checklistId) {
        document.getElementById('detailsContent').innerHTML = '<div class="text-center py-5"><div class="spinner-border text-info" style="width: 3rem; height: 3rem;"></div><p class="text-muted mt-3">Loading details...</p></div>';
        
        fetch(`{{ url('admin/calendar/checklist') }}/${checklistId}`)
            .then(response => response.json())
            .then(data => {
                const statusBadge = data.checklist.status === 'completed' ? 'success' : 
                                  data.checklist.status === 'in_progress' ? 'warning' : 'secondary';
                const statusIcon = data.checklist.status === 'completed' ? 'bi-check-circle-fill' : 
                                 data.checklist.status === 'in_progress' ? 'bi-play-circle-fill' : 'bi-hourglass';
                
                let html = `
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="text-muted text-uppercase mb-3">
                                        <i class="bi bi-building-fill text-primary"></i> Property Details
                                    </h6>
                                    <p class="mb-2">
                                        <i class="bi bi-house-door"></i> <strong>Name:</strong><br>
                                        <span class="ms-4">${data.property.name}</span>
                                    </p>
                                    <p class="mb-0">
                                        <i class="bi bi-geo-alt-fill text-danger"></i> <strong>Address:</strong><br>
                                        <span class="ms-4">${data.property.address}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="text-muted text-uppercase mb-3">
                                        <i class="bi bi-people-fill text-info"></i> Personnel
                                    </h6>
                                    <p class="mb-2">
                                        <i class="bi bi-person-circle"></i> <strong>Owner:</strong><br>
                                        <span class="ms-4">${data.checklist.assigned_by ? data.checklist.assigned_by.name : 'N/A'}</span>
                                    </p>
                                    <p class="mb-0">
                                        <i class="bi bi-person-badge text-success"></i> <strong>Housekeeper:</strong><br>
                                        <span class="ms-4">${data.housekeeper.name}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="text-muted text-uppercase mb-3">
                                        <i class="bi bi-calendar-check-fill text-success"></i> Schedule
                                    </h6>
                                    <p class="mb-2">
                                        <i class="bi bi-calendar-event"></i> <strong>Date:</strong><br>
                                        <span class="ms-4">${new Date(data.checklist.scheduled_date).toLocaleDateString()}</span>
                                    </p>
                                    <p class="mb-0">
                                        <i class="${statusIcon}"></i> <strong>Status:</strong><br>
                                        <span class="badge bg-${statusBadge} fs-6 ms-4 mt-1">
                                            <i class="${statusIcon}"></i> ${data.checklist.status.replace('_', ' ').toUpperCase()}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    ${data.checklist.started_at || data.checklist.completed_at ? `
                        <div class="card border-0 bg-light mt-4">
                            <div class="card-body">
                                <h6 class="text-muted text-uppercase mb-3">
                                    <i class="bi bi-clock-history text-warning"></i> Timeline
                                </h6>
                                <div class="row">
                                    ${data.checklist.started_at ? `
                                        <div class="col-md-6">
                                            <p class="mb-0">
                                                <i class="bi bi-play-circle"></i> <strong>Started:</strong><br>
                                                <span class="ms-4">${new Date(data.checklist.started_at).toLocaleString()}</span>
                                            </p>
                                        </div>
                                    ` : ''}
                                    ${data.checklist.completed_at ? `
                                        <div class="col-md-6">
                                            <p class="mb-0">
                                                <i class="bi bi-check-circle"></i> <strong>Completed:</strong><br>
                                                <span class="ms-4">${new Date(data.checklist.completed_at).toLocaleString()}</span>
                                            </p>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    ` : ''}
                    
                    <div class="row g-4 mt-2">
                        <div class="col-md-6">
                            <div class="card border-0" style="background: linear-gradient(135deg, rgba(17, 153, 142, 0.1) 0%, rgba(56, 239, 125, 0.1) 100%);">
                                <div class="card-body text-center">
                                    <i class="bi bi-list-check fs-1 text-success"></i>
                                    <h3 class="mt-2 mb-0" style="background: var(--success-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                        ${data.items.filter(i => i.is_completed).length} / ${data.items.length}
                                    </h3>
                                    <p class="text-muted mb-0">Tasks Completed</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0" style="background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);">
                                <div class="card-body text-center">
                                    <i class="bi bi-camera-fill fs-1 text-info"></i>
                                    <h3 class="mt-2 mb-0" style="background: var(--info-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                        ${data.photos.length}
                                    </h3>
                                    <p class="text-muted mb-0">Photos Uploaded</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                if (data.photos.length > 0) {
                    html += `
                        <div class="card border-0 bg-light mt-4">
                            <div class="card-body">
                                <h6 class="text-muted text-uppercase mb-3">
                                    <i class="bi bi-images text-primary"></i> Photo Gallery
                                </h6>
                                <div class="row g-3">
                    `;
                    data.photos.slice(0, 8).forEach(photo => {
                        html += `
                            <div class="col-md-3">
                                <div class="photo-preview">
                                    <img src="/storage/${photo.file_path}" class="img-fluid rounded shadow-sm" alt="Photo">
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    if (data.photos.length > 8) {
                        html += `
                            <div class="text-center mt-3">
                                <span class="badge bg-info fs-6">
                                    <i class="bi bi-plus-circle"></i> ${data.photos.length - 8} more photos
                                </span>
                            </div>
                        `;
                    }
                    html += '</div></div>';
                }
                
                document.getElementById('detailsContent').innerHTML = html;
                detailsModal.show();
            });
    }

    function getStatusClass(status) {
        return status === 'completed' ? 'success' : status === 'in_progress' ? 'info' : 'secondary';
    }
});
</script>
@endpush
