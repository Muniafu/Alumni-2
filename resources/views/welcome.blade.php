<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alumni System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(to bottom right, #e0f2ff, #ffffff, #e6f7e6);
            color: #1a1a1a;
        }
        .glass-card {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            border-top: 0.3rem solid;
            box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.3s;
        }
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2rem rgba(0,0,0,0.15);
        }
        .cta-btn {
            border-radius: 2rem;
            font-weight: 600;
            font-size: 1.15rem;
            padding: 0.75rem 2rem;
        }
    </style>
</head>
<body>

    <div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center text-center py-5">

        <!-- Branding -->
        <div class="mb-5">
            <img src="/images/logo.png" alt="Alumni Logo" class="rounded-circle shadow-sm mb-3" style="width:80px; height:80px;">
            <h1 class="display-4 fw-bold text-primary mb-2">🎓 Alumni Network</h1>
            <p class="lead text-secondary mx-auto" style="max-width:600px;">
                A global community where connections turn into opportunities —
                <span class="text-success fw-semibold">learn, grow, and thrive together.</span>
            </p>
        </div>

        <!-- CTA Buttons -->
        <div class="d-flex flex-column flex-md-row gap-3 mb-5">
            <a href="{{ route('login') }}" class="btn btn-primary cta-btn shadow">
                Login
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary cta-btn shadow">
                Register
            </a>
        </div>

        <!-- Feature Highlights -->
        <div class="row text-center g-4 w-100 justify-content-center">
            <div class="col-md-4">
                <div class="glass-card border-top-primary p-4 h-100">
                    <h3 class="text-primary mb-3">📅 Alumni Events</h3>
                    <p class="text-secondary">
                        Stay connected through reunions, workshops, and networking meetups designed to
                        <span class="text-success fw-medium">foster growth and belonging.</span>
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="glass-card border-top-success p-4 h-100">
                    <h3 class="text-success mb-3">💼 Job Opportunities</h3>
                    <p class="text-secondary">
                        Explore global career opportunities and alumni-driven postings that empower
                        <span class="text-warning fw-medium">your professional journey.</span>
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="glass-card border-top-warning p-4 h-100">
                    <h3 class="text-warning mb-3">🤝 Mentorship</h3>
                    <p class="text-secondary">
                        Find or become a mentor to inspire students and alumni alike,
                        strengthening our <span class="text-primary fw-medium">circle of support.</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-5 text-secondary small text-center">
            <p>&copy; {{ date('Y') }} Alumni System. All rights reserved.</p>
            <p>
                <a href="#" class="text-decoration-underline text-primary">Accessibility</a> •
                <a href="#" class="text-decoration-underline text-primary">Privacy Policy</a>
            </p>
        </footer>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
