<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $category->name }} - Threads
            </h2>
            @can('create', App\Models\ForumThread::class)
                <a href="{{ route('forum.threads.create', $category) }}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    New Thread
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($threads as $thread)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <a href="{{ route('forum.threads.show', $thread) }}"
                               class="text-lg font-bold text-blue-600 hover:text-blue-800">
                                @if($thread->is_pinned)
                                    📌 {{ $thread->title }}
                                @else
                                    {{ $thread->title }}
                                @endif
                            </a>
                            <p class="text-sm text-gray-600 mt-1">
                                Started by {{ $thread->author->name }} •
                                {{ $thread->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="text-sm text-gray-500">
                                {{ $thread->posts_count }} {{ Str::plural('reply', $thread->posts_count) }}
                            </span>
                            @if($thread->latestPost)
                                <div class="text-xs text-gray-400">
                                    Last reply {{ $thread->latestPost->created_at->diffForHumans() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $threads->links() }}
        </div>
    </div>
</x-app-layout>
