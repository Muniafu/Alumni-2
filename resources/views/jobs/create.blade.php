@extends('layouts.app')

@section('header')
<div class="d-flex align-items-center justify-content-between">
    <h2 class="fw-semibold text-primary mb-0">
        <i class="fa-solid fa-briefcase me-2"></i> Create Job Posting
    </h2>
</div>
@endsection

@section('content')
<div class="row py-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <!-- Error Display -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('jobs.store') }}">
                    @csrf

                    <div class="row g-3">
                        <!-- Job Title -->
                        <div class="col-12">
                            <label for="title" class="form-label fw-medium">Job Title *</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required autofocus>
                        </div>

                        <!-- Job Type -->
                        <div class="col-md-6">
                            <label for="type" class="form-label fw-medium">Job Type *</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="job" {{ old('type') == 'job' ? 'selected' : '' }}>Job</option>
                                <option value="internship" {{ old('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                                <option value="mentorship" {{ old('type') == 'mentorship' ? 'selected' : '' }}>Mentorship</option>
                            </select>
                        </div>

                        <!-- Company -->
                        <div class="col-md-6">
                            <label for="company" class="form-label fw-medium">Company *</label>
                            <input type="text" class="form-control" id="company" name="company" value="{{ old('company') }}" required>
                        </div>

                        <!-- Location -->
                        <div class="col-md-6">
                            <label for="location" class="form-label fw-medium">Location *</label>
                            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
                        </div>

                        <!-- Remote Work -->
                        <div class="col-md-6 d-flex align-items-center mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_remote" name="is_remote" {{ old('is_remote') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_remote">
                                    Remote position
                                </label>
                            </div>
                        </div>

                        <!-- Employment Type -->
                        <div class="col-md-6">
                            <label for="employment_type" class="form-label fw-medium">Employment Type</label>
                            <input type="text" class="form-control" id="employment_type" name="employment_type" value="{{ old('employment_type') }}" placeholder="Full-time, Part-time, Contract">
                        </div>

                        <!-- Salary Range -->
                        <div class="col-md-6">
                            <label for="salary_range" class="form-label fw-medium">Salary Range</label>
                            <input type="text" class="form-control" id="salary_range" name="salary_range" value="{{ old('salary_range') }}" placeholder="e.g. $50,000 - $70,000">
                        </div>

                        <!-- Application Deadline -->
                        <div class="col-md-6">
                            <label for="application_deadline" class="form-label fw-medium">Application Deadline</label>
                            <input type="date" class="form-control" id="application_deadline" name="application_deadline" value="{{ old('application_deadline') }}">
                        </div>

                        <!-- Contact Email -->
                        <div class="col-md-6">
                            <label for="contact_email" class="form-label fw-medium">Contact Email *</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ old('contact_email') }}" required>
                        </div>

                        <!-- Contact Phone -->
                        <div class="col-md-6">
                            <label for="contact_phone" class="form-label fw-medium">Contact Phone</label>
                            <input type="tel" class="form-control" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}">
                        </div>

                        <!-- Website -->
                        <div class="col-md-6">
                            <label for="website" class="form-label fw-medium">Website</label>
                            <input type="url" class="form-control" id="website" name="website" value="{{ old('website') }}" placeholder="https://">
                        </div>

                        <!-- Required Skills -->
                        <div class="col-md-6">
                            <label for="skills_required" class="form-label fw-medium">Required Skills</label>
                            <input type="text" class="form-control" id="skills_required" name="skills_required" value="{{ old('skills_required') }}" placeholder="PHP, Laravel, MySQL">
                        </div>

                        <!-- Preferred Skills -->
                        <div class="col-md-6">
                            <label for="skills_preferred" class="form-label fw-medium">Preferred Skills</label>
                            <input type="text" class="form-control" id="skills_preferred" name="skills_preferred" value="{{ old('skills_preferred') }}" placeholder="Vue.js, AWS, Docker">
                        </div>

                        <!-- Job Description -->
                        <div class="col-12">
                            <label for="description" class="form-label fw-medium">Job Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-paper-plane me-1"></i> Post Job
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
