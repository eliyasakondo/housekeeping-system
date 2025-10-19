@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="bi bi-door-closed"></i> Rooms for {{ $property->name }}</h2>
            <p class="text-muted">{{ $property->address }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('owner.rooms.create', $property) }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Room
            </a>
            <a href="{{ route('owner.properties.show', $property) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Property
            </a>
        </div>
    </div>

    @if($rooms->count() > 0)
        <div class="row">
            @foreach($rooms as $room)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-door-open"></i> {{ $room->name }}
                            </h5>
                            @if($room->description)
                                <p class="card-text text-muted">{{ $room->description }}</p>
                            @endif
                            <p class="mb-3">
                                <span class="badge bg-info">
                                    <i class="bi bi-camera"></i> Min {{ $room->min_photos }} photos required
                                </span>
                            </p>
                            <div class="btn-group" role="group">
                                <a href="{{ route('owner.rooms.edit', [$property, $room]) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('owner.rooms.destroy', [$property, $room]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this room?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $rooms->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> No rooms added yet. 
            <a href="{{ route('owner.rooms.create', $property) }}">Add your first room</a> to get started.
        </div>
    @endif
</div>
@endsection
