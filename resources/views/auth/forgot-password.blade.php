<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password - Alumni System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(to bottom right, #e6f0ff, #e6ffe6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card-glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            border-top: 0.3rem solid #0d6efd;
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
        .logo-container {
            width: 100px;
            height: 100px;
            background: #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .database-error {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <!-- Branding -->
            <div class="text-center mb-5">
                <div class="logo-container">
                    ALUMNI
                </div>
                <h1 class="h3 fw-bold header-title">Forgot Your Password?</h1>
                <p class="text-secondary mt-2">
                    No problem. Enter your email below and we'll send you a
                    <span class="text-success fw-semibold">secure reset link</span> to choose a new one.
                </p>
            </div>

            

            <!-- Reset Password Card -->
            <div class="card card-glass p-4 p-md-5 shadow-lg">
                <div class="card-body">
                    <form id="password-reset-form" method="POST" action="#">
                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="email" class="form-control rounded-pill shadow-sm"
                                   value="thisismuniafu@gmail.com" required autofocus>
                        </div>

                        <!-- Action Button -->
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-brand rounded-pill px-4 py-2 shadow">
                                Email Password Reset Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Help Section -->
            <div class="mt-4 p-3 card-glass">
                <h5 class="fw-semibold">Need help?</h5>
            </div>

            <!-- Footer -->
            <footer class="mt-5 text-center text-secondary small">
                &copy; 2025 Alumni System. All rights reserved.
            </footer>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
