@extends('layouts.app')

@section('header')
<h2 class="fw-semibold text-primary mb-0">
    Forum Categories
</h2>
@endsection

@section('content')
<div class="row g-4 mt-4">
    @forelse($categories as $category)
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-start flex-wrap">
                    <!-- Category Info -->
                    <div>
                        <a href="{{ route('forum.categories.show', $category) }}"
                           class="h5 text-primary text-decoration-none">
                            {{ $category->name }}
                        </a>
                        <p class="text-muted mt-1 mb-1">
                            {{ $category->description }}
                        </p>
                        <small class="text-secondary">
                            {{ $category->threads_count }} {{ Str::plural('thread', $category->threads_count) }}
                            &bull;
                            {{ $category->posts_count }} {{ Str::plural('post', $category->posts_count) }}
                        </small>
                    </div>

                    <!-- Latest Thread Info -->
                    @if($category->latestThread)
                        <div class="text-end mt-2 mt-md-0">
                            <small class="text-muted">Latest:</small>
                            <div>
                                <a href="{{ route('forum.threads.show', $category->latestThread) }}"
                                   class="text-warning text-decoration-none fw-medium"
                                   title="{{ $category->latestThread->title }}">
                                    {{ Str::limit($category->latestThread->title, 30) }}
                                </a>
                            </div>
                            <small class="text-muted d-block">
                                {{ $category->latestThread->created_at->diffForHumans() }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info shadow-sm">
                No categories available.
            </div>
        </div>
    @endforelse
</div>
@endsection
