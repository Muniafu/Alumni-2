@extends('layouts.app')

@section('header')
    <h2 class="fw-semibold fs-4 text-dark">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Stats Cards -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-4">
        <!-- Users -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body bg-light border-start border-4 border-primary">
                    <h5 class="card-title text-primary mb-2">
                        <i class="bi bi-people-fill me-2"></i> Users
                    </h5>
                    <h2 class="fw-bold text-primary">{{ $userCounts['total'] }}</h2>
                    <p class="small text-secondary mb-1">
                        Admins: {{ $userCounts['admins'] }} | Alumni: {{ $userCounts['alumni'] }} | Students: {{ $userCounts['students'] }}
                    </p>
                    @if($userCounts['pending_approvals'] > 0)
                        <a href="{{ route('admin.pending-approvals') }}" class="text-decoration-none small text-primary fw-semibold">
                            <i class="bi bi-hourglass-split me-1"></i> {{ $userCounts['pending_approvals'] }} Pending Approvals
                        </a>
                    @endif
                    <p class="small text-success mt-2">+{{ $userCounts['new_last_week'] }} new last week</p>
                </div>
            </div>
        </div>

        <!-- Events -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body bg-light border-start border-4 border-success">
                    <h5 class="card-title text-success mb-2">
                        <i class="bi bi-calendar-event-fill me-2"></i> Events
                    </h5>
                    <h2 class="fw-bold text-success">{{ $eventStats['total'] }}</h2>
                    <p class="small text-secondary">Upcoming: {{ $eventStats['upcoming'] }} | Past: {{ $eventStats['past'] }}</p>
                    <p class="small text-muted">
                        <i class="bi bi-people-fill me-1"></i> {{ $eventStats['rsvps'] }} RSVPs (Avg: {{ number_format($eventStats['avg_attendance'], 1) }})
                    </p>
                </div>
            </div>
        </div>

        <!-- Jobs -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body bg-light border-start border-4 border-purple">
                    <h5 class="card-title text-purple mb-2">
                        <i class="bi bi-briefcase-fill me-2"></i> Job Postings
                    </h5>
                    <h2 class="fw-bold text-purple">{{ $jobStats['total'] }}</h2>
                    <p class="small text-secondary">Active: {{ $jobStats['active'] }}</p>
                    <p class="small text-muted">
                        <i class="bi bi-person-lines-fill me-1"></i> {{ $jobStats['applications'] }} applications (Avg: {{ number_format($jobStats['avg_applications'], 1) }})
                    </p>
                </div>
            </div>
        </div>

        <!-- Forum -->
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body bg-light border-start border-4 border-warning">
                    <h5 class="card-title text-warning mb-2">
                        <i class="bi bi-chat-left-dots-fill me-2"></i> Forum Activity
                    </h5>
                    <h2 class="fw-bold text-warning">{{ $forumStats['threads'] }}</h2>
                    <p class="small text-secondary">Threads: {{ $forumStats['threads'] }} | Posts: {{ $forumStats['posts'] }}</p>
                    <p class="small text-muted">{{ $forumStats['recent_posts'] }} posts in last week</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-dark mb-3">User Growth (Last 12 Months)</h5>
                    <canvas id="userGrowthChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-dark mb-3">Event Attendance</h5>
                    <canvas id="eventAttendanceChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-4">
        <h5 class="text-dark mb-3">Quick Actions</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <a href="{{ route('admin.user-management') }}" class="card shadow-sm border-0 text-decoration-none h-100">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark">User Management</h6>
                        <p class="small text-muted">Manage all users in the system</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.pending-approvals') }}" class="card shadow-sm border-0 text-decoration-none h-100">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark">Pending Approvals</h6>
                        <p class="small text-muted">Review new registration requests</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.reports.index') }}" class="card shadow-sm border-0 text-decoration-none h-100">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark">Generate Reports</h6>
                        <p class="small text-muted">Export system data</p>
                    </div>
                </a>
            </div>

            <!-- NEW Shortcuts -->
            <div class="col-md-4">
                <a href="{{ route('events.index') }}" class="card shadow-sm border-0 text-decoration-none h-100">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark">Manage Events</h6>
                        <p class="small text-muted">Create and oversee alumni events</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('jobs.index') }}" class="card shadow-sm border-0 text-decoration-none h-100">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark">Manage Jobs</h6>
                        <p class="small text-muted">Post and review job opportunities</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('forum.index') }}" class="card shadow-sm border-0 text-decoration-none h-100">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark">Forum Moderation</h6>
                        <p class="small text-muted">Moderate discussions and posts</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="card-title text-dark mb-3">Recent Activity</h5>
            @forelse($recentActivities as $activity)
                <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        @if(isset($activity->name))
                            {{ substr($activity->name, 0, 1) }}
                        @elseif(isset($activity->organizer))
                            {{ substr($activity->organizer->name, 0, 1) }}
                        @elseif(isset($activity->author))
                            {{ substr($activity->author->name, 0, 1) }}
                        @elseif(isset($activity->poster))
                            {{ substr($activity->poster->name, 0, 1) }}
                        @endif
                    </div>
                    <div class="flex-fill">
                        <p class="mb-1 fw-semibold text-dark">
                            @if($activity instanceof \App\Models\Event)
                                New Event: {{ $activity->title }}
                            @elseif($activity instanceof \App\Models\JobPosting)
                                New Job Posting: {{ $activity->title }}
                            @elseif($activity instanceof \App\Models\ForumThread)
                                New Forum Thread: {{ $activity->title }}
                            @elseif($activity instanceof \App\Models\User)
                                New User Registration: {{ $activity->name }}
                            @elseif(isset($activity->action) && $activity->action === 'approved')
                                User Approved: {{ $activity->user->name }}
                            @elseif(isset($activity->action) && $activity->action === 'rejected')
                                User Rejected: {{ $activity->user->name }}
                            @elseif(isset($activity->action) && $activity->action === 'profile_updated')
                                Profile Updated: {{ $activity->user->name }}
                            @endif
                        </p>
                        <p class="small text-muted mb-0">
                            @if($activity instanceof \App\Models\Event)
                                Organized by {{ $activity->organizer->name }}
                            @elseif($activity instanceof \App\Models\JobPosting)
                                Posted by {{ $activity->poster->name }}
                            @elseif($activity instanceof \App\Models\ForumThread)
                                Started by {{ $activity->author->name }}
                            @elseif($activity instanceof \App\Models\User)
                                Registered on {{ $activity->created_at->format('M d, Y') }}
                            @elseif(isset($activity->action))
                                By Admin: {{ $activity->admin->name ?? 'System' }}
                            @endif
                        </p>
                    </div>
                    <div class="text-end">
                        <p class="small text-muted mb-1">{{ $activity->created_at->diffForHumans() }}</p>
                        @if($activity instanceof \App\Models\Event)
                            <a href="{{ route('events.show', $activity) }}" class="small text-primary text-decoration-none">View</a>
                        @elseif($activity instanceof \App\Models\JobPosting)
                            <a href="{{ route('jobs.show', $activity) }}" class="small text-primary text-decoration-none">View</a>
                        @elseif($activity instanceof \App\Models\ForumThread)
                            <a href="{{ route('forum.threads.show', $activity) }}" class="small text-primary text-decoration-none">View</a>
                        @elseif($activity instanceof \App\Models\User)
                            <a href="{{ route('admin.user-show', $activity) }}" class="small text-primary text-decoration-none">View</a>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-muted">No recent activity to display</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // same chart.js config
</script>
@endpush
