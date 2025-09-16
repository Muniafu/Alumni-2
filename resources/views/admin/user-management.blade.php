@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-semibold fs-4 text-dark">
        {{ __('User Management') }}
    </h2>
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-person-plus me-2"></i> Create New User
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid py-4">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-uppercase small fw-semibold text-secondary">Name</th>
                            <th scope="col" class="text-uppercase small fw-semibold text-secondary">Email</th>
                            <th scope="col" class="text-uppercase small fw-semibold text-secondary">Role</th>
                            <th scope="col" class="text-uppercase small fw-semibold text-secondary">Status</th>
                            <th scope="col" class="text-uppercase small fw-semibold text-secondary">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                {{-- Name --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-semibold text-dark">{{ $user->name }}</span>
                                    </div>
                                </td>

                                {{-- Email --}}
                                <td class="text-muted">{{ $user->email }}</td>

                                {{-- Role --}}
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ ucfirst($user->roles->first()->name) }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td>
                                    @if($user->is_approved)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i> Approved
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-hourglass-split me-1"></i> Pending
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="d-flex">
                                        {{-- View --}}
                                        <a href="{{ route('admin.user.show', $user) }}" class="btn btn-sm btn-outline-info me-2">
                                            <i class="bi bi-eye me-1"></i> View
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-sm btn-outline-primary me-2">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.user.delete', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
