<x-app-layout>
    <x-slot name="header">
        <h2>{{ $thread->title }}</h2>
    </x-slot>

    <div class="p-4 bg-white rounded shadow mb-6">
        <p>{{ $thread->body }}</p>
        <small>Posted by {{ $thread->user->name }} in {{ $thread->category->name }}</small>
    </div>

    <h3 class="mb-4">Replies</h3>
    @foreach($posts as $post)
        <div class="p-3 bg-gray-100 rounded mb-2">
            {{ $post->body }}
            <small class="block text-gray-500">By {{ $post->user->name }}</small>
        </div>
    @endforeach

    {{ $posts->links() }}

    <form method="POST" action="{{ route('forum.posts.store', $thread) }}">
        @csrf
        <textarea name="body" class="w-full border rounded p-2 mb-2" rows="3"></textarea>
        <button class="bg-blue-500 text-white px-4 py-2 rounded">Reply</button>
    </form>
</x-app-layout>
