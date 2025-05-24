<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Profile Summary -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Welcome, {{ $user->name }}!</h3>

                            <div class="bg-gray-50 p-6 rounded-lg shadow">
                                <h4 class="font-medium text-gray-900 mb-2">Your Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Student ID</p>
                                        <p class="font-medium">{{ $user->student_id ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Graduation Year</p>
                                        <p class="font-medium">{{ $user->graduation_year ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Program</p>
                                        <p class="font-medium">{{ $user->program ?? 'Not provided' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div>
                            <h4 class="font-medium text-gray-900 mb-4">Quick Actions</h4>
                            <div class="space-y-4">
                                <a href="{{ route('student.profile') }}" class="block p-4 bg-white border border-gray-200 rounded-lg shadow hover:border-blue-500 transition-colors">
                                    <h5 class="font-medium text-gray-900">Update Profile</h5>
                                    <p class="text-sm text-gray-500 mt-1">Keep your information current</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
