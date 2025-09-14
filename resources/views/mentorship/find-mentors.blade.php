@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-semibold text-primary mb-0">
        <i class="fa-solid fa-user-tie me-2"></i> Find Mentors
    </h2>
</div>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h4 class="mb-1">Available Mentors</h4>
                    <p class="mb-0 text-secondary">Browse alumni who are available for mentorship</p>
                </div>

                <div class="card-body">
                    @if($mentors->isEmpty())
                        <div class="alert alert-info mb-0">
                            <i class="fa-solid fa-info-circle me-2"></i>No mentors available at this time.
                        </div>
                    @else
                        <div class="row">
                            @foreach($mentors as $mentor)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow-sm hover-shadow border-0">
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="{{ $mentor->profile->avatar_url ?? asset('images/default-avatar.png') }}"
                                                     alt="{{ $mentor->name }}"
                                                     class="rounded-circle me-3" width="60" height="60">
                                                <div>
                                                    <h5 class="mb-0">{{ $mentor->name }}</h5>
                                                    <p class="text-secondary mb-0">
                                                        {{ $mentor->profile->current_job ?? 'Alumni' }}
                                                    </p>
                                                </div>
                                            </div>

                                            @if($mentor->profile->skills && count($mentor->profile->skills) > 0)
                                                <div class="mb-3">
                                                    <h6 class="fw-medium">Skills:</h6>
                                                    <div class="d-flex flex-wrap">
                                                        @foreach(array_slice($mentor->profile->skills, 0, 5) as $skill)
                                                            <span class="badge bg-success text-light me-1 mb-1">{{ $skill }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            <a href="{{ route('mentorship.show-mentor', $mentor) }}"
                                               class="btn btn-primary mt-auto">
                                                <i class="fa-solid fa-arrow-right me-1"></i> View Profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $mentors->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
        transition: box-shadow 0.3s ease;
    }
</style>
@endsection
