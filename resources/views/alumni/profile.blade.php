<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
            <span class="float-right">
                <span class="text-sm font-medium">Profile Completion: </span>
                <span class="text-sm font-bold
                    {{ $user->profile->profile_completion >= 80 ? 'text-green-600' :
                       ($user->profile->profile_completion >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $user->profile->profile_completion }}%
                </span>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1">
                    <div class="bg-blue-600 h-2.5 rounded-full"
                         style="width: {{ $user->profile->profile_completion }}%">
                    </div>
                </div>
            </span>
        </h2>

        @if($user->profile->profile_completion < 80)
        <div class="mt-2 p-3 bg-yellow-50 border-l-4 border-yellow-400">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Complete your profile to increase your visibility in the alumni network.
                        @if($user->profile->profile_completion < 50)
                        You're missing several important details.
                        @else
                        You're almost there! Just a few more details needed.
                        @endif
                    </p>
                </div>
            </div>
        </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('alumni.profile.update') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>

                                <!-- Name -->
                                <div>
                                    <x-input-label for="name" :value="__('Full Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                        :value="old('name', $user->name)" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Student ID (readonly) -->
                                <div>
                                    <x-input-label for="student_id" :value="__('Student ID')" />
                                    <x-text-input id="student_id" class="block mt-1 w-full bg-gray-100" type="text"
                                        name="student_id" :value="old('student_id', $user->student_id)" readonly />
                                </div>

                                <!-- Graduation Year (readonly) -->
                                <div>
                                    <x-input-label for="graduation_year" :value="__('Graduation Year')" />
                                    <x-text-input id="graduation_year" class="block mt-1 w-full bg-gray-100" type="text"
                                        name="graduation_year" :value="old('graduation_year', $user->graduation_year)" readonly />
                                </div>

                                <!-- Program (readonly) -->
                                <div>
                                    <x-input-label for="program" :value="__('Program')" />
                                    <x-text-input id="program" class="block mt-1 w-full bg-gray-100" type="text"
                                        name="program" :value="old('program', $user->program)" readonly />
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Contact Information</h3>

                                <!-- Phone -->
                                <div>
                                    <x-input-label for="phone" :value="__('Phone')" />
                                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                                        :value="old('phone', $user->profile->phone)" />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>

                                <!-- Address -->
                                <div>
                                    <x-input-label for="address" :value="__('Address')" />
                                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                                        :value="old('address', $user->profile->address)" />
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>

                                <!-- Current Job -->
                                <div>
                                    <x-input-label for="current_job" :value="__('Current Job Title')" />
                                    <x-text-input id="current_job" class="block mt-1 w-full" type="text" name="current_job"
                                        :value="old('current_job', $user->profile->current_job)" />
                                    <x-input-error :messages="$errors->get('current_job')" class="mt-2" />
                                </div>

                                <!-- Company -->
                                <div>
                                    <x-input-label for="company" :value="__('Current Company')" />
                                    <x-text-input id="company" class="block mt-1 w-full" type="text" name="company"
                                        :value="old('company', $user->profile->company)" />
                                    <x-input-error :messages="$errors->get('company')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Professional Details -->
                            <div class="md:col-span-2 space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Professional Details</h3>

                                <!-- Skills -->
                                <div>
                                    <x-input-label for="skills" :value="__('Skills (comma separated)')" />
                                    <x-text-input id="skills" class="block mt-1 w-full" type="text" name="skills"
                                        :value="old('skills', implode(', ', $user->profile->skills ?? []))"
                                        placeholder="e.g., PHP, JavaScript, Project Management" />
                                    <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                                </div>

                                <!-- Interests -->
                                <div>
                                    <x-input-label for="interests" :value="__('Professional Interests')" />
                                    <x-text-input id="interests" class="block mt-1 w-full" type="text" name="interests"
                                        :value="old('interests', implode(', ', $user->profile->interests ?? []))"
                                        placeholder="e.g., Web Development, Data Science, Mentoring" />
                                    <x-input-error :messages="$errors->get('interests')" class="mt-2" />
                                </div>

                                <!-- Bio -->
                                <div>
                                    <x-input-label for="bio" :value="__('Professional Bio')" />
                                    <textarea id="bio" name="bio" rows="4"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('bio', $user->profile->bio) }}</textarea>
                                    <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Social Links -->
                            <div class="md:col-span-2 space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Social Links</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- LinkedIn -->
                                    <div>
                                        <x-input-label for="linkedin" :value="__('LinkedIn Profile')" />
                                        <x-text-input id="linkedin" class="block mt-1 w-full" type="url" name="linkedin"
                                            :value="old('linkedin', $user->profile->getSocialLink('linkedin'))"
                                            placeholder="https://linkedin.com/in/username" />
                                        <x-input-error :messages="$errors->get('linkedin')" class="mt-2" />
                                    </div>

                                    <!-- Twitter -->
                                    <div>
                                        <x-input-label for="twitter" :value="__('Twitter Profile')" />
                                        <x-text-input id="twitter" class="block mt-1 w-full" type="url" name="twitter"
                                            :value="old('twitter', $user->profile->getSocialLink('twitter'))"
                                            placeholder="https://twitter.com/username" />
                                        <x-input-error :messages="$errors->get('twitter')" class="mt-2" />
                                    </div>

                                    <!-- GitHub -->
                                    <div>
                                        <x-input-label for="github" :value="__('GitHub Profile')" />
                                        <x-text-input id="github" class="block mt-1 w-full" type="url" name="github"
                                            :value="old('github', $user->profile->getSocialLink('github'))"
                                            placeholder="https://github.com/username" />
                                        <x-input-error :messages="$errors->get('github')" class="mt-2" />
                                    </div>

                                    <!-- Personal Website -->
                                    <div>
                                        <x-input-label for="website" :value="__('Personal Website')" />
                                        <x-text-input id="website" class="block mt-1 w-full" type="url" name="website"
                                            :value="old('website', $user->profile->getSocialLink('website'))"
                                            placeholder="https://yourwebsite.com" />
                                        <x-input-error :messages="$errors->get('website')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button class="ml-3">
                                {{ __('Update Profile') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
