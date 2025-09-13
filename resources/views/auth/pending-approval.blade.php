<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-indigo-50 via-white to-blue-50 px-6">

        <!-- Branding -->
        <div class="text-center mb-8">
            <img src="/images/logo.png" alt="Alumni Logo" class="mx-auto h-16 w-16 rounded-full shadow-md mb-4" />
            <h1 class="text-2xl font-bold text-blue-700">Account Pending Approval</h1>
        </div>

        <!-- Main Card -->
        <div class="w-full max-w-lg bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-xl border-t-4 border-amber-400">

            <div class="mb-6 text-center">
                <div class="flex justify-center mb-4">
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 text-amber-500 shadow-md">
                        ⏳
                    </span>
                </div>

                <h2 class="text-xl font-semibold text-gray-800">Your Account is Under Review</h2>
                <p class="mt-3 text-gray-600 leading-relaxed max-w-md mx-auto">
                    Thank you for registering with the <span class="text-blue-600 font-semibold">Alumni Network</span>.
                    Our administrators are currently reviewing your account details.
                    You’ll be notified by email once your access is approved ✅.
                </p>
            </div>

            <!-- Action -->
            <div class="mt-6 text-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition font-semibold">
                        {{ __('Log Out') }}
                    </button>
                </form>
                <p class="mt-4 text-sm text-gray-500">You can log in again later once your account is approved.</p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-10 text-gray-500 text-sm text-center">
            &copy; {{ date('Y') }} Alumni System · Empowering lifelong connections.
        </footer>
    </div>
</x-guest-layout>
