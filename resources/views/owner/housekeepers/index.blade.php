@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="bi bi-people-fill"></i> My Housekeepers</h2>
            <p class="text-muted">Manage your housekeeping staff</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('owner.housekeepers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Housekeeper
            </a>
        </div>
    </div>

    @if($housekeepers->count() > 0)
        <div class="row">
            @foreach($housekeepers as $housekeeper)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-person-badge"></i> {{ $housekeeper->name }}
                            </h5>
                            <p class="card-text">
                                <strong>Email:</strong> {{ $housekeeper->email }}<br>
                                @if($housekeeper->phone)
                                    <strong>Phone:</strong> {{ $housekeeper->phone }}<br>
                                @endif
                                <strong>Member since:</strong> {{ $housekeeper->created_at->format('M d, Y') }}
                            </p>
                            <hr>
                            <p class="mb-1">
                                <strong>Active Assignments:</strong> 
                                {{ $housekeeper->checklists()->whereIn('status', ['pending', 'in_progress'])->count() }}
                            </p>
                            <p class="mb-3">
                                <strong>Completed Checklists:</strong> 
                                {{ $housekeeper->checklists()->where('status', 'completed')->count() }}
                            </p>
                            <div class="btn-group" role="group">
                                <a href="{{ route('owner.housekeepers.edit', $housekeeper) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('owner.housekeepers.destroy', $housekeeper) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure you want to remove this housekeeper?')">
                                        <i class="bi bi-trash"></i> Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $housekeepers->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> You haven't added any housekeepers yet. 
            <a href="{{ route('owner.housekeepers.create') }}">Add your first housekeeper</a> to get started.
        </div>
    @endif
</div>
@endsection
