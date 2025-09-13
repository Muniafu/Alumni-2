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
    <body class="bg-gray-100 text-gray-800">
        <div class="min-h-screen flex flex-col justify-center items-center">

            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-blue-600">🎓 Welcome to the Alumni Network</h1>
                <p class="mt-2 text-lg text-gray-600">
                    Connect with former classmates, find mentorship, explore jobs, and stay updated with events.
                </p>
            </div>

            <div class="flex gap-8">
                <a href="{{ route('login') }}"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg shadow hover:bg-gray-300 transition">
                    Register
                </a>
            </div>

            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 w-10/12">
                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="font-semibold text-lg text-blue-600">📅 Alumni Events</h2>
                    <p class="mt-2 text-gray-600">Stay connected by attending reunions, networking meetups, and workshops.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="font-semibold text-lg text-blue-600">💼 Job Opportunities</h2>
                    <p class="mt-2 text-gray-600">Discover career opportunities posted by alumni and companies worldwide.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="font-semibold text-lg text-blue-600">🤝 Mentorship</h2>
                    <p class="mt-2 text-gray-600">Find or become a mentor and guide the next generation of students.</p>
                </div>
            </div>

            <footer class="mt-20 text-gray-500">
                &copy; {{ date('Y') }} Alumni System. All rights reserved.
            </footer>
        </div>
    </body>
</html>
