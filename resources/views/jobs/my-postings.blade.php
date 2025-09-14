@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-semibold text-primary mb-0">{{ __('Your Job Postings') }}</h2>
    <a href="{{ route('jobs.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i> Post a New Job
    </a>
</div>
@endsection

@section('content')
<div class="row py-4">
    <div class="col-12">
        @if($jobs->isEmpty())
        <div class="text-center py-5">
            <i class="fa-solid fa-briefcase fa-3x text-muted mb-3"></i>
            <p class="text-muted mb-3">You haven't posted any jobs yet.</p>
            <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                Post a New Job
            </a>
        </div>
        @else
        <div class="row g-4">
            @foreach($jobs as $job)
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between flex-wrap align-items-start">
                        <div class="me-3 flex-grow-1">
                            <h5 class="card-title mb-1">
                                <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none text-dark fw-bold">
                                    {{ $job->title }}
                                </a>
                            </h5>
                            <p class="text-muted mb-2">{{ $job->company }} • {{ $job->location }}</p>

                            <div class="d-flex flex-wrap gap-2 text-muted small">
                                @if($job->employment_type)
                                <span class="badge bg-info text-dark">{{ $job->employment_type }}</span>
                                @endif
                                <span class="badge bg-secondary">{{ $job->applications_count }} applications</span>
                                <span class="badge bg-light text-dark">{{ $job->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="text-end mt-2 mt-md-0">
                            <span class="badge rounded-pill {{ $job->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $job->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $jobs->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection
