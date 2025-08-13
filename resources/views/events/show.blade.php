<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $event->title }}</h1>
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                <span class="ml-2">
                                    Organized by {{ $event->organizer->name }}
                                </span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            @can('update', $event)
                                <x-secondary-button-link href="{{ route('events.edit', $event) }}">
                                    Edit
                                </x-secondary-button-link>
                            @endcan
                            @can('delete', $event)
                                <form method="POST" action="{{ route('events.destroy', $event) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button type="submit">
                                        Delete
                                    </x-danger-button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            @if($event->image)
                                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-64 object-cover rounded-lg">
                            @endif

                            <div class="mt-6 prose max-w-none">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>

                        <div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="space-y-4">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">When</h3>
                                        <div class="mt-2 flex items-center text-sm text-gray-600">
                                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="ml-2">
                                                {{ $event->start->format('l, F j, Y') }}<br>
                                                {{ $event->start->format('g:i a') }} to {{ $event->end->format('g:i a') }}
                                            </span>
                                        </div>
                                    </div>

                                    @if($event->is_online)
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">Where</h3>
                                            <div class="mt-2 flex items-center text-sm text-gray-600">
                                                <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="ml-2">
                                                    Online Event<br>
                                                    <a href="{{ $event->meeting_url }}" target="_blank" class="text-blue-600 hover:underline">
                                                        Join Meeting
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    @elseif($event->location)
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">Where</h3>
                                            <div class="mt-2 flex items-center text-sm text-gray-600">
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="ml-2">{{ $event->location }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Attendees</h3>
                                        <div class="mt-2 flex items-center text-sm text-gray-600">
                                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                                            </svg>
                                            <span class="ml-2">
                                                {{ $event->attendees_going }} going
                                                @if($event->capacity)
                                                    ({{ $event->available_spots }} spots left)
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    @if($event->isFull())
                                        <div class="bg-red-50 border-l-4 border-red-400 p-4">
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm text-red-700">
                                                        This event is at capacity.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($userRsvp)
                                        <div class="space-y-4">
                                            <div class="bg-green-50 border-l-4 border-green-400 p-4">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm text-green-700">
                                                            You're {{ $userRsvp->status }} this event.
                                                            @if($userRsvp->guests > 0)
                                                                <br>Bringing {{ $userRsvp->guests }} guest(s).
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <form method="POST" action="{{ route('events.rsvp.cancel', $event) }}">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button class="w-full justify-center">
                                                    Cancel RSVP
                                                </x-danger-button>
                                            </form>
                                        </div>
                                    @else
                                        <form method="POST" action="{{ route('events.rsvp', $event) }}">
                                            @csrf
                                            <div class="space-y-4">
                                                <div>
                                                    <x-input-label for="status" :value="__('RSVP Status')" />
                                                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                        <option value="going">I'm Going</option>
                                                        <option value="interested">Interested</option>
                                                        <option value="not_going">Not Going</option>
                                                    </select>
                                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                                </div>

                                                <div>
                                                    <x-input-label for="guests" :value="__('Number of Guests')" />
                                                    <x-text-input id="guests" class="block mt-1 w-full" type="number" name="guests" :value="old('guests', 0)" min="0" />
                                                    <x-input-error :messages="$errors->get('guests')" class="mt-2" />
                                                </div>

                                                <div>
                                                    <x-input-label for="notes" :value="__('Notes (optional)')" />
                                                    <x-text-area id="notes" class="block mt-1 w-full" name="notes">{{ old('notes') }}</x-text-area>
                                                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                                                </div>

                                                <x-primary-button class="w-full justify-center">
                                                    Submit RSVP
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($attendees->isNotEmpty())
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900">Who's Going</h3>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($attendees as $rsvp)
                                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full" src="{{ $rsvp->user->profile_photo_url }}" alt="{{ $rsvp->user->name }}">
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $rsvp->user->name }}
                                            </p>
                                            @if($rsvp->guests > 0)
                                                <p class="text-sm text-gray-500">
                                                    +{{ $rsvp->guests }} guest(s)
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
