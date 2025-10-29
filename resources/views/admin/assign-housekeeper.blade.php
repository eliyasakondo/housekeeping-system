@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1"><i class="bi bi-person-plus-fill me-2"></i>Assign Housekeeper</h2>
                    <p class="text-muted mb-0">Create cleaning assignments for any property and housekeeper</p>
                </div>
            </div>

            <div class="row">
                <!-- Quick Assignment Form -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-calendar-plus me-2"></i>Create New Assignment</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.calendar.assign') }}" method="POST" id="assignForm">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="property_id" class="form-label fw-bold">
                                        <i class="bi bi-building me-1"></i>Select Property
                                    </label>
                                    <select name="property_id" id="property_id" class="form-select @error('property_id') is-invalid @enderror" required>
                                        <option value="">-- Choose a property --</option>
                                        @foreach($properties as $property)
                                            <option value="{{ $property->id }}" 
                                                    {{ !$property->is_ready ? 'disabled' : '' }}
                                                    data-rooms="{{ $property->rooms->count() }}"
                                                    data-tasks="{{ $property->rooms->sum(fn($r) => $r->tasks->count()) }}">
                                                {{ $property->name }} (Owner: {{ $property->owner->name }})
                                                @if(!$property->is_ready)
                                                    (⚠️ Not Ready - Add rooms and tasks first)
                                                @else
                                                    ({{ $property->rooms->count() }} rooms, {{ $property->rooms->sum(fn($r) => $r->tasks->count()) }} tasks)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('property_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($properties->where('is_ready', false)->count() > 0)
                                        <small class="text-muted d-block mt-1">
                                            <i class="bi bi-info-circle me-1"></i>Properties without rooms or tasks are disabled
                                        </small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="housekeeper_id" class="form-label fw-bold">
                                        <i class="bi bi-person-badge me-1"></i>Select Housekeeper
                                    </label>
                                    <select name="housekeeper_id" id="housekeeper_id" class="form-select @error('housekeeper_id') is-invalid @enderror" required>
                                        <option value="">-- Choose a housekeeper --</option>
                                        @forelse($housekeepers as $housekeeper)
                                            <option value="{{ $housekeeper->id }}">
                                                {{ $housekeeper->name }} (Owner: {{ $housekeeper->owner->name ?? 'Unassigned' }})
                                            </option>
                                        @empty
                                            <option value="" disabled>No housekeepers available</option>
                                        @endforelse
                                    </select>
                                    @error('housekeeper_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="scheduled_date" class="form-label fw-bold">
                                            <i class="bi bi-calendar-event me-1"></i>Date
                                        </label>
                                        <input type="date" name="scheduled_date" id="scheduled_date" 
                                               class="form-control @error('scheduled_date') is-invalid @enderror" 
                                               value="{{ old('scheduled_date', date('Y-m-d')) }}" 
                                               min="{{ date('Y-m-d') }}"
                                               required>
                                        @error('scheduled_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="scheduled_time" class="form-label fw-bold">
                                            <i class="bi bi-clock me-1"></i>Time (Optional)
                                        </label>
                                        <input type="time" name="scheduled_time" id="scheduled_time" 
                                               class="form-control @error('scheduled_time') is-invalid @enderror"
                                               value="{{ old('scheduled_time') }}">
                                        @error('scheduled_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Leave blank for all-day assignment</small>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg" 
                                            {{ $housekeepers->count() == 0 || $properties->where('is_ready', true)->count() == 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-check-circle me-2"></i>Create Assignment
                                    </button>
                                    <a href="{{ route('admin.calendar') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-calendar me-2"></i>View Full Calendar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats & Help -->
                <div class="col-lg-6">
                    <!-- Quick Stats -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>System Overview</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="p-3 border rounded bg-light">
                                        <h3 class="mb-1 text-primary">{{ $properties->count() }}</h3>
                                        <small class="text-muted">Properties</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 border rounded bg-light">
                                        <h3 class="mb-1 text-success">{{ $housekeepers->count() }}</h3>
                                        <small class="text-muted">Housekeepers</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 border rounded bg-light">
                                        <h3 class="mb-1 text-info">{{ $properties->where('is_ready', true)->count() }}</h3>
                                        <small class="text-muted">Ready Properties</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick Links</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-person-plus me-2"></i>Add New User
                                </a>
                                <a href="{{ route('admin.properties.create') }}" class="btn btn-outline-success">
                                    <i class="bi bi-building-add me-2"></i>Add New Property
                                </a>
                                <a href="{{ route('admin.checklists.index') }}" class="btn btn-outline-info">
                                    <i class="bi bi-clipboard-check me-2"></i>View All Assignments
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="card shadow-sm border-info">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-shield-check me-2"></i>Admin Access</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">As an administrator, you can:</p>
                            <ul class="mb-0">
                                <li>Assign any housekeeper to any property</li>
                                <li>View all assignments across all owners</li>
                                <li>Monitor system-wide cleaning schedules</li>
                                <li>Manage users, properties, and tasks</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.form-label {
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
    padding: 0.75rem;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
}

.btn {
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
}

.btn-lg {
    padding: 1rem 2rem;
}
</style>

<script>
document.getElementById('assignForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';

    fetch('{{ route("admin.calendar.assign") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            this.reset();
            
            // Redirect to calendar after 1.5 seconds
            setTimeout(() => {
                window.location.href = '{{ route("admin.calendar") }}';
            }, 1500);
        } else {
            showToast(data.message || 'Error creating assignment', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while creating the assignment', 'error');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});
</script>
@endsection
