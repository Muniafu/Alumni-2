<h2>My Conversations</h2>
@foreach($conversations as $conv)
    @php
        $otherUser = $conv->user_one->id === auth()->id() ? $conv->user_two : $conv->user_one;
    @endphp
    <a href="{{ route('conversations.show', $conv) }}">
        Conversation with {{ $otherUser->name }}
    </a>
@endforeach
