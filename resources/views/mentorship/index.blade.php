<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Mentorships') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">My Mentorships</h2>
                        <a href="{{ route('mentorship.find') }}" class="btn btn-primary">
                            Find a Mentor
                        </a>
                    </div>

                    <div class="space-y-6">
                        @forelse($mentorships as $mentorship)
                            <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                <div class="p-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-bold text-lg mb-1">
                                                @if($mentorship->mentor_id === auth()->id())
                                                    Mentoring {{ $mentorship->mentee->name }}
                                                @else
                                                    Mentored by {{ $mentorship->mentor->name }}
                                                @endif
                                            </h3>
                                            <p class="text-gray-600 mb-2">
                                                Started {{ $mentorship->start_date->format('M j, Y') }}
                                                @if($mentorship->end_date)
                                                    • Ended {{ $mentorship->end_date->format('M j, Y') }}
                                                @endif
                                            </p>
                                            <div class="flex flex-wrap gap-2 mb-3">
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded capitalize">
                                                    {{ $mentorship->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <a href="{{ route('mentorship.show', $mentorship) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 mb-4 line-clamp-2">{{ $mentorship->goal }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500 mb-4">You don't have any active mentorships.</p>
                                <a href="{{ route('mentorship.find') }}" class="btn btn-primary">
                                    Find a Mentor
                                </a>
                            </div>
                        @endforelse
                    </div>

                    @if($mentorships->isNotEmpty())
                        <div class="mt-4">
                            {{ $mentorships->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
