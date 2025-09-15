<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * User can view a message if they are in the conversation it belongs to.
     */
    public function view(User $user, Message $message): bool
    {
        return $message->conversation->users->contains($user->id);
    }

    /**
     * User can create messages if they are a participant in the conversation.
     */
    public function create(User $user, Message $message): bool
    {
        return $message->conversation->users->contains($user->id);
    }

    /**
     * User can delete a message only if they are the author.
     */
    public function delete(User $user, Message $message): bool
    {
        return $message->user_id === $user->id;
    }
}
