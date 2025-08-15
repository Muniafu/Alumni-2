<x-layout>
    <x-slot name="title">Find Mentors</x-slot>

    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Available Mentors</h4>
                        <p class="mb-0">Browse alumni who are available for mentorship</p>
                    </div>

                    <div class="card-body">
                        @if($mentors->isEmpty())
                            <div class="alert alert-info">No mentors available at this time.</div>
                        @else
                            <div class="row">
                                @foreach($mentors as $mentor)
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar avatar-lg mr-3">
                                                        <img src="{{ $mentor->profile->avatar_url ?? asset('images/default-avatar.png') }}"
                                                             alt="{{ $mentor->name }}" class="avatar-img rounded-circle">
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-0">{{ $mentor->name }}</h5>
                                                        <p class="text-muted mb-0">
                                                            {{ $mentor->profile->current_job ?? 'Alumni' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                @if($mentor->profile->skills && count($mentor->profile->skills) > 0)
                                                    <div class="mb-3">
                                                        <h6>Skills:</h6>
                                                        <div class="d-flex flex-wrap">
                                                            @foreach(array_slice($mentor->profile->skills, 0, 5) as $skill)
                                                                <span class="badge badge-secondary mr-1 mb-1">{{ $skill }}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                <a href="{{ route('mentorship.show-mentor', $mentor) }}"
                                                   class="btn btn-primary btn-block">
                                                    View Profile
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{ $mentors->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
