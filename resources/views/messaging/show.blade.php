<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Conversation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">
                            @foreach($conversation->otherUsers as $user)
                                {{ $user->name }}
                                @if(!$loop->last), @endif
                            @endforeach
                        </h3>
                        @if($conversation->subject)
                            <p class="text-gray-600">{{ $conversation->subject }}</p>
                        @endif
                    </div>

                    <div class="space-y-4 mb-6">
                        @foreach($messages as $message)
                            <div class="flex {{ $message->sender->id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="{{ $message->sender->id === auth()->id() ? 'bg-blue-100' : 'bg-gray-100' }} rounded-lg p-3 max-w-xs lg:max-w-md">
                                    <div class="flex items-center mb-1">
                                        <span class="font-semibold">{{ $message->sender->name }}</span>
                                        <span class="text-xs text-gray-500 ml-2">
                                            {{ $message->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-gray-800">{{ $message->body }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $messages->links() }}
                    </div>

                    <form method="POST" action="{{ route('messages.store', $conversation) }}" class="mt-6">
                        @csrf
                        <div class="mb-4">
                            <textarea name="body" rows="3" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Type your message here..."></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
