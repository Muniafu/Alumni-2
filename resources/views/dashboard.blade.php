<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Alumni System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(to right, #f0f8ff, #e6f7e6); /* Calm, productive background */
            color: #1a1a1a;
        }
        .card-glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            border-top: 0.3rem solid #0d6efd; /* Brand primary color */
            box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.3s;
        }
        .card-glass:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2rem rgba(0,0,0,0.15);
        }
        .header-title {
            color: #0d6efd; /* Brand primary */
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <!-- Header -->
        <div class="mb-4 text-center">
            <h2 class="header-title display-6">Dashboard</h2>
        </div>

        <!-- Welcome Card -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-glass p-4">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold mb-3">Welcome, {{ auth()->user()->name }}!</h5>
                        <p class="card-text lead text-secondary mb-4">You're successfully logged in to the Alumni System.</p>

                        <!-- Feature Quick Links -->
                        <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                            @if(auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg shadow">Admin Dashboard</a>
                                <a href="{{ route('admin.user-management') }}" class="btn btn-outline-primary btn-lg shadow">User Management</a>
                            @elseif(auth()->user()->hasRole('alumni'))
                                <a href="{{ route('alumni.dashboard') }}" class="btn btn-success btn-lg shadow">Alumni Dashboard</a>
                                <a href="{{ route('alumni.profile') }}" class="btn btn-outline-success btn-lg shadow">My Profile</a>
                            @elseif(auth()->user()->hasRole('student'))
                                <a href="{{ route('student.dashboard') }}" class="btn btn-warning btn-lg shadow">Student Dashboard</a>
                                <a href="{{ route('student.profile') }}" class="btn btn-outline-warning btn-lg shadow">My Profile</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats / Future-Forward Cards -->
        <div class="row mt-5 g-4">
            <div class="col-md-4">
                <div class="card card-glass p-4 text-center border-top-primary">
                    <h5 class="text-primary fw-semibold">📅 Upcoming Events</h5>
                    <p class="text-secondary">Stay updated with the latest reunions and workshops to expand your network.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-glass p-4 text-center border-top-success">
                    <h5 class="text-success fw-semibold">💼 Job Opportunities</h5>
                    <p class="text-secondary">Access career opportunities and postings from alumni around the globe.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-glass p-4 text-center border-top-warning">
                    <h5 class="text-warning fw-semibold">🤝 Mentorship</h5>
                    <p class="text-secondary">Connect with mentors or support students to foster growth within the community.</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
