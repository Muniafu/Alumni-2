<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $title }}
            </h2>
            @can('create jobs')
            <a href="{{ route('jobs.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Post New Opportunity
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Filter Tabs -->
                    <div class="flex border-b border-gray-200 mb-6">
                        <a href="{{ route('jobs.index') }}" class="px-4 py-2 {{ !request()->has('type') ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                            All
                        </a>
                        <a href="{{ route('jobs.index', ['type' => 'job']) }}" class="px-4 py-2 {{ request()->query('type') === 'job' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Jobs
                        </a>
                        <a href="{{ route('jobs.index', ['type' => 'internship']) }}" class="px-4 py-2 {{ request()->query('type') === 'internship' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Internships
                        </a>
                        <a href="{{ route('jobs.index', ['type' => 'mentorship']) }}" class="px-4 py-2 {{ request()->query('type') === 'mentorship' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Mentorships
                        </a>
                    </div>

                    <!-- Job Listings -->
                    <div class="space-y-6">
                        @forelse ($jobs as $job)
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            <a href="{{ route('jobs.show', $job) }}" class="hover:text-indigo-600">{{ $job->title }}</a>
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ $job->company }} • {{ $job->location }}</p>

                                        <div class="mt-2 flex flex-wrap gap-2">
                                            <span class="px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 rounded-full">
                                                {{ ucfirst($job->type) }}
                                            </span>
                                            @if($job->is_remote)
                                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                    Remote
                                                </span>
                                            @endif
                                            @if($job->employment_type)
                                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                    {{ $job->employment_type }}
                                                </span>
                                            @endif
                                            @if($job->salary_range)
                                                <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">
                                                    {{ $job->salary_range }}
                                                </span>
                                            @endif
                                            @if($job->isExpired)
                                                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                                    Expired
                                                </span>
                                            @elseif(!$job->is_active)
                                                <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
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
                                            <p class="text-sm {{ $job->isExpired ? 'text-red-600' : 'text-gray-600' }}">
                                                Deadline: {{ $job->application_deadline->format('M j, Y') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <p class="text-gray-700 line-clamp-2">{{ Str::limit($job->description, 200) }}</p>
                                </div>

                                <div class="mt-4 flex justify-between items-center">
                                    <div>
                                        @if($job->skills_required)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach(array_slice($job->skills_required, 0, 3) as $skill)
                                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                                @if(count($job->skills_required) > 3)
                                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">
                                                        +{{ count($job->skills_required) - 3 }} more
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('jobs.show', $job) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                        View Details →
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No opportunities found</h3>
                                <p class="mt-1 text-sm text-gray-500">There are currently no {{ request()->query('type') ?? 'job' }} postings available.</p>
                                @can('create jobs')
                                <div class="mt-6">
                                    <a href="{{ route('jobs.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Post New Opportunity
                                    </a>
                                </div>
                                @endcan
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($jobs->hasPages())
                    <div class="mt-6">
                        {{ $jobs->withQueryString()->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
