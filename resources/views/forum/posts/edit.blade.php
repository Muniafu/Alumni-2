@extends('layouts.app')

@section('header')
<h2 class="fw-semibold text-primary mb-0">
    Edit Post
</h2>
@endsection

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-12 col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" action="{{ route('forum.posts.update', $post) }}">
                    @csrf
                    @method('PUT')

                    <!-- Post Content -->
                    <div class="mb-4">
                        <label for="content" class="form-label fw-bold text-secondary">
                            Post Content
                        </label>
                        <textarea name="content" id="content" rows="10" required
                                  class="form-control">{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('forum.threads.show', $post->thread) }}"
                           class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Update Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
