@extends('layouts.app')

@section('header')
    <div class="bg-light border-bottom py-3 mb-4">
        <div class="container">
            <h2 class="fw-bold text-dark mb-0">{{ __('Profile') }}</h2>
            <small class="text-muted">Manage your personal details, security, and account settings</small>
        </div>
    </div>
@endsection

@section('content')
    <div class="container my-5">

        {{-- Progress / Stepper --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-center flex-fill">
                    <div class="rounded-circle bg-primary text-white fw-bold mx-auto mb-2 d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                        1
                    </div>
                    <small class="fw-semibold text-primary">Profile Info</small>
                </div>
                <div class="flex-fill border-top border-2 mx-2" style="border-color:#0d6efd !important;"></div>
                <div class="text-center flex-fill">
                    <div class="rounded-circle bg-warning text-dark fw-bold mx-auto mb-2 d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                        2
                    </div>
                    <small class="fw-semibold text-warning">Security</small>
                </div>
                <div class="flex-fill border-top border-2 mx-2" style="border-color:#ffc107 !important;"></div>
                <div class="text-center flex-fill">
                    <div class="rounded-circle bg-danger text-white fw-bold mx-auto mb-2 d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                        3
                    </div>
                    <small class="fw-semibold text-danger">Danger Zone</small>
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- Profile Information --}}
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Profile Information</h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form', [
                            'education' => old('education', $user->profile->education ?? ''),
                            'certifications' => old('certifications', implode(', ', $user->profile->certifications_array ?? []))
                        ])
                    </div>
                </div>
            </div>

            {{-- Update Password --}}
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Update Password</h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Delete Account</h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
