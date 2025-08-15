<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Conversations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('conversations.create') }}" class="btn btn-primary mb-4">
                        Start New Conversation
                    </a>

                    <div class="space-y-4">
                        @forelse($conversations as $conversation)
                            <div class="border rounded-lg p-4 hover:bg-gray-50">
                                <a href="{{ route('conversations.show', $conversation) }}" class="block">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            @foreach($conversation->otherUsers as $user)
                                                <span class="font-semibold">{{ $user->name }}</span>
                                                @if(!$loop->last), @endif
                                            @endforeach
                                        </div>
                                        <span class="text-sm text-gray-500">
                                            {{ $conversation->latestMessage->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 mt-1 truncate">
                                        {{ $conversation->latestMessage->body }}
                                    </p>
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500">No conversations yet.</p>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $conversations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
