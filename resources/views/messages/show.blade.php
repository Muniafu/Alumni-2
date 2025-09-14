@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-semibold text-primary mb-0">
        <i class="fa-solid fa-comments me-2"></i> Conversation
    </h2>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <!-- Messages Container -->
        <div class="card shadow-sm border-0 mb-4" style="height: 500px; overflow-y: auto;">
            <div class="card-body d-flex flex-column gap-3">
                @forelse($messages as $msg)
                    <div class="d-flex {{ $msg->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="p-3 rounded shadow-sm
                            {{ $msg->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light text-dark' }}"
                            style="max-width: 75%;">
                            <small class="fw-bold">{{ $msg->sender->name }}</small>
                            <p class="mb-0 mt-1">{{ $msg->body }}</p>
                            <small class="text-muted d-block mt-1">{{ $msg->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted mt-3">No messages yet. Start the conversation!</p>
                @endforelse
            </div>
        </div>

        <!-- Message Form -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" action="{{ route('messages.store', $conversation) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="body" class="form-label visually-hidden">Message</label>
                        <textarea id="body" name="body" class="form-control" rows="3" placeholder="Type your message..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane me-1"></i> Send
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Optional JS to auto-scroll to the bottom -->
@push('scripts')
<script>
    const messagesContainer = document.querySelector('.card-body.d-flex.flex-column');
    if(messagesContainer){
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
</script>
@endpush
@endsection
