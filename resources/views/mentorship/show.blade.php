<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mentorship Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-bold">
                                @if($mentorship->mentor_id === auth()->id())
                                    Mentoring {{ $mentorship->mentee->name }}
                                @else
                                    Mentored by {{ $mentorship->mentor->name }}
                                @endif
                            </h2>
                            <p class="text-gray-600">
                                Started {{ $mentorship->start_date->format('M j, Y') }}
                                @if($mentorship->end_date)
                                    • Ended {{ $mentorship->end_date->format('M j, Y') }}
                                @endif
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($mentorship->status === 'active') bg-green-100 text-green-800
                            @elseif($mentorship->status === 'completed') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($mentorship->status) }}
                        </span>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-2">Mentor Details</h3>
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-gray-600 text-xl">
                                            {{ substr($mentorship->mentor->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-medium">{{ $mentorship->mentor->name }}</h4>
                                    <p class="text-gray-600 text-sm">
                                        {{ $mentorship->mentor->profile->current_job ?? 'No job specified' }}
                                    </p>
                                    <p class="text-gray-600 text-sm">
                                        {{ $mentorship->mentor->profile->company ?? 'No company specified' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg mb-2">Mentee Details</h3>
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-gray-600 text-xl">
                                            {{ substr($mentorship->mentee->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-medium">{{ $mentorship->mentee->name }}</h4>
                                    <p class="text-gray-600 text-sm">
                                        Class of {{ $mentorship->mentee->graduation_year ?? 'N/A' }}
                                    </p>
                                    <p class="text-gray-600 text-sm">
                                        {{ $mentorship->mentee->program ?? 'No program specified' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="font-semibold text-lg mb-2">Mentorship Goal</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $mentorship->goal }}</p>
                    </div>

                    @if($mentorship->mentor_id === auth()->id() || $mentorship->mentee_id === auth()->id())
                        <div class="border-t pt-4">
                            <h3 class="font-semibold text-lg mb-2">Update Mentorship Status</h3>
                            <form action="{{ route('mentorship.update', $mentorship) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="active" @if($mentorship->status === 'active') selected @endif>Active</option>
                                            <option value="completed" @if($mentorship->status === 'completed') selected @endif>Completed</option>
                                            <option value="cancelled" @if($mentorship->status === 'cancelled') selected @endif>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $mentorship->notes) }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Update Status
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
