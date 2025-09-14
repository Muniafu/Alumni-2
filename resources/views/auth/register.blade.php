<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Alumni System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(to bottom right, #e6f0ff, #e6ffe6); /* Calm and inviting */
        }
        .card-glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            border-top: 0.3rem solid #198754; /* Brand green for registration */
            box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.3s;
        }
        .card-glass:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2rem rgba(0,0,0,0.15);
        }
        .btn-brand {
            background-color: #198754;
            color: #fff;
            font-weight: 600;
        }
        .btn-brand:hover {
            background-color: #157347;
        }
        .header-title {
            color: #198754;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 px-3">

    <!-- Branding -->
    <div class="text-center mb-5">
        <img src="/images/logo.png" alt="Alumni Logo" class="rounded-circle shadow-sm mb-3" style="width: 80px; height: 80px;">
        <h1 class="display-5 fw-bold header-title">Join the Alumni Network</h1>
        <p class="text-secondary">Create your account to connect, grow, and thrive</p>
    </div>

    <!-- Register Card -->
    <div class="card card-glass p-4 p-md-5 shadow-lg" style="max-width: 450px; width: 100%;">
        <div class="card-body">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <input type="text" name="name" id="name" class="form-control rounded-pill shadow-sm"
                           value="{{ old('name') }}" required autofocus autocomplete="name">
                    <x-input-error :messages="$errors->get('name')" class="text-danger mt-1" />
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="email" class="form-control rounded-pill shadow-sm"
                           value="{{ old('email') }}" required autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="text-danger mt-1" />
                </div>

                <!-- Student ID -->
                <div class="mb-3">
                    <label for="student_id" class="form-label fw-semibold">Student ID</label>
                    <input type="text" name="student_id" id="student_id" class="form-control rounded-pill shadow-sm"
                           value="{{ old('student_id') }}" required>
                    <x-input-error :messages="$errors->get('student_id')" class="text-danger mt-1" />
                </div>

                <!-- Graduation Year -->
                <div class="mb-3">
                    <label for="graduation_year" class="form-label fw-semibold">Graduation Year</label>
                    <select id="graduation_year" name="graduation_year" class="form-select rounded-pill shadow-sm" required>
                        <option value="">Select Graduation Year</option>
                        @foreach($graduationYears as $year)
                            <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('graduation_year')" class="text-danger mt-1" />
                </div>

                <!-- Program -->
                <div class="mb-3">
                    <label for="program" class="form-label fw-semibold">Program</label>
                    <input type="text" name="program" id="program" class="form-control rounded-pill shadow-sm"
                           value="{{ old('program') }}" required>
                    <x-input-error :messages="$errors->get('program')" class="text-danger mt-1" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" id="password" class="form-control rounded-pill shadow-sm"
                           required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password')" class="text-danger mt-1" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="form-control rounded-pill shadow-sm" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger mt-1" />
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('login') }}" class="small text-secondary">Already registered?</a>
                    <button type="submit" class="btn btn-brand rounded-pill px-4 py-2 shadow">Register</button>
                </div>
            </form>

        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-5 text-center text-secondary small">
        &copy; {{ date('Y') }} Alumni System. All rights reserved.
    </footer>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
