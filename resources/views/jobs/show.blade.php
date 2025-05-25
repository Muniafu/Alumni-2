<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-bold">{{ $job->title }}</h2>
                            <p class="text-gray-600 mt-1">{{ $job->company }} • {{ $job->location }} {{ $job->is_remote ? '(Remote)' : '' }}</p>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                    {{ ucfirst($job->type) }}
                                </span>
                                @if($job->salary_range)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded">
                                    {{ $job->salary_range }}
                                </span>
                                @endif
                                @if($job->employment_type)
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded">
                                    {{ $job->employment_type }}
                                </span>
                                @endif
                                @if($job->isExpired)
                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded">
                                    Expired
                                </span>
                                @elseif(!$job->is_active)
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded">
                                    Inactive
                                </span>
                                @endif
                            </div>
                        </div>
                        @can('update', $job)
                        <div class="flex space-x-2">
                            <a href="{{ route('jobs.edit', $job) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('jobs.destroy', $job) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this job posting?')">Delete</button>
                            </form>
                        </div>
                        @endcan
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <h3 class="font-medium text-lg mb-2">Job Description</h3>
                            <div class="prose max-w-none">
                                {!! nl2br(e($job->description)) !!}
                            </div>

                            @if($job->skills_required || $job->skills_preferred)
                            <div class="mt-6">
                                <h3 class="font-medium text-lg mb-2">Skills</h3>
                                @if($job->skills_required)
                                <div class="mb-4">
                                    <h4 class="font-medium mb-1">Required Skills</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($job->skills_required as $skill)
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-sm rounded">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                @if($job->skills_preferred)
                                <div>
                                    <h4 class="font-medium mb-1">Preferred Skills</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($job->skills_preferred as $skill)
                                            <span class="px-2 py-1 bg-purple-100 text-purple-800 text-sm rounded">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>

                        <div>
                            <div class="bg-gray-50 p-4 rounded-lg sticky top-4">
                                <h3 class="font-medium text-lg mb-3">Job Details</h3>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-gray-500 block text-sm">Posted by</span>
                                        <span class="font-medium">{{ $job->poster->name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 block text-sm">Posted on</span>
                                        <span class="font-medium">{{ $job->created_at->format('M j, Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 block text-sm">Location</span>
                                        <span class="font-medium">{{ $job->location }} {{ $job->is_remote ? '(Remote)' : '' }}</span>
                                    </div>
                                    @if($job->application_deadline)
                                    <div>
                                        <span class="text-gray-500 block text-sm">Application Deadline</span>
                                        <span class="font-medium {{ $job->isExpired ? 'text-red-500' : '' }}">
                                            {{ $job->application_deadline->format('M j, Y') }}
                                        </span>
                                    </div>
                                    @endif
                                    <div>
                                        <span class="text-gray-500 block text-sm">Contact Email</span>
                                        <a href="mailto:{{ $job->contact_email }}" class="font-medium text-blue-600">{{ $job->contact_email }}</a>
                                    </div>
                                    @if($job->contact_phone)
                                    <div>
                                        <span class="text-gray-500 block text-sm">Contact Phone</span>
                                        <span class="font-medium">{{ $job->contact_phone }}</span>
                                    </div>
                                    @endif
                                    @if($job->website)
                                    <div>
                                        <span class="text-gray-500 block text-sm">Website</span>
                                        <a href="{{ $job->website }}" target="_blank" class="font-medium text-blue-600">{{ $job->website }}</a>
                                    </div>
                                    @endif
                                </div>

                                @if($userApplication)
                                    <div class="mt-4 p-3 bg-blue-50 rounded border border-blue-100">
                                        <h4 class="font-medium text-blue-800 mb-1">Your Application Status</h4>
                                        <p class="text-blue-700">
                                            <span class="capitalize">{{ $userApplication->status }}</span>
                                            @if($userApplication->notes)
                                                <span class="block text-sm mt-1">{{ $userApplication->notes }}</span>
                                            @endif
                                        </p>
                                    </div>
                                @elseif($canApply)
                                    <div class="mt-4">
                                        <a href="#apply" class="btn btn-primary w-full">Apply Now</a>
                                    </div>
                                @else
                                    <div class="mt-4 p-3 bg-gray-50 rounded border border-gray-200">
                                        <p class="text-gray-600 text-sm">
                                            @if($job->isExpired)
                                                This job posting has expired.
                                            @elseif(!$job->is_active)
                                                This job posting is no longer active.
                                            @else
                                                You have already applied to this position.
                                            @endif
                                        </p>
                                    </div>
                                @endif

                                @can('viewApplications', $job)
                                <div class="mt-4">
                                    <a href="{{ route('jobs.applications', $job) }}" class="btn btn-secondary w-full">
                                        View Applications ({{ $job->applications_count ?? $job->applications()->count() }})
                                    </a>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>

                    @if($canApply)
                    <div id="apply" class="mt-8 pt-6 border-t">
                        <h3 class="font-medium text-lg mb-4">Apply for this Position</h3>
                        <form action="{{ route('jobs.apply', $job) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="cover_letter" class="block text-gray-700 mb-2">Cover Letter</label>
                                <textarea id="cover_letter" name="cover_letter" rows="6"
                                    class="form-textarea rounded-md shadow-sm w-full" required></textarea>
                                <p class="text-gray-500 text-sm mt-1">Explain why you're a good fit for this position.</p>
                            </div>
                            <div class="mb-4">
                                <label for="resume" class="block text-gray-700 mb-2">Resume</label>
                                <input type="file" id="resume" name="resume"
                                    class="form-input rounded-md shadow-sm" accept=".pdf,.doc,.docx" required>
                                <p class="text-gray-500 text-sm mt-1">PDF, DOC, or DOCX files only (max 2MB)</p>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Application</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
