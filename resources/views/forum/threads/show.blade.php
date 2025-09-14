@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-semibold text-primary mb-0">
        {{ $thread->title }}
    </h2>

    @can('update', $thread)
    <div class="d-flex gap-2">
        <a href="{{ route('forum.threads.edit', $thread) }}" class="btn btn-primary btn-sm">
            Edit
        </a>
        <form action="{{ route('forum.threads.destroy', $thread) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Are you sure you want to delete this thread?')">
                Delete
            </button>
        </form>
    </div>
    @endcan
</div>
@endsection

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-12 col-md-8">

        <!-- Subscribe / Subscriber Info -->
        <div class="d-flex align-items-center mb-3 gap-2">
            @if(auth()->check())
                @if($thread->isSubscribed())
                    <form action="{{ route('forum.threads.unsubscribe', $thread) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            Unsubscribe
                        </button>
                    </form>
                @else
                    <form action="{{ route('forum.threads.subscribe', $thread) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            Subscribe
                        </button>
                    </form>
                @endif
            @endif
            <span class="text-muted small">
                {{ $thread->subscribers()->count() }} {{ Str::plural('subscriber', $thread->subscribers()->count()) }}
            </span>
        </div>

        <!-- Thread Content -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <h5 class="card-title fw-bold">{{ $thread->title }}</h5>
                        <p class="card-subtitle text-muted small">
                            Posted by {{ $thread->author->name }} in
                            <a href="{{ route('forum.categories.show', $thread->category) }}" class="link-primary">
                                {{ $thread->category->name }}
                            </a>
                            • {{ $thread->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @if($thread->is_pinned)
                        <span class="badge bg-warning text-dark align-self-start">Pinned</span>
                    @endif
                </div>
                <p class="card-text">
                    {!! nl2br(e($thread->content)) !!}
                </p>
            </div>
        </div>

        <!-- Replies Section -->
        <h4 class="fw-semibold mb-3">Replies ({{ $thread->posts_count }})</h4>

        @foreach($posts as $post)
            <div id="post-{{ $post->id }}" class="card mb-3 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <p class="fw-bold mb-0">{{ $post->author->name }}</p>
                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                        </div>
                        @can('update', $post)
                            <div class="d-flex gap-2">
                                <a href="{{ route('forum.posts.edit', $post) }}" class="link-primary small">Edit</a>
                                <form action="{{ route('forum.posts.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0 small"
                                            onclick="return confirm('Are you sure you want to delete this post?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                    <p class="card-text">{!! nl2br(e($post->content)) !!}</p>
                </div>
            </div>
        @endforeach

        {{ $posts->links() }}

        <!-- Reply Form -->
        @can('create', App\Models\ForumPost::class)
        <div class="card mt-4 shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Post a Reply</h5>
                <form method="POST" action="{{ route('forum.posts.store', $thread) }}">
                    @csrf
                    <div class="mb-3">
                        <textarea name="content" rows="5" required class="form-control"></textarea>
                        @error('content')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Post Reply</button>
                    </div>
                </form>
            </div>
        </div>
        @endcan

    </div>
</div>
@endsection
