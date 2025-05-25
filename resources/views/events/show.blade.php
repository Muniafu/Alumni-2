<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-bold">{{ $event->title }}</h2>
                            <div class="flex items-center text-sm text-gray-500 mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $event->start->format('l, F j, Y') }} •
                                {{ $event->start->format('g:i A') }} - {{ $event->end->format('g:i A') }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500 mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $event->is_online ? 'Online Event' : $event->location }}
                                @if($event->is_online && $event->meeting_url)
                                    • <a href="{{ $event->meeting_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 ml-1">Join Meeting</a>
                                @endif
                            </div>
                        </div>
                        @can('update', $event)
                        <div class="flex space-x-2">
                            <a href="{{ route('events.edit', $event) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('events.destroy', $event) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
                            </form>
                        </div>
                        @endcan
                    </div>

                    @if($event->image)
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-64 object-cover rounded-lg">
                    </div>
                    @endif

                    <div class="prose max-w-none mb-6">
                        {!! nl2br(e($event->description)) !!}
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-medium text-lg mb-2">Event Details</h3>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-gray-500">Organizer:</span>
                                    <span class="font-medium">{{ $event->organizer->name }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Date:</span>
                                    <span class="font-medium">{{ $event->start->format('F j, Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Time:</span>
                                    <span class="font-medium">{{ $event->start->format('g:i A') }} - {{ $event->end->format('g:i A') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Location:</span>
                                    <span class="font-medium">{{ $event->is_online ? 'Online' : $event->location }}</span>
                                </div>
                                @if($event->capacity)
                                <div>
                                    <span class="text-gray-500">Capacity:</span>
                                    <span class="font-medium {{ $event->isFull() ? 'text-red-500' : '' }}">
                                        {{ $event->attendees_going }} / {{ $event->capacity }} registered
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-medium text-lg mb-2">RSVP</h3>
                            @if($event->isFull())
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                    This event has reached its capacity.
                                </div>
                            @endif

                            @if($userRsvp)
                                <div class="mb-4">
                                    <p class="font-medium">Your RSVP:
                                        <span class="capitalize">{{ $userRsvp->status }}</span>
                                        @if($userRsvp->guests > 0)
                                            + {{ $userRsvp->guests }} guests
                                        @endif
                                    </p>
                                    @if($userRsvp->notes)
                                        <p class="text-sm text-gray-600 mt-1">{{ $userRsvp->notes }}</p>
                                    @endif
                                </div>
                                <form action="{{ route('events.rsvp.cancel', $event) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Cancel RSVP</button>
                                </form>
                            @else
                                @can('rsvp', $event)
                                <form action="{{ route('events.rsvp', $event) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-gray-700 mb-2">Will you attend?</label>
                                        <div class="flex flex-wrap gap-3">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="status" value="going" class="form-radio" checked>
                                                <span class="ml-2">Going</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="status" value="interested" class="form-radio">
                                                <span class="ml-2">Interested</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="status" value="not_going" class="form-radio">
                                                <span class="ml-2">Not Going</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="guests" class="block text-gray-700 mb-2">Number of Guests</label>
                                        <input type="number" id="guests" name="guests" min="0" value="0"
                                            class="form-input rounded-md shadow-sm w-20">
                                    </div>
                                    <div class="mb-4">
                                        <label for="notes" class="block text-gray-700 mb-2">Additional Notes</label>
                                        <textarea id="notes" name="notes" rows="2"
                                            class="form-textarea rounded-md shadow-sm w-full"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit RSVP</button>
                                </form>
                                @else
                                    <p class="text-gray-500">You need to be logged in as an alumni or student to RSVP.</p>
                                @endcan
                            @endif
                        </div>
                    </div>

                    @if($attendees->isNotEmpty())
                    <div class="mt-6">
                        <h3 class="font-medium text-lg mb-4">Attendees ({{ $attendees->count() }})</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($attendees as $rsvp)
                                <div class="flex items-center space-x-3 p-3 border rounded-lg">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">{{ substr($rsvp->user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $rsvp->user->name }}</p>
                                        @if($rsvp->guests > 0)
                                            <p class="text-sm text-gray-500">+{{ $rsvp->guests }} guests</p>
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
