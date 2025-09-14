<x-admin-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Permissions Management') }}
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('admin.permissions.update') }}" method="POST">
                    @csrf

                    {{-- Role Selection --}}
                    <div class="mb-4">
                        <label for="role_id" class="form-label fw-semibold">
                            <i class="bi bi-person-badge me-1 text-primary"></i> Select Role
                        </label>
                        <select name="role_id" id="role_id" class="form-select" required>
                            <option value="">Select a Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Permissions Grid --}}
                    <div class="row g-3">
                        @foreach($permissions as $permission)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input id="permission-{{ $permission->id }}"
                                           name="permissions[]"
                                           type="checkbox"
                                           value="{{ $permission->id }}"
                                           class="form-check-input">
                                    <label for="permission-{{ $permission->id }}" class="form-check-label text-muted">
                                        {{ ucfirst($permission->name) }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Submit Button --}}
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success shadow-sm">
                            <i class="bi bi-shield-lock-fill me-2"></i> Update Permissions
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('role_id').addEventListener('change', function() {
            const roleId = this.value;
            if (!roleId) return;

            fetch(`/admin/permissions/${roleId}`)
                .then(response => response.json())
                .then(data => {
                    // Reset checkboxes
                    document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);

                    // Check the permissions the role has
                    data.permissions.forEach(permissionId => {
                        const checkbox = document.getElementById(`permission-${permissionId}`);
                        if (checkbox) checkbox.checked = true;
                    });
                });
        });
    </script>
    @endpush
</x-admin-layout>
