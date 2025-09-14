@extends('layouts.app')

@section('header')
<h2 class="fw-semibold text-primary">
    Edit Thread: {{ $thread->title }}
</h2>
@endsection

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-12 col-md-8">

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" action="{{ route('forum.threads.update', $thread) }}">
                    @csrf
                    @method('PUT')

                    <!-- Thread Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">
                            Thread Title
                        </label>
                        <input type="text" name="title" id="title"
                               value="{{ old('title', $thread->title) }}" required
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Enter thread title">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Thread Content -->
                    <div class="mb-3">
                        <label for="content" class="form-label fw-semibold">
                            Content
                        </label>
                        <textarea name="content" id="content" rows="10" required
                                  class="form-control @error('content') is-invalid @enderror"
                                  placeholder="Update your message here">{{ old('content', $thread->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('forum.threads.show', $thread) }}" class="btn btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Update Thread
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
