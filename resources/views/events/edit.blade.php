<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('events.update', $event) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $event->title)" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Description')" />
                                <x-text-area id="description" class="block mt-1 w-full" name="description">{{ old('description', $event->description) }}</x-text-area>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Start Date/Time -->
                            <div>
                                <x-input-label for="start" :value="__('Start Date & Time')" />
                                <x-text-input id="start" class="block mt-1 w-full" type="datetime-local" name="start"
                                    value="{{ old('start', $event->start->format('Y-m-d\TH:i')) }}" required />
                                <x-input-error :messages="$errors->get('start')" class="mt-2" />
                            </div>

                            <!-- End Date/Time -->
                            <div>
                                <x-input-label for="end" :value="__('End Date & Time')" />
                                <x-text-input id="end" class="block mt-1 w-full" type="datetime-local" name="end"
                                    value="{{ old('end', $event->end->format('Y-m-d\TH:i')) }}" required />
                                <x-input-error :messages="$errors->get('end')" class="mt-2" />
                            </div>

                            <!-- Location -->
                            <div>
                                <x-input-label for="location" :value="__('Location')" />
                                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $event->location)" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <!-- Capacity -->
                            <div>
                                <x-input-label for="capacity" :value="__('Capacity (leave blank for unlimited)')" />
                                <x-text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" :value="old('capacity', $event->capacity)" min="1" />
                                <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                            </div>

                            <!-- Image -->
                            <div>
                                <x-input-label for="image" :value="__('Event Image')" />
                                @if($event->image)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($event->image) }}" alt="Current event image" class="h-32 rounded">
                                    </div>
                                @endif
                                <x-file-input id="image" class="block mt-1 w-full" name="image" />
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>

                            <!-- Online Event -->
                            <div class="flex items-center">
                                <x-checkbox-input id="is_online" name="is_online" :checked="old('is_online', $event->is_online)" />
                                <x-input-label for="is_online" :value="__('This is an online event')" class="ml-2" />
                            </div>

                            <!-- Meeting URL (shown only if online event is checked) -->
                            <div id="meeting_url_container" class="{{ $event->is_online ? '' : 'hidden' }}">
                                <x-input-label for="meeting_url" :value="__('Meeting URL')" />
                                <x-text-input id="meeting_url" class="block mt-1 w-full" type="url" name="meeting_url" :value="old('meeting_url', $event->meeting_url)" />
                                <x-input-error :messages="$errors->get('meeting_url')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Update Event') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('is_online').addEventListener('change', function() {
                const meetingUrlContainer = document.getElementById('meeting_url_container');
                if (this.checked) {
                    meetingUrlContainer.classList.remove('hidden');
                } else {
                    meetingUrlContainer.classList.add('hidden');
                }
            });
        </script>
    @endpush
</x-app-layout>
