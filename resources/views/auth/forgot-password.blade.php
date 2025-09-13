<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-blue-50 via-white to-green-50 px-6">

        <!-- Branding -->
        <div class="text-center mb-8">
            <img src="/images/logo.png" alt="Alumni Logo" class="mx-auto h-16 w-16 rounded-full shadow-md mb-4" />
            <h1 class="text-2xl font-bold text-blue-700">Forgot Your Password?</h1>
            <p class="text-gray-600 mt-2 max-w-md mx-auto">
                No problem. Enter your email address below and we’ll send you a
                <span class="text-green-600 font-semibold">secure reset link</span> to choose a new one.
            </p>
        </div>

        <!-- Reset Password Card -->
        <div class="w-full max-w-md bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-xl border-t-4 border-blue-600">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-800 font-semibold" />
                    <x-text-input id="email"
                                  class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                </div>

                <!-- Action -->
                <div class="flex items-center justify-center mt-6">
                    <x-primary-button class="px-6 py-3 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition font-semibold">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <footer class="mt-10 text-gray-500 text-sm text-center">
            &copy; {{ date('Y') }} Alumni System. All rights reserved.
        </footer>
    </div>
</x-guest-layout>
