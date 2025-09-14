@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-semibold text-primary mb-0">
        <i class="fa-solid fa-comments me-2"></i> My Conversations
    </h2>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        @if($conversations->isEmpty())
            <div class="alert alert-secondary text-center shadow-sm" role="alert">
                <i class="fa-regular fa-message me-2"></i>No conversations yet. Start connecting with your peers!
            </div>
        @else
            <div class="list-group">
                @foreach($conversations as $conv)
                    @php
                        $otherUser = $conv->user_one->id === auth()->id() ? $conv->user_two : $conv->user_one;
                    @endphp
                    <a href="{{ route('conversations.show', $conv) }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center shadow-sm mb-2 rounded"
                       aria-label="Conversation with {{ $otherUser->name }}">
                        <div>
                            <i class="fa-solid fa-user me-2 text-primary"></i>
                            <span class="fw-medium">Conversation with {{ $otherUser->name }}</span>
                        </div>
                        <small class="text-muted">{{ $conv->messages->last()?->created_at->diffForHumans() ?? 'No messages yet' }}</small>
                    </a>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
