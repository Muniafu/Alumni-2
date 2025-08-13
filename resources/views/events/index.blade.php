<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900">Upcoming Events</h3>
                <div>
                    <a href="{{ route('events.calendar') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                        {{ __('Calendar View') }}
                    </a>
                    @can('create', App\Models\Event::class)
                        <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                            {{ __('Create Event') }}
                        </a>
                    @endcan
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($events->isEmpty())
                    <div class="p-6 text-gray-500 text-center">
                        No upcoming events found.
                    </div>
                @else
                    <div class="divide-y divide-gray-200">
                        @foreach($events as $event)
                            <div class="p-6 hover:bg-gray-50">
                                <div class="flex flex-col md:flex-row md:items-center">
                                    @if($event->image)
                                        <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                                            <img class="h-32 w-full md:w-48 object-cover rounded-lg" src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}">
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-lg font-semibold text-gray-900">
                                                <a href="{{ route('events.show', $event) }}" class="hover:underline">
                                                    {{ $event->title }}
                                                </a>
                                            </h4>
                                            @if($event->is_online)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Online Event
                                                </span>
                                            @endif
                                        </div>

                                        <div class="mt-2 text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="ml-2">
                                                    {{ $event->start->format('l, F j, Y g:i a') }} to {{ $event->end->format('g:i a') }}
                                                </span>
                                            </div>
                                            @if($event->location)
                                                <div class="flex items-center mt-1">
                                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="ml-2">{{ $event->location }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-4 flex items-center justify-between">
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="ml-2">
                                                    Organized by {{ $event->organizer->name }}
                                                </span>
                                            </div>

                                            <div class="flex items-center">
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                                                </svg>
                                                <span class="ml-2 text-sm text-gray-500">
                                                    {{ $event->attendees_going }} going
                                                    @if($event->capacity)
                                                        ({{ $event->available_spots }} spots left)
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-4">
                        {{ $events->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
