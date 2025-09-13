<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-blue-50 via-white to-green-50 px-6">

        <!-- Branding -->
        <div class="text-center mb-8">
            <img src="/images/logo.png" alt="Alumni Logo" class="mx-auto h-16 w-16 rounded-full shadow-md mb-4" />
            <h1 class="text-3xl font-bold text-blue-700">Join the Alumni Network</h1>
            <p class="text-gray-600 mt-1">Create your account to connect, grow, and thrive</p>
        </div>

        <!-- Register Card -->
        <div class="w-full max-w-md bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-xl border-t-4 border-green-600">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-gray-800 font-semibold" />
                    <x-text-input id="name"
                                  class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-800 font-semibold" />
                    <x-text-input id="email"
                                  class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                </div>

                <!-- Student ID -->
                <div class="mt-4">
                    <x-input-label for="student_id" :value="__('Student ID')" class="text-gray-800 font-semibold" />
                    <x-text-input id="student_id"
                                  class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  type="text" name="student_id" :value="old('student_id')" required />
                    <x-input-error :messages="$errors->get('student_id')" class="mt-2 text-red-600" />
                </div>

                <!-- Graduation Year -->
                <div class="mt-4">
                    <x-input-label for="graduation_year" :value="__('Graduation Year')" class="text-gray-800 font-semibold" />
                    <select id="graduation_year"
                            name="graduation_year"
                            class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500" required>
                        <option value="">Select Graduation Year</option>
                        @foreach($graduationYears as $year)
                            <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('graduation_year')" class="mt-2 text-red-600" />
                </div>

                <!-- Program -->
                <div class="mt-4">
                    <x-input-label for="program" :value="__('Program')" class="text-gray-800 font-semibold" />
                    <x-text-input id="program"
                                  class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500"
                                  type="text" name="program" :value="old('program')" required />
                    <x-input-error :messages="$errors->get('program')" class="mt-2 text-red-600" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-800 font-semibold" />
                    <x-text-input id="password"
                                  class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-800 font-semibold" />
                    <x-text-input id="password_confirmation"
                                  class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between mt-6">
                    <a class="underline text-sm text-gray-600 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 rounded-md" href="{{ route('login') }}">
                        Already registered?
                    </a>

                    <x-primary-button class="ms-4 px-6 py-3 bg-green-600 text-white rounded-xl shadow-md hover:bg-green-700 focus:ring-4 focus:ring-green-300 focus:outline-none transition font-semibold">
                        {{ __('Register') }}
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
