<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-indigo-50 via-white to-blue-50 px-6">

        <!-- Branding -->
        <div class="text-center mb-8">
            <img src="/images/logo.png" alt="Alumni Logo" class="mx-auto h-16 w-16 rounded-full shadow-md mb-4" />
            <h1 class="text-2xl font-bold text-blue-700">Verify Your Email</h1>
            <p class="text-gray-600 mt-2 max-w-md mx-auto leading-relaxed">
                ✉️ Thanks for joining the <span class="text-blue-600 font-semibold">Alumni Network</span>!
                To get started, please confirm your email address.
            </p>
        </div>

        <!-- Main Card -->
        <div class="w-full max-w-lg bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-xl border-t-4 border-blue-600">

            <div class="mb-4 text-sm text-gray-700">
                {{ __('Before continuing, check your inbox for the verification link. Didn’t get it? We can send another one.') }}
            </div>

            <!-- Success Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-200 shadow-sm">
                    ✅ {{ __('A new verification link has been sent to your email address.') }}
                </div>
            @endif

            <!-- Actions -->
            <div class="mt-6 flex items-center justify-between">

                <!-- Resend Button -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-primary-button class="px-6 py-3 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition font-semibold">
                        {{ __('Resend Verification Email') }}
                    </x-primary-button>
                </form>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="underline text-sm text-gray-600 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400 transition">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-10 text-gray-500 text-sm text-center">
            &copy; {{ date('Y') }} Alumni System · Stay connected, stay verified.
        </footer>
    </div>
</x-guest-layout>
