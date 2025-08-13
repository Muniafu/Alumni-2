<h2>Conversation</h2>
<div>
    @foreach($messages as $msg)
        <p><strong>{{ $msg->sender->name }}:</strong> {{ $msg->body }}</p>
    @endforeach
</div>

<form method="POST" action="{{ route('messages.store', $conversation) }}">
    @csrf
    <textarea name="body" required></textarea>
    <button type="submit">Send</button>
</form>
