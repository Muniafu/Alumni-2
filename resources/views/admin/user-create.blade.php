<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.user.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>

                                <!-- Name -->
                                <div>
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Email -->
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div>
                                    <x-input-label for="password" :value="__('Password')" />
                                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <!-- Role -->
                                <div>
                                    <x-input-label for="role" :value="__('Role')" />
                                    <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Student/Alumni Information -->
                            <div class="space-y-6" id="studentFields">
                                <h3 class="text-lg font-medium text-gray-900">Student/Alumni Information</h3>

                                <!-- Student ID -->
                                <div>
                                    <x-input-label for="student_id" :value="__('Student ID')" />
                                    <x-text-input id="student_id" class="block mt-1 w-full" type="text" name="student_id" :value="old('student_id')" />
                                    <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                                </div>

                                <!-- Graduation Year -->
                                <div>
                                    <x-input-label for="graduation_year" :value="__('Graduation Year')" />
                                    <select id="graduation_year" name="graduation_year" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Select Graduation Year</option>
                                        @foreach($graduationYears as $year)
                                            <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('graduation_year')" class="mt-2" />
                                </div>

                                <!-- Program -->
                                <div>
                                    <x-input-label for="program" :value="__('Program')" />
                                    <x-text-input id="program" class="block mt-1 w-full" type="text" name="program" :value="old('program')" />
                                    <x-input-error :messages="$errors->get('program')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.user-management') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button class="ml-3">
                                {{ __('Create User') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Show/hide student fields based on role selection
            document.getElementById('role').addEventListener('change', function() {
                const studentFields = document.getElementById('studentFields');
                if (this.value === 'student' || this.value === 'alumni') {
                    studentFields.style.display = 'block';
                    // Make fields required
                    document.getElementById('student_id').required = true;
                    document.getElementById('graduation_year').required = true;
                    document.getElementById('program').required = true;
                } else {
                    studentFields.style.display = 'none';
                    // Make fields not required
                    document.getElementById('student_id').required = false;
                    document.getElementById('graduation_year').required = false;
                    document.getElementById('program').required = false;
                }
            });

            // Trigger change event on page load
            document.getElementById('role').dispatchEvent(new Event('change'));
        </script>
    @endpush
</x-app-layout>
