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
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Total Users Card -->
                        <div class="bg-blue-50 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-blue-800 mb-2">Total Users</h3>
                            <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p>
                        </div>

                        <!-- Pending Approvals Card -->
                        <div class="bg-yellow-50 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-yellow-800 mb-2">Pending Approvals</h3>
                            <p class="text-3xl font-bold text-yellow-600">{{ $pendingApprovals }}</p>
                            @if($pendingApprovals > 0)
                                <a href="{{ route('admin.pending-approvals') }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium mt-2 inline-block">
                                    View Pending Approvals
                                </a>
                            @endif
                        </div>

                        <!-- Recent Activity Card -->
                        <div class="bg-green-50 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-green-800 mb-2">Recent Activity</h3>
                            <div class="space-y-2">
                                @forelse($recentActivities as $activity)
                                    <div class="text-sm text-green-700">
                                        <p>{{ $activity->description }}</p>
                                        <p class="text-xs text-green-500">{{ $activity->created_at->diffForHumans() }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-green-700">No recent activity</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <a href="{{ route('admin.user-management') }}" class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:border-blue-500 transition-colors">
                                <h4 class="font-medium text-gray-900">User Management</h4>
                                <p class="text-sm text-gray-500 mt-1">Manage all users in the system</p>
                            </a>
                            <a href="{{ route('admin.pending-approvals') }}" class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:border-blue-500 transition-colors">
                                <h4 class="font-medium text-gray-900">Pending Approvals</h4>
                                <p class="text-sm text-gray-500 mt-1">Approve or reject new registrations</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
