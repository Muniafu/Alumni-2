<?php

namespace App\Policies;

use App\Models\Mentorship;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class MentorshipPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->can('view-mentorship');
    }

    public function before(User $user)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Mentorship $mentorship)
    {

        return $user->id === $mentorship->mentor_id || $user->id === $mentorship->mentee_id;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->can('create-mentorship');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Mentorship $mentorship)
    {

        return $user->id === $mentorship->mentor_id || $user->id === $mentorship->mentee_id;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Mentorship $mentorship)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Mentorship $mentorship)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Mentorship $mentorship)
    {
        //
    }
}
