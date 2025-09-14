<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @auth
        <meta name="user-id" content="{{ auth()->id() }}">
    @endauth

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Expose Laravel data to JS -->
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}',
            @auth
            userId: '{{ auth()->id() }}',
            @else
            userId: null,
            @endauth
        };
    </script>

    <!-- Notification Sound -->
    <audio id="notificationSound" src="{{ asset('sounds/notification.mp3') }}" preload="auto"></audio>
</head>
<body class="bg-light">
    <div id="app">
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (trim($__env->yieldContent('header')))
            <header class="bg-white border-bottom shadow-sm">
                <div class="container py-3">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="container my-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('scripts')
</body>
</html>
