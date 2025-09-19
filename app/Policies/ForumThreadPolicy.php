<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ForumThread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Anyone approved can view threads.
     */
    public function view(User $user, ForumThread $thread): bool
    {
        return true;
    }

    /**
     * Only approved users can create threads.
     */
    public function create(User $user): bool
    {
        return $user->is_approved&& $user->hasRole('alumni');
    }

    /**
     * Author or admin can update.
     */
    public function update(User $user, ForumThread $thread): bool
    {
        return $user->id === $thread->user_id || $user->hasRole('admin');
    }

    /**
     * Author or admin can delete.
     */
    public function delete(User $user, ForumThread $thread): bool
    {
        return $user->id === $thread->user_id || $user->hasRole('admin');
    }
}
