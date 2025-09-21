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

                    <!-- Education & Certifications -->
                    <div class="col-12">
                        <h5 class="fw-semibold text-dark mb-3">Education & Certifications</h5>

                        <div class="mb-3">
                            <label for="education" class="form-label">Education (e.g., Degree, Institution)</label>
                            <input id="education" type="text"
                                   class="form-control @error('education') is-invalid @enderror"
                                   name="education" value="{{ old('education', $user->profile->education ?? '') }}">
                            @error('education') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="certifications" class="form-label">Certifications (comma separated)</label>
                            <input id="certifications" type="text"
                                   class="form-control @error('certifications') is-invalid @enderror"
                                   name="certifications"
                                   value="{{ old('certifications', implode(', ', $user->profile->certifications_array ?? [])) }}"
                                   placeholder="e.g., PMP, AWS Certified, Google Analytics">
                            @error('certifications') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                value="{{ old('skills', implode(', ', $user->profile->skills_array ?? [])) }}"
                                placeholder="e.g., PHP, JavaScript, Project Management">
                            @error('skills') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="interests" class="form-label">Professional Interests</label>
                            <input id="interests" type="text"
                                class="form-control @error('interests') is-invalid @enderror"
                                name="interests"
                                value="{{ old('interests', implode(', ', $user->profile->interests_array ?? [])) }}"
                                placeholder="e.g., Web Development, Data Science, Mentoring">
                            @error('interests') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Professional Bio</label>
                            <textarea id="bio" name="bio" rows="4"
                                    class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                            @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Social Links --}}
                    <div class="col-12">
                        <h5 class="fw-semibold text-dark mb-3">Social Links</h5>
                        <div class="row g-3">
                            @php
                                $socials = [
                                    'linkedin' => 'LinkedIn',
                                    'twitter' => 'Twitter',
                                    'github' => 'GitHub',
                                    'website' => 'Personal Website'
                                ];
                            @endphp

                            @foreach($socials as $key => $label)
                                <div class="col-md-6">
                                    <label for="{{ $key }}" class="form-label">{{ $label }}</label>
                                    <input id="{{ $key }}" type="url"
                                        class="form-control @error($key) is-invalid @enderror"
                                        name="{{ $key }}"
                                        value="{{ old($key, $user->profile->getSocialLink($key) ?? '') }}"
                                        placeholder="https://{{ strtolower($key) }}.com/username">
                                    @error($key) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            @endforeach
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
