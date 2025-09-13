<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Alumni System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-green-50 bg-gray-400 text-gray-800 font-sans antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center px-6">

        <!-- Branding -->
        <div class="text-center mb-12">
            <img src="/images/logo.png" alt="Alumni Logo" class="mx-auto h-16 w-16 rounded-full shadow-md mb-4" />
            <h1 class="text-5xl font-extrabold text-blue-700 tracking-tight">
                🎓 Alumni Network
            </h1>
            <p class="mt-3 text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                A global community where connections turn into opportunities —
                <span class="text-green-600 font-semibold">learn, grow, and thrive together.</span>
            </p>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col md:flex-row gap-6 mb-12">
            <a href="{{ route('login') }}"
               class="px-8 py-4 bg-blue-600 text-white rounded-2xl shadow-lg hover:bg-blue-700
                      focus:ring-4 focus:ring-blue-300 focus:outline-none transition text-lg font-semibold">
                Login
            </a>
            <a href="{{ route('register') }}"
               class="px-8 py-4 bg-blue-700 border border-gray-300 text-gray-900 rounded-2xl shadow-lg
                      hover:bg-gray-300 focus:ring-4 focus:ring-green-300 focus:outline-none
                      transition text-lg font-semibold">
                Register
            </a>
        </div>

        <!-- Feature Highlights -->
        <div class="mt-20 grid text-center mb-12 grid-cols-1 md:grid-cols-3 gap-10 w-full max-w-6xl">
            <div class="bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-lg hover:shadow-xl
                        transition border-t-4 border-blue-600">
                <h2 class="font-semibold text-xl text-blue-700">📅 Alumni Events</h2>
                <p class="mt-3 text-gray-700 leading-relaxed">
                    Stay connected through reunions, workshops, and networking meetups designed to
                    <span class="text-green-600 font-medium">foster growth and belonging.</span>
                </p>
            </div>

            <div class="bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-lg hover:shadow-xl
                        transition border-t-4 border-green-600">
                <h2 class="font-semibold text-xl text-green-700">💼 Job Opportunities</h2>
                <p class="mt-3 text-gray-700 leading-relaxed">
                    Explore global career opportunities and alumni-driven postings that empower
                    <span class="text-orange-600 font-medium">your professional journey.</span>
                </p>
            </div>

            <div class="bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-lg hover:shadow-xl
                        transition border-t-4 border-orange-500">
                <h2 class="font-semibold text-xl text-orange-600">🤝 Mentorship</h2>
                <p class="mt-3 text-gray-700 leading-relaxed">
                    Find or become a mentor to inspire students and alumni alike,
                    strengthening our <span class="text-blue-600 font-medium">circle of support.</span>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-24 text-gray-500 text-sm text-center">
            <p>&copy; {{ date('Y') }} Alumni System. All rights reserved.</p>
            <p class="mt-1">
                <a href="#" class="hover:text-blue-600 underline">Accessibility</a> •
                <a href="#" class="hover:text-blue-600 underline">Privacy Policy</a>
            </p>
        </footer>
    </div>
</body>
</html>
