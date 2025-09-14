@extends('layouts.app')

@section('header')
<h2 class="fw-semibold text-primary">
    Create New Thread in {{ $category->name }}
</h2>
@endsection

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-12 col-md-8">

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" action="{{ route('forum.threads.store', $category) }}">
                    @csrf

                    <!-- Thread Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">
                            Thread Title
                        </label>
                        <input type="text" name="title" id="title" required
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Enter your thread title">
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
                                  placeholder="Write your message here"></textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            Create Thread
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
