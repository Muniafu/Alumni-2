<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pending Approval - Alumni System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(to bottom right, #eef2ff, #e6f0ff); /* Calm & reassuring */
        }
        .card-glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            border-top: 0.3rem solid #ffc107; /* Amber: attention but not alarming */
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
        .icon-circle {
            width: 64px;
            height: 64px;
            font-size: 2rem;
        }
    </style>
</head>
<body>

<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 px-3">

    <!-- Branding -->
    <div class="text-center mb-5">
        <img src="/images/logo.png" alt="Alumni Logo" class="rounded-circle shadow-sm mb-3" style="width: 80px; height: 80px;">
        <h1 class="h4 fw-bold header-title">Account Pending Approval</h1>
    </div>

    <!-- Main Card -->
    <div class="card card-glass p-4 p-md-5 shadow-lg text-center" style="max-width: 500px; width: 100%;">
        <div class="mb-4">
            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning text-white shadow-sm icon-circle mb-3">
                ⏳
            </span>
            <h2 class="h5 fw-semibold text-secondary">Your Account is Under Review</h2>
            <p class="mt-3 text-muted" style="max-width: 400px; margin: 0 auto;">
                Thank you for registering with the <span class="text-primary fw-semibold">Alumni Network</span>.
                Our administrators are currently reviewing your account details.
                You’ll be notified by email once your access is approved ✅.
            </p>
        </div>

        <!-- Action Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-brand rounded-pill px-4 py-2 shadow">
                Log Out
            </button>
        </form>

        <p class="mt-4 text-muted small">You can log in again later once your account is approved.</p>
    </div>

    <!-- Footer -->
    <footer class="mt-5 text-center text-secondary small">
        &copy; {{ date('Y') }} Alumni System · Empowering lifelong connections.
    </footer>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
