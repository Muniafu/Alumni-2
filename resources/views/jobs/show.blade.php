<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h1>
                            <p class="text-lg text-gray-600 mt-1">{{ $job->company }} • {{ $job->location }} {{ $job->is_remote ? '(Remote)' : '' }}</p>

                            <div class="mt-3 flex flex-wrap gap-2">
                                <span class="px-3 py-1 text-sm font-medium bg-indigo-100 text-indigo-800 rounded-full">
                                    {{ ucfirst($job->type) }}
                                </span>
                                @if($job->is_remote)
                                    <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">
                                        Remote
                                    </span>
                                @endif
                                @if($job->employment_type)
                                    <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-full">
                                        {{ $job->employment_type }}
                                    </span>
                                @endif
                                @if($job->salary_range)
                                    <span class="px-3 py-1 text-sm font-medium bg-purple-100 text-purple-800 rounded-full">
                                        {{ $job->salary_range }}
                                    </span>
                                @endif
                                @if($job->is_expired)
                                    <span class="px-3 py-1 text-sm font-medium bg-red-100 text-red-800 rounded-full">
                                        Expired
                                    </span>
                                @elseif(!$job->is_active)
                                    <span class="px-3 py-1 text-sm font-medium bg-gray-100 text-gray-800 rounded-full">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-sm text-gray-500">
                                Posted {{ $job->created_at->diffForHumans() }}
                            </p>
                            @if($job->application_deadline)
                                <p class="text-sm {{ $job->is_expired ? 'text-red-600' : 'text-gray-600' }}">
                                    Deadline: {{ $job->application_deadline->format('M j, Y') }}
                                </p>
                            @endif
                            <p class="text-sm text-gray-600 mt-1">
                                Posted by: {{ $job->poster->name }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="md:col-span-2">
                            <!-- Job Description -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Job Description</h3>
                                <div class="prose max-w-none">
                                    {!! nl2br(e($job->description)) !!}
                                </div>
                            </div>

                            <!-- Required Skills -->
                            @if($job->skills_required && count($job->skills_required) > 0)
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Required Skills</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($job->skills_required as $skill)
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Preferred Skills -->
                            @if($job->skills_preferred && count($job->skills_preferred) > 0)
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Preferred Skills</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($job->skills_preferred as $skill)
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="space-y-6">
                            <!-- Application Status/Box -->
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                @if($userApplication)
                                    <div class="text-center py-4">
                                        <svg class="mx-auto h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h3 class="mt-2 text-lg font-medium text-gray-900">Application Submitted</h3>
                                        <p class="mt-1 text-sm text-gray-500">You've already applied to this position.</p>
                                        <div class="mt-4 p-3 bg-blue-50 rounded border border-blue-100">
                                            <h4 class="font-medium text-blue-800 mb-1">Status</h4>
                                            <p class="text-blue-700">
                                                <span class="capitalize">{{ $userApplication->status }}</span>
                                                @if($userApplication->notes)
                                                    <span class="block text-sm mt-1">{{ $userApplication->notes }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @elseif($job->canApply())
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Apply for this position</h3>
                                    <form method="POST" action="{{ route('jobs.apply', $job) }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="mb-4">
                                            <x-input-label for="cover_letter" :value="__('Cover Letter *')" />
                                            <textarea id="cover_letter" name="cover_letter" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                                            <x-input-error :messages="$errors->get('cover_letter')" class="mt-2" />
                                            <p class="text-gray-500 text-sm mt-1">Explain why you're a good fit for this position.</p>
                                        </div>

                                        <div class="mb-4">
                                            <x-input-label for="resume" :value="__('Resume *')" />
                                            <input id="resume" name="resume" type="file" class="block mt-1 w-full text-sm text-gray-500
                                                file:mr-4 file:py-2 file:px-4
                                                file:rounded-md file:border-0
                                                file:text-sm file:font-semibold
                                                file:bg-indigo-50 file:text-indigo-700
                                                hover:file:bg-indigo-100" required accept=".pdf,.doc,.docx" />
                                            <x-input-error :messages="$errors->get('resume')" class="mt-2" />
                                            <p class="mt-1 text-xs text-gray-500">PDF, DOC, or DOCX (Max: 2MB)</p>
                                        </div>

                                        <x-primary-button class="w-full justify-center">
                                            {{ __('Submit Application') }}
                                        </x-primary-button>
                                    </form>
                                @elseif($job->is_expired)
                                    <div class="text-center py-4">
                                        <svg class="mx-auto h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <h3 class="mt-2 text-lg font-medium text-gray-900">Application Closed</h3>
                                        <p class="mt-1 text-sm text-gray-500">The deadline for this position has passed.</p>
                                    </div>
                                @elseif(!$job->is_active)
                                    <div class="text-center py-4">
                                        <svg class="mx-auto h-12 w-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <h3 class="mt-2 text-lg font-medium text-gray-900">Not Accepting Applications</h3>
                                        <p class="mt-1 text-sm text-gray-500">This position is not currently active.</p>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <svg class="mx-auto h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h3 class="mt-2 text-lg font-medium text-gray-900">Login to Apply</h3>
                                        <p class="mt-1 text-sm text-gray-500">You need to be logged in to apply for this position.</p>
                                        <div class="mt-4">
                                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Sign In
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Job Details -->
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Job Details</h3>
                                <div class="space-y-3">
                                    @if($job->type)
                                    <div class="flex">
                                        <span class="text-gray-500 w-32">Type:</span>
                                        <span class="text-gray-700">{{ ucfirst($job->type) }}</span>
                                    </div>
                                    @endif

                                    @if($job->employment_type)
                                    <div class="flex">
                                        <span class="text-gray-500 w-32">Employment:</span>
                                        <span class="text-gray-700">{{ $job->employment_type }}</span>
                                    </div>
                                    @endif

                                    @if($job->salary_range)
                                    <div class="flex">
                                        <span class="text-gray-500 w-32">Salary:</span>
                                        <span class="text-gray-700">{{ $job->salary_range }}</span>
                                    </div>
                                    @endif

                                    @if($job->application_deadline)
                                    <div class="flex">
                                        <span class="text-gray-500 w-32">Deadline:</span>
                                        <span class="text-gray-700">{{ $job->application_deadline->format('M j, Y') }}</span>
                                    </div>
                                    @endif

                                    @if($job->contact_email)
                                    <div class="flex">
                                        <span class="text-gray-500 w-32">Contact Email:</span>
                                        <a href="mailto:{{ $job->contact_email }}" class="text-indigo-600 hover:text-indigo-800">{{ $job->contact_email }}</a>
                                    </div>
                                    @endif

                                    @if($job->contact_phone)
                                    <div class="flex">
                                        <span class="text-gray-500 w-32">Contact Phone:</span>
                                        <span class="text-gray-700">{{ $job->contact_phone }}</span>
                                    </div>
                                    @endif

                                    @if($job->website)
                                    <div class="flex">
                                        <span class="text-gray-500 w-32">Website:</span>
                                        <a href="{{ $job->website }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">{{ $job->website }}</a>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            @can('update', $job)
                            <div class="mt-6 flex space-x-4">
                                <a href="{{ route('jobs.edit', $job) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('jobs.destroy', $job) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button onclick="return confirm('Are you sure you want to delete this job posting?')">
                                        Delete
                                    </x-danger-button>
                                </form>
                            </div>
                            @endcan

                            @can('viewApplications', $job)
                            <div class="mt-4">
                                <a href="{{ route('jobs.applications', $job) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View Applications ({{ $job->applications_count ?? $job->applications()->count() }})
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
