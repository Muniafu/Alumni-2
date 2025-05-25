<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $title }}
            </h2>
            @can('create', App\Models\JobPosting::class)
            <a href="{{ route('jobs.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Post New Opportunity
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4 flex space-x-4">
                        <a href="{{ route('jobs.index') }}" class="{{ !request()->has('type') ? 'font-bold text-blue-600' : 'text-gray-600' }}">All</a>
                        <a href="{{ route('jobs.index', ['type' => 'job']) }}" class="{{ request()->query('type') === 'job' ? 'font-bold text-blue-600' : 'text-gray-600' }}">Jobs</a>
                        <a href="{{ route('jobs.index', ['type' => 'internship']) }}" class="{{ request()->query('type') === 'internship' ? 'font-bold text-blue-600' : 'text-gray-600' }}">Internships</a>
                        <a href="{{ route('jobs.index', ['type' => 'mentorship']) }}" class="{{ request()->query('type') === 'mentorship' ? 'font-bold text-blue-600' : 'text-gray-600' }}">Mentorships</a>
                    </div>

                    @if($jobs->isEmpty())
                        <p class="text-gray-500">No job postings available.</p>
                    @else
                        <div class="space-y-6">
                            @foreach($jobs as $job)
                                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-bold text-lg mb-1">
                                                    <a href="{{ route('jobs.show', $job) }}" class="hover:text-blue-600">{{ $job->title }}</a>
                                                </h3>
                                                <p class="text-gray-600 mb-2">{{ $job->company }} • {{ $job->location }} {{ $job->is_remote ? '(Remote)' : '' }}</p>
                                                <div class="flex flex-wrap gap-2 mb-3">
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
                                            <div class="text-right">
                                                <p class="text-sm text-gray-500">Posted {{ $job->created_at->diffForHumans() }}</p>
                                                @if($job->application_deadline)
                                                <p class="text-sm {{ $job->isExpired ? 'text-red-500' : 'text-gray-500' }}">
                                                    Deadline: {{ $job->application_deadline->format('M j, Y') }}
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="text-gray-700 mb-4 line-clamp-2">{{ Str::limit($job->description, 200) }}</p>
                                        <div class="flex justify-between items-center">
                                            <div class="flex flex-wrap gap-2">
                                                @if($job->skills_required)
                                                    @foreach(array_slice($job->skills_required, 0, 3) as $skill)
                                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">{{ $skill }}</span>
                                                    @endforeach
                                                    @if(count($job->skills_required) > 3)
                                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">+{{ count($job->skills_required) - 3 }} more</span>
                                                    @endif
                                                @endif
                                            </div>
                                            <a href="{{ route('jobs.show', $job) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $jobs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
