<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Event Calendar
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Event Calendar</h2>
                        @can('create', App\Models\Event::class)
                        <a href="{{ route('events.create') }}" class="btn btn-primary">
                            Create New Event
                        </a>
                        @endcan
                    </div>

                    <div id="calendar" class="mb-4"></div>

                    <div class="mt-4">
                        <a href="{{ route('events.index') }}" class="text-blue-600 hover:text-blue-800">
                            View List of Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <style>
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }
        .fc-event {
            cursor: pointer;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {
                    url: '{{ route("events.calendar.data") }}',
                    method: 'GET',
                    failure: function() {
                        alert('There was an error fetching events!');
                    }
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) {
                        window.open(info.event.url, '_self');
                    }
                }
            });
            calendar.render();
        });
    </script>
    @endpush
</x-app-layout>
