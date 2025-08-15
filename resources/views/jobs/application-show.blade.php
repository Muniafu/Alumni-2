<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Application for: {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Applicant Information</h3>
                        <div class="mt-4 flex items-center">
                            <img class="h-12 w-12 rounded-full" src="{{ $application->applicant->profile_photo_url }}" alt="">
                            <div class="ml-4">
                                <h4 class="text-lg font-medium">{{ $application->applicant->name }}</h4>
                                <p class="text-gray-600">{{ $application->applicant->email }}</p>
                                @if($application->applicant->profile)
                                    <p class="text-gray-600">{{ $application->applicant->profile->current_job }}</p>
                                    <p class="text-gray-600">{{ $application->applicant->profile->company }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Application Details</h3>
                        <div class="mt-4">
                            <p class="text-gray-600"><strong>Status:</strong>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($application->status === 'submitted') bg-blue-100 text-blue-800
                                    @elseif($application->status === 'reviewed') bg-yellow-100 text-yellow-800
                                    @elseif($application->status === 'interviewed') bg-purple-100 text-purple-800
                                    @elseif($application->status === 'hired') bg-green-100 text-green-800
                                    @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </p>
                            <p class="text-gray-600"><strong>Applied:</strong> {{ $application->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Cover Letter</h3>
                        <div class="mt-4 p-4 bg-gray-50 rounded">
                            {!! nl2br(e($application->cover_letter)) !!}
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Resume</h3>
                        <div class="mt-4">
                            <a href="{{ Storage::disk('public')->url($application->resume_path) }}" target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Download Resume
                            </a>
                        </div>
                    </div>

                    @can('updateApplication', $application)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Update Status</h3>
                            <form action="{{ route('jobs.applications.update', [$job, $application]) }}" method="POST" class="mt-4">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                        <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                            <option value="submitted" {{ $application->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                            <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                            <option value="interviewed" {{ $application->status === 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                                            <option value="hired" {{ $application->status === 'hired' ? 'selected' : '' }}>Hired</option>
                                            <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                        <textarea id="notes" name="notes" rows="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('notes', $application->notes) }}</textarea>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Update Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
