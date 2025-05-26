<?php

namespace App\Policies;

use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ForumPost $forumPost)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ForumPost $post)
    {

        return $user->id === $post->user_id || $user->hasRole('admin');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ForumPost $post)
    {

        return $user->id === $post->user_id || $user->hasRole('admin');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ForumPost $forumPost)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ForumPost $forumPost)
    {
        //
    }
}
