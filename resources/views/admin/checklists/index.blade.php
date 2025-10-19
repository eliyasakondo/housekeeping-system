@extends('layouts.app')

@section('title')
    @php
        $appName = config('app.name', 'HK Checklist');
        if (Storage::disk('local')->exists('settings.json')) {
            $settings = json_decode(Storage::disk('local')->get('settings.json'), true);
            $appName = $settings['app_name'] ?? $appName;
        }
    @endphp
    Checklists - {{ $appName }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-clipboard-check"></i> All Checklists</h1>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.checklists.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="ID or Property name..." value="{{ request('search') }}">
                </div>
                
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="property_id" class="form-label">Property</label>
                    <select class="form-select" id="property_id" name="property_id">
                        <option value="">All Properties</option>
                        @foreach($properties as $property)
                            <option value="{{ $property->id }}" {{ request('property_id') == $property->id ? 'selected' : '' }}>
                                {{ $property->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="housekeeper_id" class="form-label">Housekeeper</label>
                    <select class="form-select" id="housekeeper_id" name="housekeeper_id">
                        <option value="">All Housekeepers</option>
                        @foreach($housekeepers as $housekeeper)
                            <option value="{{ $housekeeper->id }}" {{ request('housekeeper_id') == $housekeeper->id ? 'selected' : '' }}>
                                {{ $housekeeper->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1">
                    <label for="date_from" class="form-label">From</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>

                <div class="col-md-1">
                    <label for="date_to" class="form-label">To</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Summary -->
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Showing <strong>{{ $checklists->total() }}</strong> checklist(s)
        @if(request()->hasAny(['search', 'status', 'property_id', 'housekeeper_id', 'date_from', 'date_to']))
            <a href="{{ route('admin.checklists.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                <i class="bi bi-x-circle"></i> Clear Filters
            </a>
        @endif
    </div>

    <!-- Checklists Table -->
    <div class="card">
        <div class="card-body">
            @if($checklists->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Property</th>
                                <th>Housekeeper</th>
                                <th>Status</th>
                                <th>Progress</th>
                                <th>Date</th>
                                <th>Started</th>
                                <th>Completed</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checklists as $checklist)
                                <tr>
                                    <td>
                                        <strong>#{{ $checklist->id }}</strong>
                                    </td>
                                    <td>
                                        <i class="bi bi-building"></i> {{ $checklist->property->name }}
                                    </td>
                                    <td>
                                        <i class="bi bi-person"></i> {{ $checklist->housekeeper->name }}
                                    </td>
                                    <td>
                                        @if($checklist->status == 'pending')
                                            <span class="badge bg-warning">
                                                <i class="bi bi-clock"></i> Pending
                                            </span>
                                        @elseif($checklist->status == 'in_progress')
                                            <span class="badge bg-info">
                                                <i class="bi bi-play-circle"></i> In Progress
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Completed
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($checklist->status == 'pending')
                                            <span class="text-muted">Not started</span>
                                        @else
                                            @php
                                                $totalItems = $checklist->items()->count();
                                                $completedItems = $checklist->items()->where('is_completed', true)->count();
                                                $percentage = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
                                            @endphp
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $percentage }}%;" 
                                                     aria-valuenow="{{ $percentage }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $percentage }}%
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ $completedItems }}/{{ $totalItems }} tasks</small>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $checklist->scheduled_date->format('M d, Y') }}</small>
                                        @if($checklist->scheduled_time)
                                            <br><small class="text-muted"><i class="bi bi-clock"></i> {{ date('g:i A', strtotime($checklist->scheduled_time)) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($checklist->started_at)
                                            <small>{{ $checklist->started_at->format('M d, H:i') }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($checklist->completed_at)
                                            <small>{{ $checklist->completed_at->format('M d, H:i') }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.checklists.show', $checklist) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        
                                        @if($checklist->status == 'pending')
                                            <form action="{{ route('admin.checklists.destroy', $checklist) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this checklist?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $checklists->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <p class="mt-3 text-muted">No checklists found</p>
                    @if(request()->hasAny(['search', 'status', 'property_id', 'housekeeper_id', 'date_from', 'date_to']))
                        <a href="{{ route('admin.checklists.index') }}" class="btn btn-primary">
                            Clear Filters
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
