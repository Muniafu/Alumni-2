<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email - Alumni System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(to bottom right, #eef2ff, #e6f0ff); /* Calm & Trust */
        }
        .card-glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            border-top: 0.3rem solid #0d6efd; /* Brand accent */
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
        .alert-success {
            border-radius: 0.75rem;
        }
    </style>
</head>
<body>

<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 px-3">

    <!-- Branding -->
    <div class="text-center mb-5">
        <img src="/images/logo.png" alt="Alumni Logo" class="rounded-circle shadow-sm mb-3" style="width: 80px; height: 80px;">
        <h1 class="h4 fw-bold header-title">Verify Your Email</h1>
        <p class="text-muted mt-2" style="max-width: 400px; margin: 0 auto;">
            ✉️ Thanks for joining the <span class="fw-semibold text-primary">Alumni Network</span>!
            Please confirm your email address to get started.
        </p>
    </div>

    <!-- Card -->
    <div class="card card-glass p-4 p-md-5 shadow-lg" style="max-width: 500px; width: 100%;">

        <p class="text-secondary mb-3 small">
            {{ __('Before continuing, check your inbox for the verification link. Didn’t get it? We can send another one.') }}
        </p>

        <!-- Success Message -->
        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success mb-3" role="alert">
                ✅ {{ __('A new verification link has been sent to your email address.') }}
            </div>
        @endif

        <!-- Actions -->
        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mt-4">

            <!-- Resend Verification -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-brand btn-lg w-100">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-lg w-100">
                    {{ __('Log Out') }}
                </button>
            </form>

        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-5 text-center text-secondary small">
        &copy; {{ date('Y') }} Alumni System · Stay connected, stay verified.
    </footer>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
