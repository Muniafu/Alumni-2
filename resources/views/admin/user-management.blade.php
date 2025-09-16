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

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('admin.user-management') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by name/email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </div>
    </form>

    {{-- Bulk Action Form --}}
    <form method="POST" action="{{ route('admin.users.bulk-action') }}">
        @csrf
        <div class="mb-2">
            <button type="submit" name="action" value="delete" class="btn btn-sm btn-danger" onclick="return confirm('Delete selected users?')">
                <i class="bi bi-trash me-1"></i> Bulk Delete
            </button>
            <button type="submit" name="action" value="restore" class="btn btn-sm btn-success">
                <i class="bi bi-arrow-clockwise me-1"></i> Restore Selected
            </button>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="{{ $user->trashed() ? 'table-danger' : '' }}">
                                    <td>
                                        <input type="checkbox" name="selected_users[]" value="{{ $user->id }}">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ optional($user->roles->first())->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($user->is_approved)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user.show', $user) }}" class="btn btn-sm btn-outline-info">View</a>
                                        <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        @if(!$user->trashed())
                                            <form action="{{ route('admin.user.delete', $user) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE') {{-- keep this for single delete --}}
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.user.restore', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success">Restore</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>

</div>

{{-- JS for select all --}}
<script>
document.getElementById('select-all').addEventListener('click', function(e) {
    const checkboxes = document.querySelectorAll('input[name="selected_users[]"]');
    checkboxes.forEach(cb => cb.checked = e.target.checked);
});
</script>
@endsection
