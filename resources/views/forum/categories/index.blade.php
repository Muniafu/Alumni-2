<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Forum Categories
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($categories as $category)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <a href="{{ route('forum.categories.show', $category) }}"
                               class="text-xl font-bold text-blue-600 hover:text-blue-800">
                                {{ $category->name }}
                            </a>
                            <p class="text-gray-600 mt-2">{{ $category->description }}</p>
                            <div class="mt-2 text-sm text-gray-500">
                                <span>{{ $category->threads_count }} threads</span>
                                <span class="mx-2">•</span>
                                <span>{{ $category->posts_count }} posts</span>
                            </div>
                        </div>
                        @if($category->latestThread)
                            <div class="text-right">
                                <div class="text-sm text-gray-500">
                                    Latest:
                                    <a href="{{ route('forum.threads.show', $category->latestThread) }}"
                                       class="text-blue-600 hover:text-blue-800">
                                        {{ Str::limit($category->latestThread->title, 30) }}
                                    </a>
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $category->latestThread->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
