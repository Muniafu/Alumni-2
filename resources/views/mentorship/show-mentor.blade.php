<x-layout>
    <x-slot name="title">{{ $mentor->name }} - Mentor Profile</x-slot>

    <div class="container py-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Mentor Profile</h4>
                            <a href="{{ route('mentorship.find-mentors') }}" class="btn btn-sm btn-outline-secondary">
                                Back to Mentors
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="{{ $mentor->profile->avatar_url ?? asset('images/default-avatar.png') }}"
                                 alt="{{ $mentor->name }}" class="rounded-circle" width="120">
                            <h3 class="mt-3">{{ $mentor->name }}</h3>
                            <p class="text-muted">
                                {{ $mentor->profile->current_job ?? 'Alumni' }} at {{ $mentor->profile->company ?? 'Unknown' }}
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5>Professional Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Current Position:</strong> {{ $mentor->profile->current_job ?? 'Not specified' }}</p>
                                        <p><strong>Company:</strong> {{ $mentor->profile->company ?? 'Not specified' }}</p>
                                        <p><strong>Graduation Year:</strong> {{ $mentor->graduation_year ?? 'Not specified' }}</p>
                                        <p><strong>Program:</strong> {{ $mentor->program ?? 'Not specified' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5>Skills & Expertise</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($mentor->profile->skills && count($mentor->profile->skills) > 0)
                                            <div class="d-flex flex-wrap">
                                                @foreach($mentor->profile->skills as $skill)
                                                    <span class="badge badge-primary mr-1 mb-1">{{ $skill }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">No skills specified</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($mentor->profile->bio)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5>About</h5>
                                </div>
                                <div class="card-body">
                                    <p>{{ $mentor->profile->bio }}</p>
                                </div>
                            </div>
                        @endif

                        @if(!$existingRequest)
                            <div class="card">
                                <div class="card-header">
                                    <h5>Request Mentorship</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('mentorship.send-request', $mentor) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="goal">What do you hope to achieve through this mentorship?</label>
                                            <textarea class="form-control" id="goal" name="goal" rows="3" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Message to Mentor</label>
                                            <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                                            <small class="form-text text-muted">
                                                Briefly introduce yourself and explain why you'd like this mentor's guidance.
                                            </small>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Send Request</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">
                                @if($existingRequest->status === 'pending')
                                    You have a pending mentorship request with this mentor.
                                @elseif($existingRequest->status === 'accepted')
                                    Your mentorship request has been accepted!
                                    <a href="{{ route('mentorship.show', $existingRequest->mentorship) }}">View Mentorship</a>
                                @else
                                    Your mentorship request was declined.
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
