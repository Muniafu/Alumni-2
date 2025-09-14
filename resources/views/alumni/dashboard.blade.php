@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="fw-bold text-primary">Alumni Dashboard</h2>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="row g-4">
        {{-- Profile Summary --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h4 class="fw-semibold text-dark mb-3">Welcome back, {{ $user->name }}!</h4>

                    <div class="row gy-3">
                        <div class="col-md-6">
                            <small class="text-muted">Student ID</small>
                            <p class="fw-medium">{{ $user->student_id ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Graduation Year</small>
                            <p class="fw-medium">{{ $user->graduation_year ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Program</small>
                            <p class="fw-medium">{{ $user->program ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Current Job</small>
                            <p class="fw-medium">{{ $profile->current_job ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Company</small>
                            <p class="fw-medium">{{ $profile->current_company ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Email</small>
                            <p class="fw-medium">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="fw-semibold text-dark mb-3">Quick Actions</h5>
                    <div class="list-group list-group-flush">

                        @can('create jobs')
                        <a href="{{ route('jobs.create') }}" class="list-group-item list-group-item-action">
                            <strong>Post a Job Opportunity</strong>
                            <p class="small text-muted mb-0">Share job openings with students</p>
                        </a>
                        @endcan

                        @can('view events')
                        <a href="{{ route('events.index') }}" class="list-group-item list-group-item-action">
                            <strong>View Upcoming Events</strong>
                            <p class="small text-muted mb-0">See and RSVP to alumni events</p>
                        </a>
                        @endcan

                        <a href="{{ route('alumni.profile') }}" class="list-group-item list-group-item-action">
                            <strong>Update Profile</strong>
                            <p class="small text-muted mb-0">Keep your information current</p>
                        </a>

                        @can('mentor students')
                        <a href="{{ route('mentorship.index') }}" class="list-group-item list-group-item-action">
                            <strong>Mentorship Program</strong>
                            <p class="small text-muted mb-0">Guide current students</p>
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Additional Alumni Sections --}}
    <div class="mt-5">

        {{-- Mentorship Opportunities --}}
        @can('mentor students')
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div>
                    <h5 class="fw-semibold text-dark">Mentorship Opportunities</h5>
                    <p class="small text-muted mb-2">Share your experience with current students</p>
                </div>
                <a href="{{ route('mentorship.create') }}" class="btn btn-primary">
                    Sign Up as Mentor
                </a>
            </div>
        </div>
        @endcan

        {{-- Job Postings --}}
        @can('create jobs')
        <div class="mb-4">
            <h5 class="fw-semibold mb-3">Your Recent Job Postings</h5>
            @if($userJobPostings->count() > 0)
                <div class="row g-3">
                    @foreach($userJobPostings as $job)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="fw-semibold">{{ $job->title }}</h6>
                                <p class="small text-muted mb-1">{{ $job->company }}</p>
                                <p class="small text-muted">{{ $job->location }} • {{ $job->employment_type }}</p>
                                <p class="small text-muted">{{ $job->applications_count }} applications</p>
                                <a href="{{ route('jobs.show', $job) }}" class="stretched-link text-decoration-none text-primary small">View Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-end mt-3">
                    <a href="{{ route('jobs.index') }}" class="btn btn-link text-primary fw-medium">View All Your Postings →</a>
                </div>
            @else
                <div class="alert alert-warning">
                    <p class="mb-1">You haven't posted any jobs yet. Share opportunities with students!</p>
                    <a href="{{ route('jobs.create') }}" class="fw-semibold text-primary">Post Your First Job</a>
                </div>
            @endif
        </div>
        @endcan

        {{-- Alumni Events --}}
        @can('view events')
        <div>
            <h5 class="fw-semibold mb-3">Upcoming Alumni Events</h5>
            @if($upcomingAlumniEvents->count() > 0)
                <div class="row g-3">
                    @foreach($upcomingAlumniEvents as $event)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="fw-semibold">{{ $event->title }}</h6>
                                <p class="small text-muted">{{ $event->start_date->format('M j, Y g:i A') }}</p>
                                <p class="small text-muted">{{ Str::limit($event->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="badge {{ $event->is_registered ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $event->is_registered ? 'Registered' : 'Not registered' }}
                                    </span>
                                    <a href="{{ route('events.show', $event) }}" class="small text-primary">
                                        {{ $event->is_registered ? 'View Details' : 'Register Now' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-end mt-3">
                    <a href="{{ route('events.index') }}" class="btn btn-link text-primary fw-medium">View All Events →</a>
                </div>
            @else
                <p class="text-muted">No upcoming alumni events scheduled</p>
            @endif
        </div>
        @endcan
    </div>
</div>
@endsection
