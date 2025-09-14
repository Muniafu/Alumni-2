<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - Alumni System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(to bottom right, #eef2ff, #e6f0ff); /* Calm & professional */
        }
        .card-glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            border-top: 0.3rem solid #0d6efd; /* Brand color accent */
            box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.3s;
        }
        .card-glass:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2rem rgba(0,0,0,0.15);
        }
        .btn-brand {
            background-color: #0d6efd;
            color: #fff;
            font-weight: 600;
        }
        .btn-brand:hover {
            background-color: #0b5ed7;
        }
        .header-title {
            color: #0d6efd;
        }
    </style>
</head>
<body>

    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 px-3">
        <!-- Branding -->
        <div class="text-center mb-5">
            <img src="/images/logo.png" alt="Alumni Logo" class="rounded-circle shadow-sm mb-3" style="width: 80px; height: 80px;">
            <h1 class="h4 fw-bold header-title">Reset Your Password</h1>
            <p class="text-muted mt-2" style="max-width: 400px; margin: 0 auto;">
                Create a <span class="text-success fw-semibold">new secure password</span> to keep your account safe and accessible.
            </p>
        </div>

        <!-- Reset Card -->
        <div class="card card-glass p-4 p-md-5 shadow-lg" style="max-width: 500px; width: 100%;">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold text-secondary">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                        class="form-control form-control-lg @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold text-secondary">New Password</label>
                    <input type="password" id="password" name="password" required
                        class="form-control form-control-lg @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold text-secondary">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-brand btn-lg rounded-pill px-4 py-2 shadow">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <footer class="mt-5 text-center text-secondary small">
            &copy; {{ date('Y') }} Alumni System · Your security is our priority.
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
