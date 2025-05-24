<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Student ID -->
        <div class="mt-4">
            <x-input-label for="student_id" :value="__('Student ID')" />
            <x-text-input id="student_id" class="block mt-1 w-full" type="text" name="student_id" :value="old('student_id')" required />
            <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
        </div>

        <!-- Graduation Year -->
        <div class="mt-4">
            <x-input-label for="graduation_year" :value="__('Graduation Year')" />
            <select id="graduation_year" name="graduation_year" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">Select Graduation Year</option>
                @foreach($graduationYears as $year)
                    <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('graduation_year')" class="mt-2" />
        </div>

        <!-- Program -->
        <div class="mt-4">
            <x-input-label for="program" :value="__('Program')" />
            <x-text-input id="program" class="block mt-1 w-full" type="text" name="program" :value="old('program')" required />
            <x-input-error :messages="$errors->get('program')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>