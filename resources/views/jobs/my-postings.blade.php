<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Job Postings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($jobs->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-600">You haven't posted any jobs yet.</p>
                            <a href="{{ route('jobs.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Post a New Job
                            </a>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($jobs as $job)
                                <div class="p-6 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold">
                                                <a href="{{ route('jobs.show', $job) }}" class="hover:text-blue-600">
                                                    {{ $job->title }}
                                                </a>
                                            </h3>
                                            <p class="text-gray-600 mt-1">{{ $job->company }} • {{ $job->location }}</p>

                                            <div class="mt-2 flex items-center text-sm text-gray-600">
                                                <span class="mr-2">{{ $job->employment_type }}</span>
                                                •
                                                <span class="mx-2">{{ $job->applications_count }} applications</span>
                                                •
                                                <span class="ml-2">{{ $job->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                                {{ $job->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $job->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $jobs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
