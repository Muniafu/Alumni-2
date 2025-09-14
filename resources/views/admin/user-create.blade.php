@extends('layouts.app')

@section('header')
<h2 class="fw-semibold fs-4 text-dark">
    <i class="bi bi-person-plus-fill text-primary me-2"></i> {{ __('Create New User') }}
</h2>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.user.store') }}">
                @csrf

                <div class="row g-4">
                    {{-- Basic Information --}}
                    <div class="col-md-6">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="bi bi-person-circle me-2"></i> Basic Information
                        </h5>

                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror" required autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input id="password" type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required autocomplete="new-password">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   class="form-control @error('password_confirmation') is-invalid @enderror" required>
                            @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Role --}}
                        <div class="mb-3">
                            <label for="role" class="form-label fw-semibold">Role</label>
                            <select id="role" name="role"
                                    class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Student/Alumni Information --}}
                    <div class="col-md-6" id="studentFields">
                        <h5 class="fw-bold text-success mb-3">
                            <i class="bi bi-mortarboard-fill me-2"></i> Student/Alumni Information
                        </h5>

                        {{-- Student ID --}}
                        <div class="mb-3">
                            <label for="student_id" class="form-label fw-semibold">Student ID</label>
                            <input id="student_id" type="text" name="student_id" value="{{ old('student_id') }}"
                                   class="form-control @error('student_id') is-invalid @enderror">
                            @error('student_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Graduation Year --}}
                        <div class="mb-3">
                            <label for="graduation_year" class="form-label fw-semibold">Graduation Year</label>
                            <select id="graduation_year" name="graduation_year"
                                    class="form-select @error('graduation_year') is-invalid @enderror">
                                <option value="">Select Graduation Year</option>
                                @foreach($graduationYears as $year)
                                    <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            @error('graduation_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Program --}}
                        <div class="mb-3">
                            <label for="program" class="form-label fw-semibold">Program</label>
                            <input id="program" type="text" name="program" value="{{ old('program') }}"
                                   class="form-control @error('program') is-invalid @enderror">
                            @error('program') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.user-management') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-arrow-left me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Show/hide student fields based on role selection
    document.getElementById('role').addEventListener('change', function() {
        const studentFields = document.getElementById('studentFields');
        if (this.value === 'student' || this.value === 'alumni') {
            studentFields.style.display = 'block';
            studentFields.querySelectorAll('input, select').forEach(el => el.required = true);
        } else {
            studentFields.style.display = 'none';
            studentFields.querySelectorAll('input, select').forEach(el => el.required = false);
        }
    });
    // Trigger on page load
    document.getElementById('role').dispatchEvent(new Event('change'));
</script>
@endpush
