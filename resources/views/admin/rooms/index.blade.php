@extends('layouts.app')

@section('title')
    @php
        $appName = config('app.name', 'HK Checklist');
        if (Storage::disk('local')->exists('settings.json')) {
            $settings = json_decode(Storage::disk('local')->get('settings.json'), true);
            $appName = $settings['app_name'] ?? $appName;
        }
    @endphp
    Rooms - {{ $appName }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-door-open me-2"></i>Default Room Templates</h4>
                    <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Add Room Template
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
                        <strong>Default Room Templates:</strong> These are system-wide room types that owners can use when creating properties (Master Bedroom, Kitchen, Bathroom, etc.).
                    </div>

                    <div class="row">
                        @forelse($rooms as $room)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-door-open text-primary me-2"></i>{{ $room->name }}
                                    </h5>
                                    @if($room->description)
                                        <p class="card-text text-muted small">{{ $room->description }}</p>
                                    @endif
                                    <p class="mb-2">
                                        <span class="badge bg-info">Min: {{ $room->min_photos }} photos</span>
                                        <span class="badge bg-primary">Default Template</span>
                                    </p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="btn-group btn-group-sm w-100" role="group">
                                        <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="d-inline w-50"
                                              onsubmit="return confirm('Delete this room template?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger w-100">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-inbox display-1"></i>
                                <p class="mt-3">No default room templates. Create your first template!</p>
                                <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary mt-2">
                                    <i class="bi bi-plus-circle me-1"></i>Create Room Template
                                </a>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-3 d-flex justify-content-center">
                        {{ $rooms->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
