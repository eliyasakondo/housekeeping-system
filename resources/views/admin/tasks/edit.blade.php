@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Task</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Task Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $task->name) }}"
                                   placeholder="e.g., Sweep floor, Clean windows, Make bed"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description (Optional)</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Add detailed instructions for this task...">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Provide specific instructions or notes for housekeepers
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Task Type <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input @error('is_default') is-invalid @enderror" 
                                       type="radio" 
                                       name="is_default" 
                                       id="is_default_true" 
                                       value="1" 
                                       {{ old('is_default', $task->is_default) == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_default_true">
                                    <strong>Default Task</strong>
                                    <small class="d-block text-muted">Available for all properties system-wide</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('is_default') is-invalid @enderror" 
                                       type="radio" 
                                       name="is_default" 
                                       id="is_default_false" 
                                       value="0" 
                                       {{ old('is_default', $task->is_default) == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_default_false">
                                    <strong>Custom Task</strong>
                                    <small class="d-block text-muted">Specific to a property or room</small>
                                </label>
                            </div>
                            @error('is_default')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="property_id" class="form-label">Property (Optional)</label>
                            <select class="form-select @error('property_id') is-invalid @enderror" 
                                    id="property_id" 
                                    name="property_id">
                                <option value="">-- All Properties --</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}" 
                                            {{ old('property_id', $task->property_id) == $property->id ? 'selected' : '' }}>
                                        {{ $property->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('property_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="room_id" class="form-label">Room (Optional)</label>
                            <select class="form-select @error('room_id') is-invalid @enderror" 
                                    id="room_id" 
                                    name="room_id">
                                <option value="">-- All Rooms --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" 
                                            {{ old('room_id', $task->room_id) == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }}
                                        @if($room->property)
                                            ({{ $room->property->name }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Update Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
