<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-indigo-50 via-white to-blue-50 px-6">

        <!-- Branding -->
        <div class="text-center mb-8">
            <img src="/images/logo.png" alt="App Logo" class="mx-auto h-16 w-16 rounded-full shadow-md mb-4" />
            <h1 class="text-2xl font-bold text-blue-700">Confirm Your Password</h1>
            <p class="text-gray-600 mt-2 max-w-md mx-auto leading-relaxed">
                🔒 This is a <span class="text-blue-600 font-semibold">secure area</span> of the system.
                Please re-enter your password to continue.
            </p>
        </div>

        <!-- Confirmation Card -->
        <div class="w-full max-w-md bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-xl border-t-4 border-blue-600">

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-800 font-semibold" />
                    <x-text-input id="password"
                                  class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  type="password"
                                  name="password"
                                  required
                                  autocomplete="current-password"
                                  placeholder="Enter your password securely" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                </div>

                <!-- Confirm Action -->
                <div class="flex items-center justify-end mt-6">
                    <x-primary-button class="px-6 py-3 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition font-semibold">
                        {{ __('Confirm & Continue') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Security Footer -->
        <footer class="mt-10 text-gray-500 text-sm text-center">
            &copy; {{ date('Y') }} Alumni System · Your security matters.
        </footer>
    </div>
</x-guest-layout>
