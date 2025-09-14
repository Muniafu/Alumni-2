@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Header with Profile Completion --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">My Profile</h2>

        <div class="text-end">
            <span class="small fw-medium">Profile Completion: </span>
            <span class="fw-bold
                {{ $user->profile->profile_completion >= 80 ? 'text-success' :
                   ($user->profile->profile_completion >= 50 ? 'text-warning' : 'text-danger') }}">
                {{ $user->profile->profile_completion }}%
            </span>
            <div class="progress mt-1" style="height: 8px;">
                <div class="progress-bar bg-primary" role="progressbar"
                     style="width: {{ $user->profile->profile_completion }}%"
                     aria-valuenow="{{ $user->profile->profile_completion }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
        </div>
    </div>

    {{-- Completion Alert --}}
    @if($user->profile->profile_completion < 80)
    <div class="alert alert-warning d-flex align-items-start">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <div>
            <p class="mb-0 small">
                Complete your profile to increase your visibility in the alumni network.
                @if($user->profile->profile_completion < 50)
                    You're missing several important details.
                @else
                    You're almost there! Just a few more details needed.
                @endif
            </p>
        </div>
    </div>
    @endif

    {{-- Profile Form --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('alumni.profile.update') }}">
                @csrf

                <div class="row g-4">
                    {{-- Basic Information --}}
                    <div class="col-md-6">
                        <h5 class="fw-semibold text-dark mb-3">Basic Information</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input id="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name', $user->name) }}" required autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student ID</label>
                            <input id="student_id" type="text" class="form-control"
                                   value="{{ old('student_id', $user->student_id) }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="graduation_year" class="form-label">Graduation Year</label>
                            <input id="graduation_year" type="text" class="form-control"
                                   value="{{ old('graduation_year', $user->graduation_year) }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="program" class="form-label">Program</label>
                            <input id="program" type="text" class="form-control"
                                   value="{{ old('program', $user->program) }}" readonly>
                        </div>
                    </div>

                    {{-- Contact Information --}}
                    <div class="col-md-6">
                        <h5 class="fw-semibold text-dark mb-3">Contact Information</h5>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input id="phone" type="text"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   name="phone" value="{{ old('phone', $user->profile->phone) }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input id="address" type="text"
                                   class="form-control @error('address') is-invalid @enderror"
                                   name="address" value="{{ old('address', $user->profile->address) }}">
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="current_job" class="form-label">Current Job Title</label>
                            <input id="current_job" type="text"
                                   class="form-control @error('current_job') is-invalid @enderror"
                                   name="current_job" value="{{ old('current_job', $user->profile->current_job) }}">
                            @error('current_job') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="company" class="form-label">Current Company</label>
                            <input id="company" type="text"
                                   class="form-control @error('company') is-invalid @enderror"
                                   name="company" value="{{ old('company', $user->profile->company) }}">
                            @error('company') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Professional Details --}}
                    <div class="col-12">
                        <h5 class="fw-semibold text-dark mb-3">Professional Details</h5>

                        <div class="mb-3">
                            <label for="skills" class="form-label">Skills (comma separated)</label>
                            <input id="skills" type="text"
                                   class="form-control @error('skills') is-invalid @enderror"
                                   name="skills"
                                   value="{{ old('skills', implode(', ', $user->profile->skills ?? [])) }}"
                                   placeholder="e.g., PHP, JavaScript, Project Management">
                            @error('skills') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="interests" class="form-label">Professional Interests</label>
                            <input id="interests" type="text"
                                   class="form-control @error('interests') is-invalid @enderror"
                                   name="interests"
                                   value="{{ old('interests', implode(', ', $user->profile->interests ?? [])) }}"
                                   placeholder="e.g., Web Development, Data Science, Mentoring">
                            @error('interests') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Professional Bio</label>
                            <textarea id="bio" name="bio" rows="4"
                                      class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $user->profile->bio) }}</textarea>
                            @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Social Links --}}
                    <div class="col-12">
                        <h5 class="fw-semibold text-dark mb-3">Social Links</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input id="linkedin" type="url"
                                       class="form-control @error('linkedin') is-invalid @enderror"
                                       name="linkedin" value="{{ old('linkedin', $user->profile->getSocialLink('linkedin')) }}"
                                       placeholder="https://linkedin.com/in/username">
                                @error('linkedin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input id="twitter" type="url"
                                       class="form-control @error('twitter') is-invalid @enderror"
                                       name="twitter" value="{{ old('twitter', $user->profile->getSocialLink('twitter')) }}"
                                       placeholder="https://twitter.com/username">
                                @error('twitter') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="github" class="form-label">GitHub</label>
                                <input id="github" type="url"
                                       class="form-control @error('github') is-invalid @enderror"
                                       name="github" value="{{ old('github', $user->profile->getSocialLink('github')) }}"
                                       placeholder="https://github.com/username">
                                @error('github') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="website" class="form-label">Personal Website</label>
                                <input id="website" type="url"
                                       class="form-control @error('website') is-invalid @enderror"
                                       name="website" value="{{ old('website', $user->profile->getSocialLink('website')) }}"
                                       placeholder="https://yourwebsite.com">
                                @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
