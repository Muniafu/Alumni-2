<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Enhanced Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Users Card with Pending Approvals -->
                        <div class="bg-blue-50 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-blue-800 mb-2">Users</h3>
                            <p class="text-3xl font-bold text-blue-600">{{ $userCounts['total'] }}</p>
                            <div class="mt-2 text-sm text-blue-700">
                                <span class="inline-block mr-3">Admins: {{ $userCounts['admins'] }}</span>
                                <span class="inline-block mr-3">Alumni: {{ $userCounts['alumni'] }}</span>
                                <span class="inline-block">Students: {{ $userCounts['students'] }}</span>
                            </div>
                            <div class="mt-2">
                                @if($userCounts['pending_approvals'] > 0)
                                    <a href="{{ route('admin.pending-approvals') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        {{ $userCounts['pending_approvals'] }} Pending Approvals
                                    </a>
                                @endif
                                <p class="text-sm text-blue-600 mt-1">+{{ $userCounts['new_last_week'] }} new last week</p>
                            </div>
                        </div>

                        <!-- Events Card -->
                        <div class="bg-green-50 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-green-800 mb-2">Events</h3>
                            <p class="text-3xl font-bold text-green-600">{{ $eventStats['total'] }}</p>
                            <div class="mt-2 text-sm text-green-700">
                                <span class="inline-block mr-3">Upcoming: {{ $eventStats['upcoming'] }}</span>
                                <span class="inline-block">Past: {{ $eventStats['past'] }}</span>
                            </div>
                            <p class="text-sm text-green-600 mt-2">
                                {{ $eventStats['rsvps'] }} RSVPs (Avg: {{ number_format($eventStats['avg_attendance'], 1) }})
                            </p>
                        </div>

                        <!-- Jobs Card -->
                        <div class="bg-purple-50 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-purple-800 mb-2">Job Postings</h3>
                            <p class="text-3xl font-bold text-purple-600">{{ $jobStats['total'] }}</p>
                            <div class="mt-2 text-sm text-purple-700">
                                <span class="inline-block mr-3">Active: {{ $jobStats['active'] }}</span>
                            </div>
                            <p class="text-sm text-purple-600 mt-2">
                                {{ $jobStats['applications'] }} applications (Avg: {{ number_format($jobStats['avg_applications'], 1) }})
                            </p>
                        </div>

                        <!-- Forum Card -->
                        <div class="bg-yellow-50 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-yellow-800 mb-2">Forum Activity</h3>
                            <p class="text-3xl font-bold text-yellow-600">{{ $forumStats['threads'] }}</p>
                            <div class="mt-2 text-sm text-yellow-700">
                                <span class="inline-block mr-3">Threads: {{ $forumStats['threads'] }}</span>
                                <span class="inline-block">Posts: {{ $forumStats['posts'] }}</span>
                            </div>
                            <p class="text-sm text-yellow-600 mt-2">{{ $forumStats['recent_posts'] }} posts in last week</p>
                        </div>
                    </div>

                    <!-- Interactive Charts -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">User Growth (Last 12 Months)</h3>
                            <canvas id="userGrowthChart" height="250"></canvas>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Event Attendance</h3>
                            <canvas id="eventAttendanceChart" height="250"></canvas>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <a href="{{ route('admin.user-management') }}" class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:border-blue-500 transition-colors">
                                <h4 class="font-medium text-gray-900">User Management</h4>
                                <p class="text-sm text-gray-500 mt-1">Manage all users in the system</p>
                            </a>
                            <a href="{{ route('admin.pending-approvals') }}" class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:border-blue-500 transition-colors">
                                <h4 class="font-medium text-gray-900">Pending Approvals</h4>
                                <p class="text-sm text-gray-500 mt-1">Review new registration requests</p>
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:border-blue-500 transition-colors">
                                <h4 class="font-medium text-gray-900">Generate Reports</h4>
                                <p class="text-sm text-gray-500 mt-1">Export system data</p>
                            </a>
                        </div>
                    </div>

                    <!-- Permissions Management Section -->
                    @can('manage-permissions')
                    <div class="bg-white p-6 rounded-lg shadow border border-gray-200 mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Permissions Management</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <a href="{{ route('admin.permissions.index') }}" class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:border-blue-500 transition-colors">
                                <h4 class="font-medium text-gray-900">Permissions</h4>
                                <p class="text-sm text-gray-500 mt-1">Manage all permissions</p>
                            </a>
                            <a href="{{ route('admin.roles.index') }}" class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:border-blue-500 transition-colors">
                                <h4 class="font-medium text-gray-900">Roles</h4>
                                <p class="text-sm text-gray-500 mt-1">Manage user roles</p>
                            </a>
                            <a href="{{ route('admin.role-assignments.index') }}" class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:border-blue-500 transition-colors">
                                <h4 class="font-medium text-gray-900">Assign Roles</h4>
                                <p class="text-sm text-gray-500 mt-1">Assign roles to users</p>
                            </a>
                        </div>
                    </div>
                    @endcan

                    <!-- Recent Activity Stream -->
                    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                        <div class="space-y-4">
                            @forelse($recentActivities as $activity)
                            <div class="flex items-start space-x-4 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">
                                        @if(isset($activity->organizer))
                                            {{ substr($activity->organizer->name, 0, 1) }}
                                        @elseif(isset($activity->author))
                                            {{ substr($activity->author->name, 0, 1) }}
                                        @elseif(isset($activity->poster))
                                            {{ substr($activity->poster->name, 0, 1) }}
                                        @endif
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        @if($activity instanceof \App\Models\Event)
                                            New Event: {{ $activity->title }}
                                        @elseif($activity instanceof \App\Models\JobPosting)
                                            New Job Posting: {{ $activity->title }}
                                        @elseif($activity instanceof \App\Models\ForumThread)
                                            New Forum Thread: {{ $activity->title }}
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        @if($activity instanceof \App\Models\Event)
                                            Organized by {{ $activity->organizer->name }}
                                        @elseif($activity instanceof \App\Models\JobPosting)
                                            Posted by {{ $activity->poster->name }}
                                        @elseif($activity instanceof \App\Models\ForumThread)
                                            Started by {{ $activity->author->name }}
                                        @endif
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                                    <a href="@if($activity instanceof \App\Models\Event){{ route('events.show', $activity) }}@elseif($activity instanceof \App\Models\JobPosting){{ route('jobs.show', $activity) }}@elseif($activity instanceof \App\Models\ForumThread){{ route('forum.threads.show', $activity) }}@endif"
                                       class="text-sm text-blue-600 hover:text-blue-800">
                                        View
                                    </a>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500">No recent activity to display</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // User Growth Chart
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: @json($userGrowth->pluck('date')),
                datasets: [{
                    label: 'New Users',
                    data: @json($userGrowth->pluck('count')),
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // Event Attendance Chart
        const eventAttendanceCtx = document.getElementById('eventAttendanceChart').getContext('2d');
        new Chart(eventAttendanceCtx, {
            type: 'bar',
            data: {
                labels: @json($eventAttendance->pluck('name')),
                datasets: [{
                    label: 'Attendance',
                    data: @json($eventAttendance->pluck('attendance')),
                    backgroundColor: 'rgba(16, 185, 129, 0.6)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    </script>
    @endpush
</x-app-layout>
