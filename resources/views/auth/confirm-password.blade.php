<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirm Password - Alumni System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(to bottom right, #eef2ff, #e6f0ff); /* Calm & trustworthy */
        }
        .card-glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            border-top: 0.3rem solid #0d6efd; /* Blue conveys trust/security */
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
        <h1 class="h4 fw-bold header-title">Confirm Your Password</h1>
        <p class="text-secondary mt-2" style="max-width: 400px; margin: 0 auto;">
            🔒 This is a <span class="text-primary fw-semibold">secure area</span> of the system.
            Please re-enter your password to continue.
        </p>
    </div>

    <!-- Confirmation Card -->
    <div class="card card-glass p-4 p-md-5 shadow-lg" style="max-width: 450px; width: 100%;">
        <div class="card-body">

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password Input -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" id="password"
                           class="form-control rounded-pill shadow-sm"
                           required autocomplete="current-password"
                           placeholder="Enter your password securely">
                    <x-input-error :messages="$errors->get('password')" class="text-danger mt-1" />
                </div>

                <!-- Confirm Action -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-brand rounded-pill px-4 py-2 shadow">
                        Confirm & Continue
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Security Footer -->
    <footer class="mt-5 text-center text-secondary small">
        &copy; {{ date('Y') }} Alumni System · Your security matters.
    </footer>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
