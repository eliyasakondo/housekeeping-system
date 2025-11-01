@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg" style="background: var(--primary-gradient);">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="text-white mb-2">
                                <i class="bi bi-calendar-check"></i> Cleaning Schedule Calendar
                            </h2>
                            <p class="text-white mb-0" style="opacity: 0.9;">
                                <i class="bi bi-info-circle"></i> Assign housekeepers to properties and manage cleaning schedules
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-light btn-lg shadow-lg hover-lift blink-button" data-bs-toggle="modal" data-bs-target="#assignModal">
                                <i class="bi bi-plus-circle-fill"></i> Create Assignment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-info border-0 shadow-sm alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-lightbulb-fill" style="font-size: 2rem; opacity: 0.7; margin-right: 1rem;"></i>
                    <div>
                        <strong>Quick Tip:</strong> Click on any date in the calendar below to quickly create a cleaning assignment for that day!
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Legend -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-md">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-3">
                        <strong class="me-2">
                            <i class="bi bi-flag-fill"></i> Status Legend:
                        </strong>
                        <span class="badge bg-secondary fs-6 shadow-sm">
                            <i class="bi bi-hourglass"></i> Pending
                        </span>
                        <span class="badge bg-info fs-6 shadow-sm">
                            <i class="bi bi-play-circle"></i> In Progress
                        </span>
                        <span class="badge bg-success fs-6 shadow-sm">
                            <i class="bi bi-check-circle"></i> Completed
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-xl">
                <div class="card-body p-4">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assignment Modal - Enhanced -->
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-xl">
            <div class="modal-header border-0 text-white" style="background: var(--primary-gradient);">
                <h4 class="modal-title">
                    <i class="bi bi-calendar-plus"></i> Create New Assignment
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="assignForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-building-fill text-primary"></i> Property *
                        </label>
                        <select class="form-select form-select-lg" name="property_id" required>
                            <option value="">-- Select Property --</option>
                            @foreach($properties as $property)
                                @php
                                    $isDisabled = !$property->is_ready;
                                @endphp
                                <option value="{{ $property->id }}" {{ $isDisabled ? 'disabled' : '' }}>
                                    {{ $property->name }}
                                    @if(!$property->is_ready)
                                        - ⚠️ No Tasks Assigned
                                    @else
                                        ✓
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> Choose which property to clean
                            @php
                                $notReadyCount = $properties->where('is_ready', false)->count();
                            @endphp
                            @if($notReadyCount > 0)
                                <br><span class="text-danger"><i class="bi bi-exclamation-triangle"></i> {{ $notReadyCount }} property(ies) have no rooms or tasks assigned.</span>
                            @endif
                        </small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-person-badge text-info"></i> Housekeeper *
                        </label>
                        <select class="form-select form-select-lg" name="housekeeper_id" required>
                            <option value="">-- Select Housekeeper --</option>
                            @foreach($housekeepers as $housekeeper)
                                <option value="{{ $housekeeper->id }}">
                                    {{ $housekeeper->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> Assign a housekeeper to this task
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-calendar-event text-success"></i> Scheduled Date *
                        </label>
                        <input type="date" class="form-control form-control-lg" name="scheduled_date" required min="{{ date('Y-m-d') }}">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> When should the cleaning happen?
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-clock text-info"></i> Scheduled Time (Optional)
                        </label>
                        <input type="time" class="form-control form-control-lg" name="scheduled_time">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> What time should the cleaning start?
                        </small>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success shadow-lg">
                        <i class="bi bi-check-circle-fill"></i> Create Assignment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-xl">
            <div class="modal-header border-0 text-white" style="background: var(--info-gradient);">
                <h4 class="modal-title">
                    <i class="bi bi-info-circle-fill"></i> Checklist Details
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="detailsContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-3">Loading details...</p>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-danger shadow-lg" id="deleteBtn" style="display:none;">
                    <i class="bi bi-trash-fill"></i> Delete Assignment
                </button>
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
<style>
    /* Blinking animation for Create Assignment button */
    @keyframes blinkButton {
        0%, 100% {
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.6), 0 0 40px rgba(102, 126, 234, 0.4);
            transform: scale(1);
        }
        50% {
            box-shadow: 0 0 30px rgba(102, 126, 234, 0.8), 0 0 60px rgba(102, 126, 234, 0.6);
            transform: scale(1.05);
        }
    }
    
    .blink-button {
        animation: blinkButton 2s ease-in-out infinite;
        position: relative;
    }
    
    /* Keep hover effect - stop animation on hover */
    .blink-button:hover {
        animation: none !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'));
    var assignModal = new bootstrap.Modal(document.getElementById('assignModal'));
    var currentChecklistId = null;

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '{{ route("owner.calendar.events") }}',
        eventDidMount: function(info) {
            // Add status class to event element for custom styling
            const status = info.event.extendedProps.status || 'pending';
            info.el.classList.add('status-' + status.replace('_', '-'));
        },
        dateClick: function(info) {
            // When clicking on an empty date, open assignment modal with that date pre-filled
            const dateInput = document.querySelector('input[name="scheduled_date"]');
            if (dateInput) {
                dateInput.value = info.dateStr;
            }
            assignModal.show();
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

    // Handle assignment form submission
    document.getElementById('assignForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';

        fetch('{{ route("owner.calendar.assign") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Error creating assignment');
                });
            }
            return response.json();
        })
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            
            if (data.success) {
                // Close modal properly with backdrop removal
                const modalElement = document.getElementById('assignModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) {
                    modalInstance.hide();
                }
                
                // Remove any lingering backdrops
                setTimeout(() => {
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    backdrops.forEach(backdrop => backdrop.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                }, 300);
                
                this.reset();
                showToast('Assignment created successfully!', 'success');
                
                // Refresh calendar instead of page reload
                calendar.refetchEvents();
            }
        })
        .catch(error => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            showToast(error.message || 'Error creating assignment', 'error');
            console.error(error);
        });
    });

    function showChecklistDetails(checklistId) {
        currentChecklistId = checklistId;
        document.getElementById('detailsContent').innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div><p class="text-muted mt-3">Loading details...</p></div>';
        
        fetch(`{{ url('owner/calendar/checklist') }}/${checklistId}`)
            .then(response => response.json())
            .then(data => {
                const statusBadge = data.checklist.status === 'completed' ? 'success' : 
                                  data.checklist.status === 'in_progress' ? 'warning' : 'secondary';
                const statusIcon = data.checklist.status === 'completed' ? 'bi-check-circle-fill' : 
                                 data.checklist.status === 'in_progress' ? 'bi-play-circle-fill' : 'bi-hourglass';
                
                let html = `
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="text-muted text-uppercase mb-3">
                                        <i class="bi bi-building-fill text-primary"></i> Property Details
                                    </h6>
                                    <p class="mb-2">
                                        <i class="bi bi-house-door"></i> <strong>Name:</strong><br>
                                        <span class="ms-4">${data.property.name}</span>
                                    </p>
                                    <p class="mb-2">
                                        <i class="bi bi-geo-alt-fill text-danger"></i> <strong>Address:</strong><br>
                                        <span class="ms-4">${data.property.address}</span>
                                    </p>
                                    <p class="mb-0">
                                        <i class="bi bi-person-badge text-info"></i> <strong>Housekeeper:</strong><br>
                                        <span class="ms-4">${data.housekeeper.name}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="text-muted text-uppercase mb-3">
                                        <i class="bi bi-calendar-check-fill text-success"></i> Schedule Details
                                    </h6>
                                    <p class="mb-2">
                                        <i class="bi bi-calendar-event"></i> <strong>Scheduled Date:</strong><br>
                                        <span class="ms-4">${new Date(data.checklist.scheduled_date).toLocaleDateString()}</span>
                                    </p>
                                    ${data.checklist.scheduled_time ? `
                                        <p class="mb-2">
                                            <i class="bi bi-clock-fill text-info"></i> <strong>Scheduled Time:</strong><br>
                                            <span class="ms-4">${data.checklist.scheduled_time}</span>
                                        </p>
                                    ` : ''}
                                    <p class="mb-2">
                                        <i class="${statusIcon}"></i> <strong>Status:</strong><br>
                                        <span class="badge bg-${statusBadge} fs-6 ms-4 mt-1">
                                            <i class="${statusIcon}"></i> ${data.checklist.status.replace('_', ' ').toUpperCase()}
                                        </span>
                                    </p>
                                    ${data.checklist.started_at ? `
                                        <p class="mb-2">
                                            <i class="bi bi-play-circle"></i> <strong>Started:</strong><br>
                                            <span class="ms-4">${new Date(data.checklist.started_at).toLocaleString()}</span>
                                        </p>
                                    ` : ''}
                                    ${data.checklist.completed_at ? `
                                        <p class="mb-0">
                                            <i class="bi bi-check-circle"></i> <strong>Completed:</strong><br>
                                            <span class="ms-4">${new Date(data.checklist.completed_at).toLocaleString()}</span>
                                        </p>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
                
                document.getElementById('detailsContent').innerHTML = html;
                
                // Show delete button only for pending checklists
                if (data.checklist.status === 'pending') {
                    document.getElementById('deleteBtn').style.display = 'block';
                } else {
                    document.getElementById('deleteBtn').style.display = 'none';
                }
                
                detailsModal.show();
            });
    }

    // Handle delete
    document.getElementById('deleteBtn').addEventListener('click', function() {
        if (!confirm('Are you sure you want to delete this assignment?')) return;

        fetch(`{{ url('owner/calendar/checklist') }}/${currentChecklistId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                detailsModal.hide();
                calendar.refetchEvents();
                showToast('Assignment deleted successfully!', 'success');
            } else {
                showToast(data.message || 'Error deleting assignment', 'error');
            }
        })
        .catch(error => {
            showToast('Error deleting assignment', 'error');
            console.error(error);
        });
    });

    function getStatusClass(status) {
        return status === 'completed' ? 'success' : status === 'in_progress' ? 'info' : 'secondary';
    }
    
    function showToast(message, type = 'info') {
        // Remove existing toasts
        const existingToasts = document.querySelectorAll('.toast');
        existingToasts.forEach(toast => toast.remove());
        
        // Create toast container if it doesn't exist
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '9999';
            document.body.appendChild(toastContainer);
        }
        
        // Create toast
        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} border-0`;
        toastEl.setAttribute('role', 'alert');
        toastEl.setAttribute('aria-live', 'assertive');
        toastEl.setAttribute('aria-atomic', 'true');
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-${type === 'success' ? 'check-circle-fill' : type === 'error' ? 'exclamation-triangle-fill' : 'info-circle-fill'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        toastContainer.appendChild(toastEl);
        const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();
        
        // Remove after hidden
        toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
    }
});
</script>
@endpush
