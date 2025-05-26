<?php

namespace App\Policies;

use App\Models\MentorshipRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MentorshipRequestPolicy
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
    public function view(User $user, MentorshipRequest $mentorshipRequest)
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
     * Determine whether the user can respond a mentorship request.
     */
    public function respond(User $user, MentorshipRequest $request)
    {
        return $user->id === $request->mentor_id && $request->status === 'pending';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MentorshipRequest $mentorshipRequest)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MentorshipRequest $mentorshipRequest)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MentorshipRequest $mentorshipRequest)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MentorshipRequest $mentorshipRequest)
    {
        //
    }
}
