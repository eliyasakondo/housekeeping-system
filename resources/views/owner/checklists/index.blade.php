@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-lg mb-4" role="alert" style="border-radius: 15px; border-left: 5px solid #38ef7d;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg" style="background: var(--primary-gradient); border-radius: 20px;">
                <div class="card-body py-4 px-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="text-white mb-0 fw-bold" style="font-size: 2rem;">
                            <i class="bi bi-clipboard-check-fill me-2"></i>Checklists
                        </h1>
                        <button type="button" class="btn btn-light btn-lg blink-button" data-bs-toggle="modal" data-bs-target="#createAssignmentModal" style="border-radius: 12px; font-weight: 600;">
                            <i class="bi bi-plus-circle-fill me-2"></i>Assign Task
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-lg mb-4" style="border-radius: 20px;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('owner.checklists.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label fw-bold">
                        <i class="bi bi-search me-1"></i>Search
                    </label>
                    <input type="text" class="form-control form-control-lg" id="search" name="search" 
                           placeholder="Property or Room..." value="{{ request('search') }}" style="border-radius: 12px;">
                </div>
                
                <div class="col-md-3">
                    <label for="status" class="form-label fw-bold">
                        <i class="bi bi-flag me-1"></i>Status
                    </label>
                    <select class="form-select form-select-lg" id="status" name="status" style="border-radius: 12px;">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="property_id" class="form-label fw-bold">
                        <i class="bi bi-building me-1"></i>Property
                    </label>
                    <select class="form-select form-select-lg" id="property_id" name="property_id" style="border-radius: 12px;">
                        <option value="">All Properties</option>
                        @foreach($properties as $property)
                            <option value="{{ $property->id }}" {{ request('property_id') == $property->id ? 'selected' : '' }}>
                                {{ $property->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-lg w-100" style="background: var(--primary-gradient); color: white; border-radius: 12px; font-weight: 600;">
                        <i class="bi bi-funnel-fill me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results -->
    <div class="card border-0 shadow-lg" style="border-radius: 20px;">
        <div class="card-body p-4">
            @if($checklists->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" style="font-size: 1rem;">
                        <thead style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);">
                            <tr>
                                <th class="py-3" style="border-radius: 12px 0 0 12px;"><i class="bi bi-building me-2"></i>Property</th>
                                <th class="py-3"><i class="bi bi-door-closed me-2"></i>Rooms</th>
                                <th class="py-3"><i class="bi bi-person-badge me-2"></i>Housekeeper</th>
                                <th class="py-3"><i class="bi bi-calendar-event me-2"></i>Scheduled</th>
                                <th class="py-3"><i class="bi bi-flag me-2"></i>Status</th>
                                <th class="py-3" style="border-radius: 0 12px 12px 0;"><i class="bi bi-gear me-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checklists as $checklist)
                                <tr>
                                    <td class="fw-bold">{{ $checklist->property->name }}</td>
                                    <td>
                                        @if($checklist->room)
                                            <span class="badge bg-info px-2 py-1" style="border-radius: 8px;">
                                                <i class="bi bi-arrow-right-circle me-1"></i>{{ $checklist->room->name }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary px-2 py-1" style="border-radius: 8px;">
                                                <i class="bi bi-door-closed me-1"></i>{{ $checklist->property->rooms->count() }} rooms
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $checklist->housekeeper->name }}</td>
                                    <td>
                                        {{ $checklist->scheduled_date->format('M d, Y') }}
                                        @if($checklist->scheduled_time)
                                            <br><small class="text-muted"><i class="bi bi-clock"></i> {{ date('g:i A', strtotime($checklist->scheduled_time)) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($checklist->status === 'pending')
                                            <span class="badge bg-secondary px-3 py-2" style="border-radius: 10px;">
                                                <i class="bi bi-hourglass"></i> Pending
                                            </span>
                                        @elseif($checklist->status === 'in_progress')
                                            <span class="badge bg-info px-3 py-2" style="border-radius: 10px;">
                                                <i class="bi bi-play-circle"></i> In Progress
                                            </span>
                                        @else
                                            <span class="badge bg-success px-3 py-2" style="border-radius: 10px;">
                                                <i class="bi bi-check-circle"></i> Completed
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('owner.checklists.show', $checklist) }}" class="btn btn-sm" style="background: var(--primary-gradient); color: white; border-radius: 10px;">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $checklists->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                    <p class="text-muted mt-3 fs-5">No checklists found</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Assignment Modal -->
<div class="modal fade" id="createAssignmentModal" tabindex="-1" aria-labelledby="createAssignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0" style="background: var(--primary-gradient); border-radius: 20px 20px 0 0;">
                <h5 class="modal-title text-white fw-bold" id="createAssignmentModalLabel">
                    <i class="bi bi-plus-circle-fill me-2"></i>Assign New Task
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createAssignmentForm" method="POST" action="{{ route('owner.checklists.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-building text-primary"></i> Property *
                        </label>
                        <select class="form-select form-select-lg" name="property_id" required>
                            <option value="">-- Select Property --</option>
                            @foreach($properties as $property)
                                <option value="{{ $property->id }}" {{ !$property->is_ready ? 'disabled' : '' }}>
                                    {{ $property->name }}
                                    @if(!$property->is_ready)
                                        -  Not Ready (No tasks assigned)
                                    @else
                                        ✓
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> Which property needs cleaning?
                            @if($properties->where('is_ready', false)->count() > 0)
                                <br><span class="text-warning"><i class="bi bi-exclamation-triangle"></i> Some properties are not ready because they have no tasks assigned to rooms.</span>
                            @endif
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-person-badge text-info"></i> Housekeeper *
                        </label>
                        <select class="form-select form-select-lg" name="housekeeper_id" required>
                            <option value="">-- Select Housekeeper --</option>
                            @foreach(auth()->user()->housekeepers as $housekeeper)
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
                        <i class="bi bi-check-circle-fill"></i> Assign Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes blinkButton {
        0%, 100% {
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.6);
            transform: scale(1);
        }
        50% {
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.8);
            transform: scale(1.05);
        }
    }

    .blink-button {
        animation: blinkButton 2s ease-in-out infinite;
    }

    .blink-button:hover {
        animation: none !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
</style>
@endpush
@endsection
