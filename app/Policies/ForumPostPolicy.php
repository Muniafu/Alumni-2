<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ForumPost;
use App\Models\ForumThread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPostPolicy
{
    use HandlesAuthorization;

    /**
     * Anyone can view posts inside threads.
     */
    public function view(User $user, ForumPost $post): bool
    {
        return true;
    }

    /**
     * Only approved users can create posts,
     * and the thread must not be locked.
     */
    public function create(User $user, ForumThread $thread): bool
    {
        return $user->is_approved && !$thread->is_locked;
    }

    /**
     * Author or admin can update.
     */
    public function update(User $user, ForumPost $post): bool
    {
        return $user->id === $post->user_id || $user->hasRole('admin');
    }

    /**
     * Author or admin can delete.
     */
    public function delete(User $user, ForumPost $post): bool
    {
        return $user->id === $post->user_id || $user->hasRole('admin');
    }
}
