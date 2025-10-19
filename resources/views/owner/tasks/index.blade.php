@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-list-task me-2"></i>My Tasks</h4>
                    <a href="{{ route('owner.tasks.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Add Custom Task
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Note:</strong> Default tasks (marked with star) are system-wide and cannot be edited. You can create custom tasks for your properties.
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Task Name</th>
                                    <th>Type</th>
                                    <th>Property</th>
                                    <th>Room</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tasks as $task)
                                <tr>
                                    <td>
                                        <strong>{{ $task->name }}</strong>
                                    </td>
                                    <td>
                                        @if($task->is_default)
                                            <span class="badge bg-primary">
                                                <i class="bi bi-star-fill me-1"></i>Default
                                            </span>
                                        @else
                                            <span class="badge bg-info">My Custom</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->property)
                                            {{ $task->property->name }}
                                        @else
                                            <span class="text-muted">All Properties</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->rooms && $task->rooms->count() > 0)
                                            @if($task->rooms->count() <= 2)
                                                {{ $task->rooms->pluck('name')->join(', ') }}
                                            @else
                                                {{ $task->rooms->count() }} rooms
                                            @endif
                                        @else
                                            <span class="text-muted">All Rooms</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$task->is_default)
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('owner.tasks.edit', $task) }}" class="btn btn-outline-primary">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <form action="{{ route('owner.tasks.destroy', $task) }}" method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted small">
                                                <i class="bi bi-lock"></i> Read-only
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox display-1"></i>
                                        <p class="mt-2">No tasks found.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 d-flex justify-content-center">
                        {{ $tasks->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
