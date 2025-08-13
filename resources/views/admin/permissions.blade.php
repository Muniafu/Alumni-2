<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.permissions.update') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="role_id" :value="__('Select Role')" />
                            <select name="role_id" id="role_id" class="form-select rounded-md shadow-sm w-full" required>
                                <option value="">Select a Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($permissions as $permission)
                            <div class="flex items-center">
                                <input id="permission-{{ $permission->id }}" name="permissions[]" type="checkbox"
                                    value="{{ $permission->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <label for="permission-{{ $permission->id }}" class="ml-2 text-sm text-gray-700">
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-primary-button>Update Permissions</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('role_id').addEventListener('change', function() {
            const roleId = this.value;
            if (!roleId) return;

            // Fetch permissions for selected role
            fetch(`/admin/permissions/${roleId}`)
                .then(response => response.json())
                .then(data => {
                    // Uncheck all permissions first
                    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                        checkbox.checked = false;
                    });

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
