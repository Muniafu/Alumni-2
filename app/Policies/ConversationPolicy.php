<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    /**
     * User can view any conversations (just return true since filtering is done in the query).
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * User can view a specific conversation if they are a participant.
     */
    public function view(User $user, Conversation $conversation): bool
    {
        return $conversation->users->contains($user->id);
    }

    /**
     * User can create conversations if they are approved.
     */
    public function create(User $user): bool
    {
        return $user->is_approved;
    }

    /**
     * User can delete a conversation only if they are a participant.
     */
    public function delete(User $user, Conversation $conversation): bool
    {
        return $conversation->users->contains($user->id);
    }
}
