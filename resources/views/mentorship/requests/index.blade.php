<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mentorship Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Received Requests</h3>

                        @if($receivedRequests->isNotEmpty())
                            <div class="space-y-4">
                                @foreach($receivedRequests as $request)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-medium">{{ $request->mentee->name }}</h4>
                                                <p class="text-sm text-gray-600">Student • {{ $request->mentee->program }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($request->status === 'accepted') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </div>

                                        <div class="mt-3">
                                            <h5 class="text-sm font-medium">Goal:</h5>
                                            <p class="text-gray-700 whitespace-pre-line">{{ $request->goal }}</p>
                                        </div>

                                        <div class="mt-3">
                                            <h5 class="text-sm font-medium">Message:</h5>
                                            <p class="text-gray-700 whitespace-pre-line">{{ $request->message }}</p>
                                        </div>

                                        @if($request->status === 'pending')
                                            <div class="mt-4 flex space-x-3">
                                                <form action="{{ route('mentorship.requests.accept', $request) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        Accept Request
                                                    </button>
                                                </form>
                                                <form action="{{ route('mentorship.requests.reject', $request) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        Decline
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                {{ $receivedRequests->links() }}
                            </div>
                        @else
                            <p class="text-gray-500">You have no received mentorship requests.</p>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-lg font-medium mb-4">Sent Requests</h3>

                        @if($sentRequests->isNotEmpty())
                            <div class="space-y-4">
                                @foreach($sentRequests as $request)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-medium">{{ $request->mentor->name }}</h4>
                                                <p class="text-sm text-gray-600">Alumni • {{ $request->mentor->profile->current_job ?? 'No job specified' }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($request->status === 'accepted') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </div>

                                        <div class="mt-3">
                                            <h5 class="text-sm font-medium">Goal:</h5>
                                            <p class="text-gray-700 whitespace-pre-line">{{ $request->goal }}</p>
                                        </div>

                                        <div class="mt-3">
                                            <h5 class="text-sm font-medium">Message:</h5>
                                            <p class="text-gray-700 whitespace-pre-line">{{ $request->message }}</p>
                                        </div>

                                        @if($request->status === 'accepted')
                                            <div class="mt-3">
                                                <a href="{{ route('mentorship.show', $request->mentorship) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                                    View Mentorship Details
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                {{ $sentRequests->links() }}
                            </div>
                        @else
                            <p class="text-gray-500">You haven't sent any mentorship requests.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
