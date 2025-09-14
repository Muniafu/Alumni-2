@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-semibold text-primary mb-0">
        <i class="fa-solid fa-envelope me-2"></i> Mentorship Requests
    </h2>
</div>
@endsection

@section('content')
<div class="container py-4">
    <!-- Received Requests -->
    <div class="mb-5">
        <h3 class="fw-bold mb-3">Received Requests</h3>

        @if($receivedRequests->isNotEmpty())
            <div class="row g-4">
                @foreach($receivedRequests as $request)
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="mb-1">{{ $request->mentee->name }}</h5>
                                        <p class="text-secondary mb-0">{{ $request->mentee->program }} • Student</p>
                                    </div>
                                    <span class="badge
                                        @if($request->status === 'pending') bg-warning text-dark
                                        @elseif($request->status === 'accepted') bg-success text-light
                                        @else bg-danger text-light @endif">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>

                                <div class="mb-2">
                                    <h6 class="fw-medium mb-1">Goal:</h6>
                                    <p class="mb-0">{{ $request->goal }}</p>
                                </div>

                                <div class="mb-2">
                                    <h6 class="fw-medium mb-1">Message:</h6>
                                    <p class="mb-0">{{ $request->message }}</p>
                                </div>

                                @if($request->status === 'pending')
                                    <div class="mt-3 d-flex gap-2 flex-wrap">
                                        <form action="{{ route('mentorship.requests.accept', $request) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                Accept
                                            </button>
                                        </form>
                                        <form action="{{ route('mentorship.requests.reject', $request) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                Decline
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $receivedRequests->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="fa-solid fa-info-circle me-2"></i>You have no received mentorship requests.
            </div>
        @endif
    </div>

    <!-- Sent Requests -->
    <div>
        <h3 class="fw-bold mb-3">Sent Requests</h3>

        @if($sentRequests->isNotEmpty())
            <div class="row g-4">
                @foreach($sentRequests as $request)
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="mb-1">{{ $request->mentor->name }}</h5>
                                        <p class="text-secondary mb-0">{{ $request->mentor->profile->current_job ?? 'Alumni' }} • Alumni</p>
                                    </div>
                                    <span class="badge
                                        @if($request->status === 'pending') bg-warning text-dark
                                        @elseif($request->status === 'accepted') bg-success text-light
                                        @else bg-danger text-light @endif">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>

                                <div class="mb-2">
                                    <h6 class="fw-medium mb-1">Goal:</h6>
                                    <p class="mb-0">{{ $request->goal }}</p>
                                </div>

                                <div class="mb-2">
                                    <h6 class="fw-medium mb-1">Message:</h6>
                                    <p class="mb-0">{{ $request->message }}</p>
                                </div>

                                @if($request->status === 'accepted')
                                    <div class="mt-2">
                                        <a href="{{ route('mentorship.show', $request->mentorship) }}" class="btn btn-outline-primary btn-sm">
                                            View Mentorship Details
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $sentRequests->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="fa-solid fa-info-circle me-2"></i>You haven't sent any mentorship requests.
            </div>
        @endif
    </div>
</div>

<style>
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        transition: box-shadow 0.3s ease;
    }
</style>
@endsection
