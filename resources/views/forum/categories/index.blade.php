<x-app-layout>
    <x-slot name="header">
        <h2>Forum Categories</h2>
    </x-slot>

    <div class="py-6">
        @foreach($categories as $category)
            <div class="mb-4 p-4 bg-white rounded shadow">
                <a href="{{ route('forum.categories.show', $category) }}" class="text-lg font-bold">
                    {{ $category->name }}
                </a>
                <p>{{ $category->description }}</p>
                <span class="text-sm text-gray-500">{{ $category->threads_count }} threads</span>
            </div>
        @endforeach
    </div>
</x-app-layout>
