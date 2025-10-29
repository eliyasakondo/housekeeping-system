@extends('layouts.app')

@section('title')
    @php
        $appName = config('app.name', 'HK Checklist');
        if (Storage::disk('local')->exists('settings.json')) {
            $settings = json_decode(Storage::disk('local')->get('settings.json'), true);
            $appName = $settings['app_name'] ?? $appName;
        }
    @endphp
    Tasks - {{ $appName }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-list-task me-2"></i>Task Management</h4>
                    <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Add New Task
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

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Task Name</th>
                                    <th style="width: 10%;">Type</th>
                                    <th style="width: 20%;">Property</th>
                                    <th style="width: 15%;">Room</th>
                                    <th style="width: 10%;">Created</th>
                                    <th style="width: 20%;" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tasks as $task)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $task->name }}</strong>
                                            @if($task->description)
                                                <br><small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($task->is_default)
                                            <span class="badge bg-primary">
                                                <i class="bi bi-star-fill me-1"></i>Default
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Custom</span>
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
                                        @php
                                            // Check if task has many-to-many rooms relationship data
                                            $manyRooms = $task->rooms && $task->rooms->count() > 0;
                                            // Check if task has single room_id (direct foreign key)
                                            $singleRoomId = $task->room_id ?? null;
                                        @endphp
                                        
                                        @if($manyRooms)
                                            {{-- Display many-to-many rooms --}}
                                            @if($task->rooms->count() <= 2)
                                                {{ $task->rooms->pluck('name')->join(', ') }}
                                            @else
                                                <span class="badge bg-info">{{ $task->rooms->count() }} rooms</span>
                                            @endif
                                        @elseif($singleRoomId)
                                            {{-- Display single room from room_id --}}
                                            @php
                                                $singleRoom = \App\Models\Room::find($singleRoomId);
                                            @endphp
                                            @if($singleRoom)
                                                {{ $singleRoom->name }}
                                            @else
                                                <span class="text-muted">Room not found</span>
                                            @endif
                                        @else
                                            <span class="text-muted">All Rooms</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $task->created_at->format('M d, Y') }}
                                        </small>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.tasks.edit', $task) }}" 
                                               class="btn btn-outline-primary"
                                               title="Edit Task">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.tasks.destroy', $task) }}" 
                                                  method="POST" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this task? This will remove it from all rooms and future checklists.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-outline-danger"
                                                        title="Delete Task">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox display-1"></i>
                                        <p class="mt-2">No tasks found. Create your first task!</p>
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
