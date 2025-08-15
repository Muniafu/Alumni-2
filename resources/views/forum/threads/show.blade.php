<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $thread->title }}
            </h2>
            @can('update', $thread)
                <div class="space-x-2">
                    <a href="{{ route('forum.threads.edit', $thread) }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                    <form action="{{ route('forum.threads.destroy', $thread) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                onclick="return confirm('Are you sure you want to delete this thread?')">
                            Delete
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center space-x-4 mb-4">
                @if(auth()->check())
                    @if($thread->isSubscribed())
                        <form action="{{ route('forum.threads.unsubscribe', $thread) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-1 px-3 rounded">
                                Unsubscribe
                            </button>
                        </form>
                    @else
                        <form action="{{ route('forum.threads.subscribe', $thread) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold py-1 px-3 rounded">
                                Subscribe
                            </button>
                        </form>
                    @endif
                @endif
                <span class="text-sm text-gray-500">
                    {{ $thread->subscribers()->count() }} {{ Str::plural('subscriber', $thread->subscribers()->count()) }}
                </span>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $thread->title }}</h3>
                        <p class="text-sm text-gray-600">
                            Posted by {{ $thread->author->name }} in
                            <a href="{{ route('forum.categories.show', $thread->category) }}"
                               class="text-blue-600 hover:text-blue-800">
                                {{ $thread->category->name }}
                            </a>
                            • {{ $thread->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @if($thread->is_pinned)
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                            Pinned
                        </span>
                    @endif
                </div>
                <div class="prose max-w-none">
                    {!! nl2br(e($thread->content)) !!}
                </div>
            </div>

            <h3 class="text-xl font-semibold mb-4">Replies ({{ $thread->posts_count }})</h3>

            @foreach($posts as $post)
                <div id="post-{{ $post->id }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 p-6">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="text-sm font-semibold">{{ $post->author->name }}</p>
                            <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                        @can('update', $post)
                            <div class="space-x-2">
                                <a href="{{ route('forum.posts.edit', $post) }}"
                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('forum.posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-800 text-sm"
                                            onclick="return confirm('Are you sure you want to delete this post?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                    <div class="prose max-w-none">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
            @endforeach

            {{ $posts->links() }}

            @can('create', App\Models\ForumPost::class)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6 p-6">
                    <h4 class="text-lg font-semibold mb-4">Post a Reply</h4>
                    <form method="POST" action="{{ route('forum.posts.store', $thread) }}">
                        @csrf
                        <div class="mb-4">
                            <textarea name="content" rows="5" required
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Post Reply
                            </button>
                        </div>
                    </form>
                </div>
            @endcan
        </div>
    </div>
</x-app-layout>
