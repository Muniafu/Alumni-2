<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="calendar" class="min-h-[600px]"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: "{{ route('events.calendar.data') }}",
                    eventClick: function(info) {
                        info.jsEvent.preventDefault();
                        if (info.event.url) {
                            window.open(info.event.url, '_self');
                        }
                    },
                    eventContent: function(arg) {
                        const location = arg.event.extendedProps.location;
                        const titleEl = document.createElement('div');
                        titleEl.classList.add('fc-event-title');
                        titleEl.innerHTML = arg.event.title;

                        const locationEl = document.createElement('div');
                        locationEl.classList.add('fc-event-location', 'text-xs', 'mt-1');
                        locationEl.innerHTML = location;

                        const arrayOfDomNodes = [ titleEl, locationEl ];
                        return { domNodes: arrayOfDomNodes };
                    }
                });
                calendar.render();
            });
        </script>
        <style>
            .fc-event {
                cursor: pointer;
                padding: 4px 8px;
                border-radius: 4px;
                margin-bottom: 2px;
            }
            .fc-event-title {
                font-weight: 600;
            }
            .fc-event-location {
                opacity: 0.8;
            }
        </style>
    @endpush
</x-app-layout>
