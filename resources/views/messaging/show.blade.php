@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-semibold text-primary mb-0">
        <i class="fa-solid fa-comments me-2"></i> Conversation
    </h2>
</div>
@endsection

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-8">

        <!-- Conversation Header -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-semibold mb-1">
                    @foreach($conversation->otherUsers as $user)
                        {{ $user->name }}@if(!$loop->last), @endif
                    @endforeach
                </h5>
                @if($conversation->subject)
                    <p class="text-muted mb-0">{{ $conversation->subject }}</p>
                @endif
            </div>
        </div>

        <!-- Messages Container -->
        <div class="card shadow-sm border-0 mb-4" style="height: 500px; overflow-y: auto;">
            <div class="card-body d-flex flex-column gap-3">
                @forelse($messages as $message)
                    <div class="d-flex {{ $message->sender->id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="p-3 rounded shadow-sm
                            {{ $message->sender->id === auth()->id() ? 'bg-primary text-white' : 'bg-light text-dark' }}"
                            style="max-width: 75%;">
                            <div class="d-flex align-items-center mb-1">
                                <span class="fw-bold">{{ $message->sender->name }}</span>
                                <small class="text-muted ms-2">{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0">{{ $message->body }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted mt-3">No messages yet. Start the conversation!</p>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="mb-3">
            {{ $messages->links() }}
        </div>

        <!-- Send Message Form -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" action="{{ route('messages.store', $conversation) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="body" class="form-label visually-hidden">Message</label>
                        <textarea id="body" name="body" rows="3" class="form-control" placeholder="Type your message here..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-paper-plane me-1"></i> Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    // Auto-scroll to the bottom of messages
    const messagesContainer = document.querySelector('.card-body.d-flex.flex-column');
    if(messagesContainer){
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
</script>
@endpush
@endsection
