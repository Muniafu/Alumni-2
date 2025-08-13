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
                                    <div>
                                        <p class="text-sm text-gray-500">Email</p>
                                        <p class="font-medium">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div>
                            <h4 class="font-medium text-gray-900 mb-4">Quick Actions</h4>
                            <div class="space-y-4">
                                @can('view events')
                                <a href="{{ route('events.index') }}" class="block p-4 bg-white border border-gray-200 rounded-lg shadow hover:border-blue-500 transition-colors">
                                    <h5 class="font-medium text-gray-900">View Upcoming Events</h5>
                                    <p class="text-sm text-gray-500 mt-1">See alumni and career events</p>
                                </a>
                                @endcan

                                <a href="{{ route('jobs.index') }}" class="block p-4 bg-white border border-gray-200 rounded-lg shadow hover:border-blue-500 transition-colors">
                                    <h5 class="font-medium text-gray-900">Browse Job Opportunities</h5>
                                    <p class="text-sm text-gray-500 mt-1">Find jobs and internships</p>
                                </a>

                                <a href="{{ route('student.profile') }}" class="block p-4 bg-white border border-gray-200 rounded-lg shadow hover:border-blue-500 transition-colors">
                                    <h5 class="font-medium text-gray-900">Update Profile</h5>
                                    <p class="text-sm text-gray-500 mt-1">Keep your information current</p>
                                </a>

                                @can('access forum')
                                <a href="{{ route('forum.index') }}" class="block p-4 bg-white border border-gray-200 rounded-lg shadow hover:border-blue-500 transition-colors">
                                    <h5 class="font-medium text-gray-900">Visit Discussion Forum</h5>
                                    <p class="text-sm text-gray-500 mt-1">Connect with peers and alumni</p>
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <!-- Additional Dashboard Sections -->
                    <div class="mt-8">
                        <!-- Upcoming Events Section -->
                        @can('view events')
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Events</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @forelse($upcomingEvents as $event)
                                <div class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:border-blue-500 transition-colors">
                                    <h4 class="font-medium text-gray-900">{{ $event->title }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $event->start_date->format('M j, Y g:i A') }}
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                                        {{ $event->description }}
                                    </p>
                                    <a href="{{ route('events.show', $event) }}" class="inline-block mt-3 text-sm text-blue-600 hover:text-blue-800">
                                        View Details
                                    </a>
                                </div>
                                @empty
                                <p class="text-gray-500">No upcoming events scheduled</p>
                                @endforelse
                            </div>
                            @if($upcomingEvents->count() > 0)
                            <div class="mt-4 text-right">
                                <a href="{{ route('events.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View All Events →
                                </a>
                            </div>
                            @endif
                        </div>
                        @endcan

                        <!-- Recent Job Postings -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Job Postings</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @forelse($recentJobs as $job)
                                <div class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:border-blue-500 transition-colors">
                                    <h4 class="font-medium text-gray-900">{{ $job->title }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">{{ $job->company }}</p>
                                    <div class="mt-2 flex items-center text-sm text-gray-600">
                                        <span class="mr-2">{{ $job->location }}</span>
                                        •
                                        <span class="ml-2">{{ $job->employment_type }}</span>
                                    </div>
                                    <a href="{{ route('jobs.show', $job) }}" class="inline-block mt-3 text-sm text-blue-600 hover:text-blue-800">
                                        View Details
                                    </a>
                                </div>
                                @empty
                                <p class="text-gray-500">No recent job postings available</p>
                                @endforelse
                            </div>
                            @if($recentJobs->count() > 0)
                            <div class="mt-4 text-right">
                                <a href="{{ route('jobs.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View All Jobs →
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
