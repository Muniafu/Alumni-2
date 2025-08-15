<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alumni Dashboard') }}
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
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Welcome back, {{ $user->name }}!</h3>

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
                                        <p class="text-sm text-gray-500">Current Job</p>
                                        <p class="font-medium">{{ $profile->current_job ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Company</p>
                                        <p class="font-medium">{{ $profile->current_company ?? 'Not provided' }}</p>
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
                                @can('create jobs')
                                <a href="{{ route('jobs.create') }}" class="block p-4 bg-white border border-gray-200 rounded-lg shadow hover:border-blue-500 transition-colors">
                                    <h5 class="font-medium text-gray-900">Post a Job Opportunity</h5>
                                    <p class="text-sm text-gray-500 mt-1">Share job openings with students</p>
                                </a>
                                @endcan

                                @can('view events')
                                <a href="{{ route('events.index') }}" class="block p-4 bg-white border border-gray-200 rounded-lg shadow hover:border-blue-500 transition-colors">
                                    <h5 class="font-medium text-gray-900">View Upcoming Events</h5>
                                    <p class="text-sm text-gray-500 mt-1">See and RSVP to alumni events</p>
                                </a>
                                @endcan

                                <a href="{{ route('alumni.profile') }}" class="block p-4 bg-white border border-gray-200 rounded-lg shadow hover:border-blue-500 transition-colors">
                                    <h5 class="font-medium text-gray-900">Update Profile</h5>
                                    <p class="text-sm text-gray-500 mt-1">Keep your information current</p>
                                </a>

                                @can('mentor students')
                                <a href="{{ route('mentorship.index') }}" class="block p-4 bg-white border border-gray-200 rounded-lg shadow hover:border-blue-500 transition-colors">
                                    <h5 class="font-medium text-gray-900">Mentorship Program</h5>
                                    <p class="text-sm text-gray-500 mt-1">Guide current students</p>
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <!-- Additional Alumni Sections -->
                    <div class="mt-8">
                        <!-- Mentorship Opportunities -->
                        @can('mentor students')
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Mentorship Opportunities</h3>
                            <div class="bg-blue-50 p-6 rounded-lg">
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                                    <div class="mb-4 md:mb-0">
                                        <h4 class="font-medium text-gray-900">Become a Mentor</h4>
                                        <p class="text-sm text-gray-600 mt-1">Share your experience with current students</p>
                                    </div>
                                    <a href="{{ route('mentorship.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                        Sign Up as Mentor
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Your Recent Job Postings -->
                        @can('create jobs')
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Your Recent Job Postings</h3>
                            @if($userJobPostings->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($userJobPostings as $job)
                                <div class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:border-blue-500 transition-colors">
                                    <h4 class="font-medium text-gray-900">{{ $job->title }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">{{ $job->company }}</p>
                                    <div class="mt-2 flex items-center text-sm text-gray-600">
                                        <span class="mr-2">{{ $job->location }}</span>
                                        •
                                        <span class="ml-2">{{ $job->employment_type }}</span>
                                    </div>
                                    <div class="mt-2 text-sm">
                                        <span class="text-gray-600">{{ $job->applications_count }} applications</span>
                                    </div>
                                    <a href="{{ route('jobs.show', $job) }}" class="inline-block mt-3 text-sm text-blue-600 hover:text-blue-800">
                                        View Details
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('jobs.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View All Your Postings →
                                </a>
                            </div>
                            @else
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                <p class="text-yellow-800">You haven't posted any jobs yet. Share opportunities with students!</p>
                                <a href="{{ route('jobs.create') }}" class="inline-block mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Post Your First Job
                                </a>
                            </div>
                            @endif
                        </div>
                        @endcan

                        <!-- Upcoming Alumni Events -->
                        @can('view events')
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Alumni Events</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @forelse($upcomingAlumniEvents as $event)
                                <div class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:border-blue-500 transition-colors">
                                    <h4 class="font-medium text-gray-900">{{ $event->title }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $event->start_date->format('M j, Y g:i A') }}
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                                        {{ $event->description }}
                                    </p>
                                    <div class="mt-3 flex justify-between items-center">
                                        <span class="text-sm {{ $event->is_registered ? 'text-green-600' : 'text-gray-600' }}">
                                            {{ $event->is_registered ? 'Registered' : 'Not registered' }}
                                        </span>
                                        <a href="{{ route('events.show', $event) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                            {{ $event->is_registered ? 'View Details' : 'Register Now' }}
                                        </a>
                                    </div>
                                </div>
                                @empty
                                <p class="text-gray-500">No upcoming alumni events scheduled</p>
                                @endforelse
                            </div>
                            @if($upcomingAlumniEvents->count() > 0)
                            <div class="mt-4 text-right">
                                <a href="{{ route('events.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View All Events →
                                </a>
                            </div>
                            @endif
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
