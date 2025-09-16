@extends('layouts.app')

@section('header')
<h2 class="fw-semibold fs-4 text-dark">
    <i class="bi bi-person-lines-fill text-primary me-2"></i> {{ __('User Details') }}
</h2>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-primary mb-0">
                    <i class="bi bi-person-circle me-2"></i> {{ $user->name }}
                </h5>
                <a href="{{ route('admin.user-management') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Users
                </a>
            </div>

            {{-- Basic Information --}}
            <div class="mb-4">
                <h6 class="fw-semibold text-dark mb-2">Basic Information</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                    <li class="list-group-item"><strong>Role:</strong> {{ ucfirst($user->roles->first()->name) }}</li>
                    <li class="list-group-item"><strong>Status:</strong>
                        @if($user->is_approved)
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </li>
                    <li class="list-group-item"><strong>Registered At:</strong> {{ $user->created_at->format('Y-m-d H:i:s') }}</li>
                    <li class="list-group-item"><strong>Last Login:</strong> {{ $user->last_login_at?->format('Y-m-d H:i:s') ?? 'N/A' }}</li>
                </ul>
            </div>

            {{-- Student / Alumni Information --}}
            @if(in_array($user->roles->first()->name, ['student','alumni']))
            <div class="mb-4">
                <h6 class="fw-semibold text-success mb-2">Student / Alumni Information</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Student ID:</strong> {{ $user->student_id ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Graduation Year:</strong> {{ $user->graduation_year ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Program:</strong> {{ $user->program ?? 'N/A' }}</li>
                </ul>
            </div>
            @endif

            {{-- Profile Information --}}
            @if($user->profile)
            <div class="mb-4">
                <h6 class="fw-semibold text-info mb-2">Profile Information</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Current Job:</strong> {{ $user->profile->current_job ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Company:</strong> {{ $user->profile->company ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Skills:</strong>
                        {{ $user->profile->skills ? implode(', ', $user->profile->skills) : 'N/A' }}
                    </li>
                </ul>
            </div>
            @endif

            {{-- Actions --}}
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-warning me-2">
                    <i class="bi bi-pencil-square me-1"></i> Edit User
                </a>
                <form action="{{ route('admin.user.delete', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
