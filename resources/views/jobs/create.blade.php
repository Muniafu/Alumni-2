<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Job Posting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Error Display -->
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('jobs.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Job Title -->
                            <div class="md:col-span-2">
                                <x-input-label for="title" :value="__('Job Title *')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text"
                                    name="title" :value="old('title')" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Job Type -->
                            <div>
                                <x-input-label for="type" :value="__('Job Type *')" />
                                <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="job" {{ old('type') == 'job' ? 'selected' : '' }}>Job</option>
                                    <option value="internship" {{ old('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                                    <option value="mentorship" {{ old('type') == 'mentorship' ? 'selected' : '' }}>Mentorship</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- Company -->
                            <div>
                                <x-input-label for="company" :value="__('Company *')" />
                                <x-text-input id="company" class="block mt-1 w-full" type="text"
                                    name="company" :value="old('company')" required />
                                <x-input-error :messages="$errors->get('company')" class="mt-2" />
                            </div>

                            <!-- Location -->
                            <div>
                                <x-input-label for="location" :value="__('Location *')" />
                                <x-text-input id="location" class="block mt-1 w-full" type="text"
                                    name="location" :value="old('location')" required />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <!-- Remote Work -->
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_remote" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        {{ old('is_remote') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">This is a remote position</span>
                                </label>
                            </div>

                            <!-- Employment Type -->
                            <div>
                                <x-input-label for="employment_type" :value="__('Employment Type')" />
                                <x-text-input id="employment_type" class="block mt-1 w-full" type="text"
                                    name="employment_type" :value="old('employment_type')"
                                    placeholder="Full-time, Part-time, Contract" />
                                <x-input-error :messages="$errors->get('employment_type')" class="mt-2" />
                            </div>

                            <!-- Salary Range -->
                            <div>
                                <x-input-label for="salary_range" :value="__('Salary Range')" />
                                <x-text-input id="salary_range" class="block mt-1 w-full" type="text"
                                    name="salary_range" :value="old('salary_range')"
                                    placeholder="e.g. $50,000 - $70,000" />
                                <x-input-error :messages="$errors->get('salary_range')" class="mt-2" />
                            </div>

                            <!-- Application Deadline -->
                            <div>
                                <x-input-label for="application_deadline" :value="__('Application Deadline')" />
                                <x-text-input id="application_deadline" class="block mt-1 w-full" type="date"
                                    name="application_deadline" :value="old('application_deadline')" />
                                <x-input-error :messages="$errors->get('application_deadline')" class="mt-2" />
                            </div>

                            <!-- Contact Email -->
                            <div>
                                <x-input-label for="contact_email" :value="__('Contact Email *')" />
                                <x-text-input id="contact_email" class="block mt-1 w-full" type="email"
                                    name="contact_email" :value="old('contact_email')" required />
                                <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                            </div>

                            <!-- Contact Phone -->
                            <div>
                                <x-input-label for="contact_phone" :value="__('Contact Phone')" />
                                <x-text-input id="contact_phone" class="block mt-1 w-full" type="tel"
                                    name="contact_phone" :value="old('contact_phone')" />
                                <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                            </div>

                            <!-- Website -->
                            <div>
                                <x-input-label for="website" :value="__('Website')" />
                                <x-text-input id="website" class="block mt-1 w-full" type="url"
                                    name="website" :value="old('website')" placeholder="https://" />
                                <x-input-error :messages="$errors->get('website')" class="mt-2" />
                            </div>

                            <!-- Required Skills -->
                            <div>
                                <x-input-label for="skills_required" :value="__('Required Skills (comma separated)')" />
                                <x-text-input id="skills_required" class="block mt-1 w-full" type="text"
                                    name="skills_required" :value="old('skills_required')"
                                    placeholder="PHP, Laravel, MySQL" />
                                <x-input-error :messages="$errors->get('skills_required')" class="mt-2" />
                            </div>

                            <!-- Preferred Skills -->
                            <div>
                                <x-input-label for="skills_preferred" :value="__('Preferred Skills (comma separated)')" />
                                <x-text-input id="skills_preferred" class="block mt-1 w-full" type="text"
                                    name="skills_preferred" :value="old('skills_preferred')"
                                    placeholder="Vue.js, AWS, Docker" />
                                <x-input-error :messages="$errors->get('skills_preferred')" class="mt-2" />
                            </div>

                            <!-- Job Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Job Description *')" />
                                <textarea id="description" name="description" rows="6"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Post Job') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
